@extends('layouts.panel')

@section('title', 'Vendor Profile')

@section('content')
    {{-- Page Header Card --}}
    <div class="card border-0 shadow rounded-4 bg-white mb-4">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3 px-4">
            <div>
                <h5 class="mb-0 fw-semibold">Vendor  Management</h5>
                <small class="text-muted">Manage vendor bookings — view vendor, view bookings.</small>
            </div>
            <div>
                <a href="{{ route('vendors.index') }}" class="btn btn-success">
                    <i class="fa fa-list me-2"></i> All Vendor
                </a>
                <a href="{{ route('vendors.edit',$vendor) }}" class="btn btn-primary">
                    <i class="fa fa-list me-2"></i> Edit Vendor
                </a>
            </div>
        </div>  
    </div>

    {{-- Vendor Profile Page --}}
    <div class="container-fluid px-0">
        <div class="row">
            {{-- Left Profile --}}
            <div class="col-lg-4 mb-3">
                <div class="card shadow border-0 text-center">
                    <div class="card-body">
                        @if ($vendor->logo_url != null)
                            <x-show-image 
                                :src="$vendor->logo_url"
                                alt="Logo Image"
                                width="120"
                                height="120"
                                class="rounded-circle shadow mb-3"
                            />
                        @else
                            <img src="{{ asset('assets/images/vendor.png') }}" alt="Vendor Profile Image"
                                class="rounded-circle shadow mb-3" width="120" height="120">
                        @endif
                        
                        <h5 class="fw-bold">{{ $vendor->bussiness_name ?? '' }}</h5>
                        <p class="mb-1 text-muted">{{ $vendor->phone_number ?? ''}}</p>
                        <p class="mb-1"><i class="fa fa-envelope"></i> {{ $vendor->email ?? ''}}</p>

                        {{-- Account Status Widget --}}
                        <div class="mt-3">
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="text-start">
                                    <span class="badge {{ $vendor->user->status === 'active' ? 'bg-success' : ($vendor->user->status === 'blocked' ? 'bg-danger' : 'bg-secondary') }} fs-6">
                                        {{ ucfirst($vendor->user->status) }}
                                    </span>
                                </div>
                            </div>
                            @if($vendor->status === 'blocked' && $vendor->block_reason)
                                <div class="mt-2 text-start">
                                    <hr class="my-2">
                                    <small class="text-danger fw-bold"><i class="fa fa-info-circle"></i> Block Reason:</small>
                                    <p class="text-muted small mb-0">{{ $vendor->block_reason }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Personal Details --}}
                <div class="card shadow border-0 mt-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 fw-semibold">Personal Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">

                            @if($vendor->user->profile_url)
                                <x-show-image 
                                    :src="$vendor->user->profile_url"
                                    alt="Profile Image"
                                    width="70"
                                    height="70"
                                    class="rounded-circle border shadow-sm me-3"
                                />
                            @endif

                            <div>
                                <h5 class="mb-1 fw-bold">
                                    {{ $vendor->user->name }}
                                </h5>

                                <span>
                                    {{ $vendor->user->mobile }}
                                </span>
                            </div>
                        </div>
                        <p><b>Alternate Mobile:</b> {{ $vendor->user->alt_mobile }}</p>
                        <p><b>Email:</b> {{ $vendor->user->email }}</p>
                        <p><b>DOB:</b> {{ $vendor->user->dob }}</p>
                        <p><b>Gender:</b> {{ ucfirst($vendor->user->gender) }}</p>
                    </div>
                </div>

            </div>


            {{-- Right Side --}}
            <div class="col-lg-8">

                {{-- Task Statistics --}}
                <div class="row mb-4">
                    <div class="col-md-3 col-6">
                        <div class="card text-center shadow-sm border-0">
                            <div class="card-body">
                                <h4 class="fw-bold text-primary">200</h4>
                                <p class="mb-0 text-muted">Reward Points</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="card text-center shadow-sm border-0">
                            <div class="card-body">
                                <h4 class="fw-bold text-info">0</h4>
                                <p class="mb-0 text-muted">Total Address</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="card text-center shadow-sm border-0">
                            <div class="card-body">
                                <h4 class="fw-bold text-success">0</h4>
                                <p class="mb-0 text-muted">Total Bank Details</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="card text-center shadow-sm border-0">
                            <div class="card-body">
                                <h4 class="fw-bold text-danger">0</h4>
                                <p class="mb-0 text-muted">Total Skill</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tabs --}}
                <div class="card shadow border-0 rounded-3 mb-4">
                    <div class="card-header bg-white border-bottom">
                        <ul class="nav nav-tabs card-header-tabs" role="tablist">
                            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#details">Details</a></li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#kyc">KYC Document</a></li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#addresses">Addresses</a></li>
                        </ul>
                    </div>
                    <div class="card-body tab-content" style="min-height: 375px;">
                        <div class="tab-pane fade show active" id="details">
                            <div class="y-scroll pe-2">

                                <div class="row">

                                    <!-- Basic Info -->
                                    <div class="col-md-6 mb-3">
                                        <div class="card shadow-sm h-100">
                                            <div class="card-body">

                                                <h6 class="fw-bold mb-3">Basic Info</h6>

                                                <p>
                                                    <b>State:</b><br>
                                                    {{ $vendor->state->name ?? '-' }}
                                                </p>

                                                <p>
                                                    <b>City:</b><br>
                                                    {{ $vendor->city->name ?? '-' }}
                                                </p>

                                                <p>
                                                    <b>Area:</b><br>
                                                    {{ $vendor->area->name ?? '-' }}
                                                </p>

                                                <p>
                                                    <b>Pincode:</b><br>
                                                    {{ $vendor->pincode }}
                                                </p>

                                                <p>
                                                    <b>Address:</b><br>
                                                    {{ $vendor->address }}
                                                </p>

                                                @if($vendor->latitude && $vendor->longitude)
                                                    <p>
                                                        <b>Location:</b><br>
                                                        {{ $vendor->latitude }},
                                                        {{ $vendor->longitude }}
                                                    </p>
                                                @endif

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Status Info -->
                                    <div class="col-md-6 mb-3">
                                        <div class="card shadow-sm h-100">
                                            <div class="card-body">

                                                <h6 class="fw-bold mb-3">Status Information</h6>

                                                <p>
                                                    <b>Account Status:</b>

                                                    <span class="badge
                                                        @if($vendor->user->status === 'active') bg-success
                                                        @elseif($vendor->user->status === 'inactive') bg-secondary
                                                        @else bg-danger
                                                        @endif">

                                                        {{ ucfirst($vendor->user->status) }}
                                                    </span>
                                                </p>

                                                <p>
                                                    <b>Approved Status:</b>

                                                    <span class="badge
                                                        @if($vendor->approved_status === 'approved') bg-success
                                                        @elseif($vendor->approved_status === 'rejected') bg-danger
                                                        @else bg-warning
                                                        @endif">

                                                        {{ ucfirst($vendor->approved_status) }}
                                                    </span>
                                                </p>

                                                <p>
                                                    <b>Resignation Request:</b>

                                                    @if($vendor->resignation_request_status)

                                                        <span class="badge
                                                            @if($vendor->resignation_request_status === 'approved') bg-success
                                                            @elseif($vendor->resignation_request_status === 'rejected') bg-danger
                                                            @else bg-warning
                                                            @endif">

                                                            {{ ucfirst($vendor->resignation_request_status) }}
                                                        </span>

                                                    @else
                                                        <span class="text-muted">No Request</span>
                                                    @endif
                                                </p>

                                                @if($vendor->resgination_request_reason)
                                                    <p>
                                                        <b>Resignation Reason:</b><br>
                                                        {{ $vendor->resgination_request_reason }}
                                                    </p>
                                                @endif

                                                <p>
                                                    <b>Created At:</b><br>
                                                    {{ formatDateTime($vendor->created_at) }}
                                                </p>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                        {{-- KYC --}}
                        <div class="tab-pane fade" id="kyc">
                            <div class="row g-3">

                                {{-- Aadhaar Front --}}
                                <div class="col-md-3">
                                    <div class="card shadow-sm h-100 text-center">

                                        <div class="card-body">

                                            <h6 class="fw-bold mb-3">Aadhaar Front</h6>

                                            @if($vendor->aadhar_front_url)

                                                <x-show-image 
                                                    :src="$vendor->aadhar_front_url"
                                                    alt="Aadhaar Front"
                                                    width="150"
                                                    height="150"
                                                    class="img-fluid rounded mb-2 preview-image"
                                                />

                                            @else
                                                <p class="text-muted">Not Uploaded</p>
                                            @endif

                                        </div>

                                    </div>
                                </div>

                                {{-- Aadhaar Back --}}
                                <div class="col-md-3">
                                    <div class="card shadow-sm h-100 text-center">

                                        <div class="card-body">

                                            <h6 class="fw-bold mb-3">Aadhaar Back</h6>

                                            @if($vendor->aadhar_back_url)

                                                <x-show-image 
                                                    :src="$vendor->aadhar_back_url"
                                                    alt="Aadhaar Back"
                                                    width="150"
                                                    height="150"
                                                    class="img-fluid rounded mb-2 preview-image"
                                                />

                                            @else
                                                <p class="text-muted">Not Uploaded</p>
                                            @endif

                                        </div>

                                    </div>
                                </div>

                                {{-- PAN Card --}}
                                <div class="col-md-3">
                                    <div class="card shadow-sm h-100 text-center">

                                        <div class="card-body">

                                            <h6 class="fw-bold mb-3">PAN Card</h6>

                                            @if($vendor->pan_card_url)

                                                <x-show-image 
                                                    :src="$vendor->pan_card_url"
                                                    alt="PAN Card"
                                                    width="150"
                                                    height="150"
                                                    class="img-fluid rounded mb-2 preview-image"
                                                />

                                            @else
                                                <p class="text-muted">Not Uploaded</p>
                                            @endif

                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Address --}}
                        <div class="tab-pane fade" id="addresses">
                            <a href="#" class="btn btn-primary mt-2 mb-2 d-flex align-items-center col-md-3" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                <i class="fa fa-plus me-2"></i> Add Address
                            </a>
                            <div class="y-scroll pe-2">
                                <div class="row">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        @include('includes.geography-create-ajax')
    </script>
    <script>
        $(document).ready(function () {
            let params = new URLSearchParams(window.location.search);
            let activeTab = params.get('tab');

            if (activeTab) {
                // remove default active
                $('.nav-tabs .nav-link').removeClass('active');
                $('.tab-pane').removeClass('show active');

                // find matching button using href
                let $tab = $('.nav-tabs a[href="#' + activeTab + '"]');

                if ($tab.length) {
                    let tab = new bootstrap.Tab($tab[0]);
                    tab.show(); // ✅ open tab from URL
                }
            }
        });
    </script>
@endpush