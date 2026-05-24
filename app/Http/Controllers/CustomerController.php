<?php

namespace App\Http\Controllers;

use App\Models\CustomerAddress;
use App\Models\User;
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
        $records = User::where('role', 'customer')
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
        return view('panel.customers.show', compact('customer'));
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
}
