<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class VendorController extends Controller
{
    private function vendorQuery(Request $request)
    {
        return Vendor::with('state:id,name', 'city:id,name')

            ->when($request->bussiness_name, function ($q) use ($request) {
                $q->where('bussiness_name', 'like', '%' . $request->bussiness_name . '%');
            })

            ->when($request->phone_number, function ($q) use ($request) {
                $q->where('phone_number', 'like', '%' . $request->phone_number . '%');
            })

            ->when($request->status, function ($q) use ($request) {
                $q->where('status', $request->status);
            })

            ->when($request->approved_status, function ($q) use ($request) {
                $q->where('approved_status', $request->approved_status);
            });
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $records = $this->vendorQuery($request)
            ->paginate(getSetting('page_limit'));
        $list = 'All';
        return view('panel.vendors.index', compact('records', 'list'));
    }

    /**
     * Joining Requests (Pending Approval)
     */
    public function joiningRequest(Request $request)
    {
        $records = $this->vendorQuery($request)
            ->where('approved_status', 'pending')
            ->paginate(getSetting('page_limit'));
        $list = 'Joining Request';
        return view('panel.vendors.index', compact('records', 'list'));
    }

    /**
    * Resignation Requests List
    s*/
    public function resignationRequest(Request $request)
    {
        $records = $this->vendorQuery($request)
            ->whereNotNull('resignation_request_status')
            ->paginate(getSetting('page_limit'));
        $list = 'Resignation Request';
        return view('panel.vendors.index', compact('records', 'list'));
    }

    /**
     * suspended Vendors List
     */
    public function suspendedList(Request $request)
    {
        $records = $this->vendorQuery($request)
            ->whereRelation('user','status', 'suspended')
            ->paginate(getSetting('page_limit'));
        $list = 'Suspended';
        return view('panel.vendors.index', compact('records', 'list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.vendors.create');
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

        $vendorData = $request->validate([
            'owner_aadhar_card_front_photo'=>'required|mimes:jpg,jpeg,png,webp|max:2048',
            'owner_aadhar_card_back_photo'=>'required|mimes:jpg,jpeg,png,webp|max:2048',
            'owner_pan_card_photo'=>'nullable|mimes:jpg,jpeg,png,webp|max:2048',
            'bussiness_name'=>'required|string|max:255',
            'logo'=>'nullable|mimes:jpg,jpeg,png,webp|max:2048',
            'phone_number'=>'required|digits:10',
            'state_id'=>'required|exists:states,id',
            'city_id'=>'required|exists:cities,id',
            'area_id'=>'nullable|exists:areas,id',
            'pincode'=>'required|digits:6',
            'address'=>'required|string',
            'latitude'=>'nullable',
            'longitude'=>'nullable',
            'approved_status'=>'required|in:pending,approved,rejected',
        ]);

        try {
            // Upload Files
            if($request->hasFile('profile_pic')){
                $userData['profile_pic'] = uploadFile($request->profile_pic, 'vendors/');
            }

            if($request->hasFile('logo')){
                $vendorData['logo'] = uploadFile($request->logo, 'vendors/');
            }

            if($request->hasFile('owner_aadhar_card_front_photo')){
                $vendorData['owner_aadhar_card_front_photo'] = uploadFile($request->owner_aadhar_card_front_photo, 'vendors/');
            }

            if($request->hasFile('owner_aadhar_card_back_photo')){
                $vendorData['owner_aadhar_card_back_photo'] = uploadFile($request->owner_aadhar_card_back_photo, 'vendors/');
            }

            if($request->hasFile('owner_pan_card_photo')){
                $vendorData['owner_pan_card_photo'] = uploadFile($request->owner_pan_card_photo, 'vendors/');
            }

            $userData['password'] = Hash::make($request->password);
            $userData['role'] = 'vendor';
            unset($userData['dob']);
            $userData['dob'] = formatDateToYmd($request->dob);
            $user = User::create($userData);

            $vendorData['user_id'] = $user->id;
            $vendor = Vendor::create($vendorData);

            return to_route('vendors.index')->with('success', 'Vendor created successfully.');
        } catch (\Exception $e) {
            Log::error('Vendor create error: ', [
                'exception' => $e->getMessage(),
                'method' => __METHOD__,
                'line' => __LINE__,
            ]);
            return back()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Vendor $vendor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vendor $vendor)
    {
        return view('panel.vendors.create', compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vendor $vendor)
    {
        $userData = $request->validate([
            'name'=>'required|string|max:255',
            'mobile'=>'required|digits:10|unique:users,mobile,'.$vendor->user_id,
            'alt_mobile'=>'nullable|digits:10',
            'email'=>'required|email|unique:users,email,'.$vendor->user_id,
            'gender'=>'nullable|in:male,female,other',
            'dob'=>'nullable|date',
            'profile_pic'=>'nullable|mimes:jpg,jpeg,png,webp|max:2048',
            'status'=>'required|in:active,inactive,suspended',
        ]);

        $vendorData = $request->validate([
            'owner_aadhar_card_front_photo'=>'nullable|mimes:jpg,jpeg,png,webp|max:2048',
            'owner_aadhar_card_back_photo'=>'nullable|mimes:jpg,jpeg,png,webp|max:2048',
            'owner_pan_card_photo'=>'nullable|mimes:jpg,jpeg,png,webp|max:2048',
            'bussiness_name'=>'required|string|max:255',
            'logo'=>'nullable|mimes:jpg,jpeg,png,webp|max:2048',
            'phone_number'=>'required|digits:10',
            'state_id'=>'required|exists:states,id',
            'city_id'=>'required|exists:cities,id',
            'area_id'=>'nullable|exists:areas,id',
            'pincode'=>'required|digits:6',
            'address'=>'required|string',
            'latitude'=>'nullable',
            'longitude'=>'nullable',
            'approved_status'=>'required|in:pending,approved,rejected',
        ]);

        try {
            if($request->hasFile('profile_pic')){
                deleteFile($vendor->user->profile_pic,'vendors/');
                $userData['profile_pic'] = uploadFile($request->profile_pic, 'vendors/');
            }

            // Logo
            if($request->hasFile('logo')){
                deleteFile($vendor->logo,'vendors/');
                $vendorData['logo'] = uploadFile($request->logo, 'vendors/');
            }

            // Aadhar Front
            if($request->hasFile('owner_aadhar_card_front_photo')){
                deleteFile($vendor->owner_aadhar_card_front_photo,'vendors/');
                $vendorData['owner_aadhar_card_front_photo'] = uploadFile($request->owner_aadhar_card_front_photo, 'vendors/');
            }

            // Aadhar Back
            if($request->hasFile('owner_aadhar_card_back_photo')){
                deleteFile($vendor->owner_aadhar_card_back_photo,'vendors/');
                $vendorData['owner_aadhar_card_back_photo'] = uploadFile($request->owner_aadhar_card_back_photo, 'vendors/');
            }

            // PAN Card
            if($request->hasFile('owner_pan_card_photo')){
                deleteFile($vendor->owner_pan_card_photo,'vendors/');
                $vendorData['owner_pan_card_photo'] = uploadFile($request->owner_pan_card_photo, 'vendors/');
            }

            $userData['dob'] = formatDateToYmd($request->dob);
            $vendor->user->update($userData);

            $vendor->update($vendorData);
            return back()->with('success', 'Vendor updated successfully.');
        } catch (\Exception $e) {
            Log::error('Vendor update error: ', [
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
    public function destroy(Vendor $vendor)
    {
        //
    }
}
