<?php

namespace App\Http\Controllers;

use App\Models\CustomerAddress;
use App\Models\Payment;
use App\Models\PaymentMode;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    private function redirectWithTab($tab)
    {
        $url = url()->previous();

        // parse existing query params
        $query = parse_url($url, PHP_URL_QUERY);
        parse_str($query, $params);

        // set / replace tab
        $params['tab'] = $tab;

        // rebuild URL
        $baseUrl = strtok($url, '?');
        $newUrl = $baseUrl . '?' . http_build_query($params);

        return $newUrl;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $records = User::with([
                'subscriptions' => function ($q) {
                    $q->with('plan:id,name')
                        ->select('id', 'customer_id', 'plan_id', 'start_date', 'end_date')
                        ->where('is_active', 1);
                }
            ])
            ->where('role', 'customer')
            ->when($request->name !== null, function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            })
            ->when($request->mobile !== null, function ($q) use ($request) {
                $q->where('mobile', 'like', '%' . $request->mobile . '%');
            })
            ->when($request->status !== null, function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->latest()
            ->paginate(getSetting('page_limit'));
        return view('panel.customers.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userData = $request->validate([
            'name'=>'required|string|max:255',
            'mobile'=>'required|digits:10|unique:users,mobile',
            'alt_mobile'=>'nullable|digits:10',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6',
            'gender'=>'nullable|in:male,female,other',
            'dob'=>'nullable|date',
            'profile_pic'=>'nullable|mimes:jpg,jpeg,png,webp|max:2048',
            'status'=>'required|in:active,inactive,suspended',
        ]);

        try {
            if($request->hasFile('profile_pic')){
                $userData['profile_pic'] = uploadFile($request->profile_pic, 'customers/');
            }

            $userData['password'] = Hash::make($request->password);
            $userData['role'] = 'customer';
            unset($userData['dob']);
            $userData['dob'] = formatDateToYmd($request->dob);
            $user = User::create($userData);

            return to_route('customers.index')->with('success', 'Customer added successfully!');
        } catch (\Exception $ex) {
            Log::error('Customer create error: ', [
                'ex' => $ex->getMessage(),
                'method' => __METHOD__,
                'line' => __LINE__
            ]);
            return back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $customer)
    {
        $plans = Plan::select('id', 'name','price','total_days','meal_time')->where('is_active', 1)->get();
        $paymentModes = PaymentMode::where('is_active', 1)->pluck('name','id');
        return view('panel.customers.show', compact('customer', 'plans', 'paymentModes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $customer)
    {
        return view('panel.customers.create', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $customer)
    {
        $userData = $request->validate([
            'name'=>'required|string|max:255',
            'mobile'=>'required|digits:10|unique:users,mobile,'.$customer->id,
            'alt_mobile'=>'nullable|digits:10',
            'email'=>'required|email|unique:users,email,'.$customer->id,
            'gender'=>'nullable|in:male,female,other',
            'dob'=>'nullable|date',
            'profile_pic'=>'nullable|mimes:jpg,jpeg,png,webp|max:2048',
            'status'=>'required|in:active,inactive,suspended',
        ]);

        try {
            if($request->hasFile('profile_pic')){
                deleteFile($customer->profile_pic,'customers/');
                $userData['profile_pic'] = uploadFile($request->profile_pic, 'customers/');
            }
            $userData['dob'] = formatDateToYmd($request->dob);
            $customer->update($userData);
            return back()->with('success', 'Customer updated successfully!');
        } catch (\Exception $e) {
            Log::error('Customer update error: ', [
                'exception' => $e->getMessage(),
                'method' => __METHOD__,
                'line' => __LINE__,
            ]);
            return back()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function planStore(Request $request)
    {
        $request->validate([
            'plan_id'              => 'required|exists:plans,id',
            'customer_address_id'  => 'required|exists:customer_addresses,id',
            'offer_price'          => 'required|numeric|min:0',
            'start_date'           => 'required|date',

            'payment_mode_id'      => 'required|exists:payment_modes,id',
            'amount'               => 'required|numeric|min:0',
            'date'                 => 'required|date',
        ]);

        $url = $this->redirectWithTab('subscriptions');
        try {
            $plan = Plan::findOrFail($request->plan_id);

            // End Date Calculate
            $startDate = Carbon::parse($request->start_date);
            $endDate   = $startDate->copy()->addDays($plan->total_days - 1);

            // Check Existing Subscription Date Overlap
            $alreadyExists = Subscription::where('customer_id', $request->customer_id)
                //->where('plan_id', $request->plan_id) // at a time one plan
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('start_date', [$startDate, $endDate])
                        ->orWhereBetween('end_date', [$startDate, $endDate])
                        ->orWhere(function ($q) use ($startDate, $endDate) {
                            $q->where('start_date', '<=', $startDate)
                                ->where('end_date', '>=', $endDate);

                        });

                })
                ->exists();

            if ($alreadyExists) {
                return back()->with('error', 'Same plan already exists for selected date range.');
            }

            // Payment Status
            $paymentStatus = 'pending';

            if ($request->amount >= $request->offer_price) {
                $paymentStatus = 'paid';
            } elseif ($request->amount > 0) {
                $paymentStatus = 'partial';
            }

            // Subscription Create
            $subscription = Subscription::create([
                'vendor_id'           => $plan->vendor_id,
                'customer_id'         => $request->customer_id,
                'plan_id'             => $plan->id,
                'customer_address_id' => $request->customer_address_id,
                'price'               => $plan->price,
                'offer_price'         => $request->offer_price,
                'start_date'          => $startDate,
                'end_date'            => $endDate,
                'paymwnt_status'      => $paymentStatus,
                'is_active'           => true,
            ]);

            // Payment Create
            Payment::create([
                'subscription_id' => $subscription->id,
                'payment_mode_id' => $request->payment_mode_id,
                'vendor_id'       => $plan->vendor_id,
                'customer_id'     => $request->customer_id,
                'amount'          => $request->amount,
                'date'            => Carbon::parse($request->date),
            ]);
            return redirect($url)->with('success', 'Subscription added successfully!');

        } catch (\Exception $e) {
            Log::error('Subscription Store Error', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
            ]);

            return redirect($url)->with('error', 'Something went wrong!');
        }
    }

    public function updateSubscriptionStatus($id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->update([
            'is_active' => !$subscription->is_active
        ]);

        return back()->with(
            'success',
            'Subscription status updated successfully!'
        );
    }

    public function paymentStore(Request $request)
    {
        $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',
            'payment_mode_id' => 'required|exists:payment_modes,id',
            'amount'          => 'required|numeric|min:1',
            'date'            => 'required|date',
        ]);
    
        try {
            $subscription = Subscription::findOrFail($request->subscription_id);

            $paidAmount = $subscription->payments()->sum('amount');
            $remainingAmount = $subscription->offer_price - $paidAmount;
            if ($request->amount > $remainingAmount) {
                return back()->with(
                    'error',
                    'Amount exceeds remaining balance.'
                );
            }

            // Create Payment
            Payment::create([
                'subscription_id' => $subscription->id,
                'payment_mode_id' => $request->payment_mode_id,
                'vendor_id'       => $subscription->vendor_id,
                'customer_id'     => $subscription->customer_id,
                'amount'          => $request->amount,
                'date'            => formatDateToYmd($request->date),
            ]);

            // Final Paid Amount
            $finalPaid = $paidAmount + $request->amount;

            // Update Payment Status
            if ($finalPaid >= $subscription->offer_price) {
                $subscription->update([
                    'paymwnt_status' => 'paid'
                ]);
            } else {
                $subscription->update([
                    'paymwnt_status' => 'partial'
                ]);
            }

            return back()->with(
                'success',
                'Payment added successfully!'
            );

        } catch (\Exception $e) {
            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }

    public function subscriptionDestroy($id){
        $subscription = Subscription::findOrFail($id);

        $subscription->delete();

        return back()->with(
            'success',
            'Subscription deleted successfully!'
        );
    }

    public function addressStore(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'state_id'    => 'required|exists:states,id',
            'city_id'     => 'required|exists:cities,id',
            'area_id'     => 'required|exists:areas,id',
            'pincode'     => 'required|digits:6',
            'address'     => 'required|string|max:500',
            'latitude'    => 'nullable|string|max:40',
            'longitude'   => 'nullable|string|max:40',
            'is_default'  => 'required|in:yes,no',
        ]);

        $url = $this->redirectWithTab('addresses');
        try {
            // If selected as default then remove previous default
            if ($request->is_default == 'yes') {
                CustomerAddress::where('user_id', $request->customer_id)
                    ->update([
                        'is_default' => 'no'
                    ]);
            }

            $address = CustomerAddress::create([
                'user_id'     => $request->customer_id,
                'state_id'    => $request->state_id,
                'city_id'     => $request->city_id,
                'area_id'     => $request->area_id,
                'pincode'     => $request->pincode,
                'address'     => $request->address,
                'latitude'    => $request->latitude,
                'longitude'   => $request->longitude,
                'is_default'  => $request->is_default ?? 'no',
            ]);
            return redirect($url)->with('success', 'Address added successfully!');

        } catch (\Exception $e) {
            Log::error('Customer Address Store Error', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
            ]);
            return redirect($url)->with('error', 'Something went wrong!');
        }
    }

    public function customerSearch(Request $request)
    {
        $records = User::select('id', 'name', 'mobile')
            ->where('role', 'customer')
            ->where('name', 'like', "%" . $request->customer . "%")
            ->orWhere('mobile', 'like', "%" . $request->customer . "%")
            ->get();
        return $records;
    }
}
