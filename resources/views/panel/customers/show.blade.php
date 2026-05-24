@extends('layouts.panel')

@section('title', 'Customer Profile')

@section('content')
    <x-alert />

    {{-- Content Section --}}

        {{-- Page Header Card --}}
        <div class="card border-0 shadow rounded-4 bg-white mb-4">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3 px-4">
                <div>
                    <h5 class="mb-0 fw-semibold">Customer  Management</h5>
                    <small class="text-muted">Manage customer bookings — view customer, view bookings.</small>
                </div>
            </div>  
        </div>

        {{-- Customer Profile Page --}}
        <div class="">
            <div class="row">
                {{-- Left Profile --}}
                <div class="col-lg-4 mb-3">
                    <div class="card shadow border-0 text-center">
                        <div class="card-body">
                            @if ($customer->profile_url != null)
                                <img src="{{ $customer->profile_url }}" alt="Profile Image"
                                    class="rounded-circle shadow mb-3" width="120" height="120">
                            @else
                                <img src="{{ asset('assets/images/customer.webp') }}" alt="Profile Image"
                                    class="rounded-circle shadow mb-3" width="120" height="120">
                            @endif
                            
                            <h5 class="fw-bold">{{ $customer->name ?? '' }}</h5>
                            <p class="mb-1 text-muted"> {{ $customer->country ? '+' . $customer->country->code : ''}} {{ $customer->mobile ?? ''}}</p>
                            <p class="mb-1"><i class="fa fa-envelope"></i> {{ $customer->email ?? ''}}</p>
                            <p class="mb-1">
                                <span class="badge 
                                    @if($customer->status === 'active') bg-success
                                    @elseif($customer->status === 'inactive') bg-secondary
                                    @else bg-danger
                                    @endif">
                                    {{ ucfirst($customer->status) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    {{-- Personal Details --}}
                    <div class="card shadow border-0 mt-3">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0 fw-semibold">Personal Details</h5>
                        </div>
                        <div class="card-body">
                            <p><b>Alt Mobile:</b> {{ $customer->alt_mobile }}</p>
                            <p><b>Gender:</b> {{ $customer->gender }}</p>
                            <p><b>DOB:</b> {{ $customer->dob }}</p>
                        </div>
                    </div>

                </div>


                {{-- Right Side --}}
                <div class="col-lg-8">

                    {{-- Tabs --}}
                    <div class="card shadow border-0 rounded-3 mb-4">
                        <div class="card-header bg-white border-bottom">
                            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#subscription">Subscription</a></li>
                                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#addresses">Addresses</a></li>
                            </ul>
                        </div>
                        <div class="card-body tab-content" style="min-height: 375px;">

                            {{-- Subscription Tab --}}
                            <div class="tab-pane fade show active" id="subscription">

                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPlanModal">
                                    Add Plan
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="addPlanModal" tabindex="-1" aria-labelledby="addPlanLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="addPlanLabel">Add Plan</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ...
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="y-scroll pe-2 mt-2">
                                            
                                    <div class="card shadow-sm h-100">
                                        <div class="card-body">
                                            <h6 class="fw-bold mb-3">Subscription Info</h6>

                                            <p>
                                                <b>Source:</b>
                                                <span class="badge bg-primary">
                                                    {{ ucfirst($customer->registration_source) }}
                                                </span>
                                            </p>

                                            <p>
                                                <b>First Login:</b><br>
                                                {{ $customer->first_login_date 
                                                    ? $customer->first_login_date->format('d M Y, h:i A') 
                                                    : 'N/A' }}
                                            </p>

                                            <p>
                                                <b>Last Active:</b><br>
                                                {{ $customer->last_active_date 
                                                    ? $customer->last_active_date->format('d M Y, h:i A') 
                                                    : 'N/A' }}
                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- Address --}}
                            <div class="tab-pane fade" id="addresses">

                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAddress">
                                    Add Address
                                </button>
                                <div class="modal fade" id="addAddress" tabindex="-1" aria-labelledby="addAddressLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form action="{{ route('customers.address.store') }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="addAddressLabel">Add Address</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">

                                                        <input type="hidden" name="customer_id" value="{{ $customer->id }}">

                                                        <!-- State -->
                                                        <div class="col-md-4 mb-3">
                                                            <label class="form-label">State</label>
                                                            <select name="state_id" id="state_id" class="form-select" onchange="getCityList()">
                                                                <option value="">Select State</option>
                                                                
                                                            </select>
                                                        </div>

                                                        <!-- City -->
                                                        <div class="col-md-4 mb-3">
                                                            <label class="form-label">City</label>
                                                            <select name="city_id" id="city_id" class="form-select" onchange="getAreaList()">
                                                                <option value="">Select City</option>
                                                            </select>
                                                        </div>

                                                        <!-- Area -->
                                                        <div class="col-md-4 mb-3">
                                                            <label class="form-label">Area</label>
                                                            <select name="area_id" id="area_id" class="form-select">
                                                                <option value="">Select Area</option>
                                                            </select>
                                                        </div>

                                                        <!-- Pincode -->
                                                        <div class="col-md-4 mb-3">
                                                            <label class="form-label">Pincode</label>
                                                            <input type="text" 
                                                                name="pincode" 
                                                                class="form-control" 
                                                                maxlength="6"
                                                                placeholder="Enter Pincode">
                                                        </div>

                                                        <!-- Latitude -->
                                                        <div class="col-md-4 mb-3">
                                                            <label class="form-label">Latitude</label>
                                                            <input type="text" 
                                                                name="latitude" 
                                                                class="form-control"
                                                                placeholder="Enter Latitude">
                                                        </div>

                                                        <!-- Longitude -->
                                                        <div class="col-md-4 mb-3">
                                                            <label class="form-label">Longitude</label>
                                                            <input type="text" 
                                                                name="longitude" 
                                                                class="form-control"
                                                                placeholder="Enter Longitude">
                                                        </div>

                                                        <!-- Address -->
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label">Address</label>
                                                            <textarea name="address"
                                                                    rows="3"
                                                                    class="form-control"
                                                                    placeholder="Enter Full Address"></textarea>
                                                        </div>

                                                        <!-- Address Type -->
                                                        <div class="col-md-4 mb-3">
                                                            <label class="form-label">Address Type</label>

                                                            <select name="type" class="form-select" required>
                                                                <option value="home">Home</option>
                                                                <option value="work">Work</option>
                                                                <option value="other">Other</option>
                                                            </select>
                                                        </div>

                                                        <!-- Default Address -->
                                                        <div class="col-md-4 mb-3">
                                                            <label class="form-label">Default Address</label>
                                                            <select name="is_default" class="form-select">
                                                                <option value="no">No</option>
                                                                <option value="yes">Yes</option>
                                                            </select>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="y-scroll pe-2 mt-2">
                                    <div class="row">
                                        @forelse($customer->addresses ?? [] as $address)
                                            <div class="col-md-6 col-lg-4 mb-3">
                                                <div class="card shadow-sm h-100">
                                                    <div class="card-body">
                                                        
                                                        <h6 class="fw-bold mb-2">
                                                            {{ ucfirst($address->type) }}
                                                            <span class="float-end badge {{ $address->is_default ? 'bg-success' : 'bg-muted' }}">{{ ucfirst($address->is_default) }}</span>
                                                        </h6>

                                                        <p class="mb-1"><b>State:</b> {{ $address->state->name ?? '' }}</p>
                                                        <p class="mb-1"><b>City:</b> {{ $address->city->name ?? '' }}</p>
                                                        <p class="mb-1"><b>Area:</b> {{ $address->area->name ?? '' }}</p>
                                                        <p class="mb-1"><b>Postal Code:</b> {{ $address->pincode }}</p>
                                                        <p class="mb-1">
                                                            <b>Address:</b> 
                                                            {{ $address->address }}
                                                        </p>
                                                        <p class="mb-1"><b>Latitude:</b> {{ $address->latitude }}</p>
                                                        <p class="mb-0"><b>Longitude:</b> {{ $address->longitude }}</p>

                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-12">
                                                <div class="alert alert-info text-center">
                                                    No addresses found.
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
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