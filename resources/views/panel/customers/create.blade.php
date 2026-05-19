@extends('layouts.panel')
@section('title', isset($customer) ? 'Edit Customer' : 'Create New Customer')

@section('content')
{{-- Page Header --}}
<div class="card border-0 shadow rounded-4 bg-white mb-2">
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-2 py-md-3 px-2 px-md-4">
        <h5 class="mb-0 fw-semibold">
            Customer {{ isset($customer) ? 'Edit' : 'Create' }}
        </h5>
        <a href="{{ route('customers.index') }}" class="btn btn-primary">
            <i class="fa fa-list me-2"></i> All Customer
        </a>
    </div>
</div>

{{-- Form --}}
<div class="card border-0 shadow bg-white">
    <div class="card-header bg-white border-bottom py-2 py-md-3 px-2 px-md-4">
        <form action="{{ isset($customer) ? route('customers.update', $customer->id) : route('customers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($customer)) @method('PUT') @endif

            <h5 class="fw-semibold mb-3">Customer Details</h5>
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
                        value="{{ old('name', $customer->name ?? '') }}"
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
                        value="{{ old('mobile', $customer->mobile ?? '') }}"
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
                        value="{{ old('alt_mobile', $customer->alt_mobile ?? '') }}"
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
                        value="{{ old('email', $customer->email ?? '') }}"
                        required>
                </div>

                {{-- Password --}}
                @if(empty($customer))
                <div class="col-md-4">
                    <label class="form-label fw-bold">
                        Password <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                        class="form-control"
                        name="password"
                        value="{{ old('password', $customer->password ?? '') }}"
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
                            @selected(old('gender', $customer->gender ?? '') == 'male')>
                            Male
                        </option>

                        <option value="female"
                            @selected(old('gender', $customer->gender ?? '') == 'female')>
                            Female
                        </option>

                        <option value="other"
                            @selected(old('gender', $customer->gender ?? '') == 'other')>
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
                        value="{{ old('dob', $customer->dob ?? '') }}"
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

                    @if(!empty($customer->customer_profile_url))
                        <div class="mt-2">
                            <img src="{{ $customer->customer_profile_url }}"
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
                            {{ old('status', $customer->status ?? '') == 'active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="inactive"
                            {{ old('status', $customer->status ?? '') == 'inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>

                        <option value="suspended"
                            {{ old('status', $customer->status ?? '') == 'suspended' ? 'selected' : '' }}>
                            Suspended
                        </option>

                    </select>
                </div>

            </div>

            {{-- Submit and reset --}}
            <div class="col-md-12 text-end mt-3">
                <button type="submit" class="btn btn-success px-4">
                    {{ isset($customer) ? 'Update Customer' : 'Create Customer' }}
                </button>
                <button type="reset" class="btn btn-secondary px-4">
                    Reset
                </button>
            </div>
        </div>
    </form>
</div>
</div>
@endsection

<x-datepicker />