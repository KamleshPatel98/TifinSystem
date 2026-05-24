<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
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
}
