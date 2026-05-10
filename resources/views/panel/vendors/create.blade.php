@extends('layouts.panel')
@section('title', isset($vendor) ? 'Edit Vendor' : 'Create New Vendor')

@section('content')
{{-- Page Header --}}
<div class="card border-0 shadow rounded-4 bg-white mb-2">
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-2 py-md-3 px-2 px-md-4">
        <h5 class="mb-0 fw-semibold">
            Vendor {{ isset($vendor) ? 'Edit' : 'Create' }}
        </h5>
        <a href="{{ route('vendors.index') }}" class="btn btn-primary">
            <i class="fa fa-list me-2"></i> All Vendor
        </a>
    </div>
</div>

{{-- Form --}}
<div class="card border-0 shadow bg-white">
    <div class="card-header bg-white border-bottom py-2 py-md-3 px-2 px-md-4">
        <form action="{{ isset($vendor) ? route('vendors.update', $vendor->id) : route('vendors.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($vendor)) @method('PUT') @endif

            <h5 class="fw-semibold mb-3">Vendor Details</h5>
            <hr class="mb-4">

            <div class="row g-3">
                <!-- Name -->
                <div class="col-md-4">
                    <label class="form-label fw-bold">
                        Name <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                        class="form-control"
                        name="name"
                        value="{{ old('name', $vendor->user->name ?? '') }}"
                        required>
                </div>

                <!-- Mobile -->
                <div class="col-md-4">
                    <label class="form-label fw-bold">
                        Mobile <span class="text-danger">*</span>
                    </label>

                    <input type="number"
                        class="form-control"
                        name="mobile"
                        value="{{ old('mobile', $vendor->user->mobile ?? '') }}"
                        required
                        placeholder="1234567890">
                </div>

                <!-- Alternate Mobile -->
                <div class="col-md-4">
                    <label class="form-label fw-bold">
                        Alternate Mobile
                    </label>

                    <input type="text"
                        class="form-control"
                        name="alt_mobile"
                        value="{{ old('alt_mobile', $vendor->user->alt_mobile ?? '') }}"
                        placeholder="1234567890">
                </div>

                <!-- Email -->
                <div class="col-md-4">
                    <label class="form-label fw-bold">
                        Email <span class="text-danger">*</span>
                    </label>

                    <input type="email"
                        class="form-control"
                        name="email"
                        value="{{ old('email', $vendor->user->email ?? '') }}"
                        required>
                </div>

                {{-- Password --}}
                @if(empty($vendor))
                <div class="col-md-4">
                    <label class="form-label fw-bold">
                        Password <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                        class="form-control"
                        name="password"
                        value="{{ old('password', $vendor->user->password ?? '') }}"
                        required>
                </div>
                @endif

                <!-- Gender -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Gender <span class="text-danger">*</span>
                    </label>

                    <select name="gender" class="form-select" required>
                        <option value="">Select</option>

                        <option value="male"
                            @selected(old('gender', $vendor->user->gender ?? '') == 'male')>
                            Male
                        </option>

                        <option value="female"
                            @selected(old('gender', $vendor->user->gender ?? '') == 'female')>
                            Female
                        </option>

                        <option value="other"
                            @selected(old('gender', $vendor->user->gender ?? '') == 'other')>
                            Other
                        </option>
                    </select>
                </div>

                <!-- DOB -->
                <div class="col-md-4">
                    <label class="form-label fw-bold">
                        DOB <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                        name="dob"
                        class="form-control datepicker"
                        autocomplete="OFF"
                        value="{{ old('dob', $vendor->user->dob ?? '') }}"
                        required>
                </div>

                <!-- Profile Image -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Profile Image
                    </label>

                    <input type="file"
                        name="profile_pic"
                        class="form-control"
                        accept="image/*">

                    @if(!empty($vendor->user->profile_url))
                        <div class="mt-2">
                            <img src="{{ $vendor->user->profile_url }}"
                                class="rounded border"
                                width="80">
                        </div>
                    @endif
                </div>

                <!-- Status -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Status <span class="text-danger">*</span>
                    </label>

                    <select name="status" class="form-select" required>

                        <option value="active"
                            {{ old('status', $vendor->user->status ?? '') == 'active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="inactive"
                            {{ old('status', $vendor->user->status ?? '') == 'inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>

                        <option value="suspended"
                            {{ old('status', $vendor->user->status ?? '') == 'suspended' ? 'selected' : '' }}>
                            Suspended
                        </option>

                    </select>
                </div>

                <div class="row">

                    <!-- Business Name -->
                    <div class="col-md-4 mt-3">
                        <label class="form-label fw-semibold">
                            Business Name <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                            name="bussiness_name"
                            class="form-control"
                            value="{{ old('bussiness_name', $vendor->bussiness_name ?? '') }}"
                            placeholder="Enter Business Name">
                    </div>

                    <!-- Logo -->
                    <div class="col-md-4 mt-3">
                        <label class="form-label fw-semibold">
                            Logo <span class="text-danger">*</span>
                        </label>

                        <input type="file"
                            name="logo"
                            class="form-control">

                        @if(!empty($vendor->logo_url))
                            <div class="mt-2">
                                <img src="{{ $vendor->logo_url }}"
                                    class="rounded border img-fluid"
                                    width="100">
                            </div>
                        @endif
                    </div>

                    <!-- Phone Number -->
                    <div class="col-md-4 mt-3">
                        <label class="form-label fw-semibold">
                            Phone Number <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                            name="phone_number"
                            maxlength="10"
                            class="form-control"
                            value="{{ old('phone_number', $vendor->phone_number ?? '') }}"
                            placeholder="Enter Phone Number">
                    </div>

                    <!-- Aadhaar Front -->
                    <div class="col-md-4 mt-3">
                        <label class="form-label fw-semibold">
                            Aadhaar Card Front <span class="text-danger">*</span>
                        </label>

                        <input type="file"
                            name="owner_aadhar_card_front_photo"
                            class="form-control">

                        @if(!empty($vendor->aadhar_front_url))
                            <div class="mt-2">
                                <img src="{{ $vendor->aadhar_front_url }}"
                                    class="rounded border img-fluid"
                                    width="100">
                            </div>
                        @endif
                    </div>

                    <!-- Aadhaar Back -->
                    <div class="col-md-4 mt-3">
                        <label class="form-label fw-semibold">
                            Aadhaar Card Back <span class="text-danger">*</span>
                        </label>

                        <input type="file"
                            name="owner_aadhar_card_back_photo"
                            class="form-control">

                        @if(!empty($vendor->aadhar_back_url))
                            <div class="mt-2">
                                <img src="{{ $vendor->aadhar_back_url }}"
                                    class="rounded border img-fluid"
                                    width="100">
                            </div>
                        @endif
                    </div>

                    <!-- PAN Card -->
                    <div class="col-md-4 mt-3">
                        <label class="form-label fw-semibold">
                            PAN Card
                        </label>

                        <input type="file"
                            name="owner_pan_card_photo"
                            class="form-control">

                        @if(!empty($vendor->pan_card_url))
                            <div class="mt-2">
                                <img src="{{ $vendor->pan_card_url }}"
                                    class="rounded border img-fluid"
                                    width="100">
                            </div>
                        @endif
                    </div>

                    <!-- State -->
                    <div class="col-md-3 mt-3">
                        <label class="form-label fw-bold">
                            State <span class="text-danger">*</span>
                        </label>
                        <select name="state_id"
                                id="state_id"
                                class="form-select select-dropdown"
                                onchange="getCityList()"
                                required>
                            <option value="">Select State</option>
                        </select>
                    </div>

                    <!-- City -->
                    <div class="col-md-3 mt-3">
                        <label class="form-label fw-bold">
                            City <span class="text-danger">*</span>
                        </label>
                        <select name="city_id"
                                id="city_id"
                                class="form-select select-dropdown"
                                onchange="getAreaList()"
                                required>
                            <option value="">Select City</option>
                        </select>
                    </div>

                        <!-- Area -->
                        <div class="col-md-3 mt-3">
                            <label class="form-label fw-bold">
                                Area
                            </label>
                            <select name="area_id"
                                    id="area_id"
                                    class="form-select select-dropdown">
                                <option value="">Select Area</option>
                            </select>
                        </div>

                <!-- Pincode -->
                <div class="col-md-3 mt-3">
                    <label class="form-label fw-semibold">
                        Pincode <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                        name="pincode"
                        maxlength="6"
                        class="form-control"
                        value="{{ old('pincode', $vendor->pincode ?? '') }}"
                        placeholder="Enter Pincode">
                </div>

                <!-- Latitude -->
                <div class="col-md-3 mt-3">
                    <label class="form-label fw-semibold">
                        Latitude
                    </label>
                    <input type="text"
                        name="latitude"
                        class="form-control"
                        value="{{ old('latitude', $vendor->latitude ?? '') }}"
                        placeholder="Enter Latitude">
                </div>

                <!-- Longitude -->
                <div class="col-md-3 mt-3">
                    <label class="form-label fw-semibold">
                        Longitude
                    </label>
                    <input type="text"
                        name="longitude"
                        class="form-control"
                        value="{{ old('longitude', $vendor->longitude ?? '') }}"
                        placeholder="Enter Longitude">
                </div>

                <!-- Approved Status -->
                <div class="col-md-3 mt-3">
                    <label class="form-label fw-semibold">
                        Approved Status
                    </label>
                    <select name="approved_status" class="form-select">
                        <option value="pending"
                            {{ old('approved_status', $vendor->approved_status ?? '') == 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option value="approved"
                            {{ old('approved_status', $vendor->approved_status ?? '') == 'approved' ? 'selected' : '' }}>
                            Approved
                        </option>

                        <option value="rejected"
                            {{ old('approved_status', $vendor->approved_status ?? '') == 'rejected' ? 'selected' : '' }}>
                            Rejected
                        </option>
                    </select>
                </div>

                <!-- Address -->
                <div class="col-md-12 mt-3">
                    <label class="form-label fw-semibold">
                        Address <span class="text-danger">*</span>
                    </label>
                    <textarea name="address"
                            class="form-control"
                            rows="3"
                            placeholder="Enter Full Address">{{ old('address', $vendor->address ?? '') }}</textarea>
                </div>

            </div>

            {{-- Submit and reset --}}
            <div class="col-md-12 text-end mt-3">
                <button type="submit" class="btn btn-success px-4">
                    {{ isset($vendor) ? 'Update Vendor' : 'Create Vendor' }}
                </button>
                <button type="reset" class="btn btn-secondary px-4">
                    Reset
                </button>
            </div>
        </div>
    </form>
</div>
</div>
<input type="hidden" id="edit_state_id" value="{{ $vendor->state_id ?? '' }}">
<input type="hidden" id="edit_city_id" value="{{ $vendor->city_id ?? '' }}">
<input type="hidden" id="edit_area_id" value="{{ $vendor->area_id ?? '' }}">
@endsection

@push('scripts')
<script>
    @include('includes.geography-create-ajax')
    @if(isset($vendor))
        getCityList();
        getAreaList();
    @endif
</script>
@endpush

<x-datepicker />