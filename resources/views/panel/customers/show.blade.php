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
                                <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#subscriptions">Subscription</a></li>
                                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#addresses">Addresses</a></li>
                                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#leaves">Leave</a></li>
                            </ul>
                        </div>
                        <div class="card-body tab-content" style="min-height: 375px;">

                            {{-- Subscription Tab --}}
                            <div class="tab-pane fade show active" id="subscriptions">

                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPlanModal">
                                    Add Plan
                                </button>
                                <div class="modal fade" id="addPlanModal" tabindex="-1" aria-labelledby="addPlanLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form action="{{ route('customers.plan.store') }}" method="POST">
                                                @csrf

                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="addPlanLabel">Add Plan</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <h6 class="fw-bold">Plan Details</h6>
                                                        <hr>

                                                        <input type="hidden" name="customer_id" value="{{ $customer->id }}">

                                                        <!-- Plan -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Plan</label>

                                                            <select name="plan_id" class="form-select" required onchange="setPrice(this)">
                                                                <option value="">Select Plan</option>

                                                                @foreach($plans as $plan)
                                                                    <option value="{{ $plan->id }}"
                                                                        data-price="{{ $plan->price }}">
                                                                        {{ $plan->name }} 
                                                                        | ₹{{ number_format($plan->price, 2) }} 
                                                                        | {{ $plan->total_days }} Days 
                                                                        | {{ $plan->meal_time }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <!-- Customer Address -->
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Customer Address</label>

                                                            <select name="customer_address_id" class="form-select" required>
                                                                <option value="">Select Address</option>

                                                                @foreach($customer->addresses as $address)
                                                                    <option value="{{ $address->id }}">
                                                                        {{ Str::limit($address->address, 40) }}
                                                                        - {{ ucfirst($address->type) }}
                                                                        - {{ $address->city->name ?? '' }}
                                                                        - {{ $address->pincode }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <!-- Offer Price -->
                                                        <div class="col-md-4 mb-3">
                                                            <label class="form-label">Offer Price</label>

                                                            <input type="number"
                                                                step="0.01"
                                                                name="offer_price"
                                                                id="offer_price"
                                                                class="form-control"
                                                                placeholder="Enter Offer Price"
                                                                required>
                                                        </div>

                                                        <!-- Start Date -->
                                                        <div class="col-md-4 mb-3">
                                                            <label class="form-label">Start Date</label>

                                                            <input type="text"
                                                                name="start_date"
                                                                class="form-control datepicker"
                                                                autocomplete="OFF"
                                                                required>
                                                        </div>

                                                    </div>

                                                    
                                                    <div class="row mt-3">
                                                        <h6 class="fw-bold">Payment Details</h6>
                                                        <hr>

                                                        <!-- Payment Mode -->
                                                        <div class="col-md-4 mb-3">
                                                            <label class="form-label">Payment Mode</label>

                                                            <select name="payment_mode_id" class="form-select" required>
                                                                <option value="">Select Payment Mode</option>

                                                                @foreach($paymentModes as $id => $name)
                                                                    <option value="{{ $id }}">
                                                                        {{ $name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <!-- Amount -->
                                                        <div class="col-md-4 mb-3">
                                                            <label class="form-label">Amount</label>

                                                            <input type="number"
                                                                step="0.01"
                                                                name="amount"
                                                                id="amount"
                                                                class="form-control"
                                                                placeholder="Enter Amount"
                                                                required>
                                                        </div>

                                                        <!-- Payment Date -->
                                                        <div class="col-md-4 mb-3">
                                                            <label class="form-label">Date</label>

                                                            <input type="text"
                                                                name="date"
                                                                class="form-control datepicker"
                                                                value="{{ date('d-m-Y') }}"
                                                                autocomplete="OFF"
                                                                required>
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
                                    @foreach ($customer->subscriptions as $subscription)

                                        @php
                                            $paidAmount = $subscription->payments->sum('amount');
                                            $remainingAmount = $subscription->offer_price - $paidAmount;
                                        @endphp

                                        <div class="card shadow-sm mb-3">
                                            <div class="card-body">

                                                <div class="row align-items-center">

                                                    <div class="col-md-8">

                                                        <h5 class="fw-bold mb-2">
                                                            {{ $subscription->plan->name ?? 'N/A' }}
                                                        </h5>

                                                        <div class="mb-2">

                                                            <span class="badge bg-info">
                                                                Start:
                                                                {{ \Carbon\Carbon::parse($subscription->start_date)->format('d M Y') }}
                                                            </span>

                                                            <span class="badge bg-dark">
                                                                End:
                                                                {{ \Carbon\Carbon::parse($subscription->end_date)->format('d M Y') }}
                                                            </span>

                                                        </div>

                                                        <p class="mb-1">
                                                            <b>Total:</b>
                                                            ₹{{ number_format($subscription->offer_price, 2) }}
                                                        </p>

                                                        <p class="mb-1 text-success">
                                                            <b>Paid:</b>
                                                            ₹{{ number_format($paidAmount, 2) }}
                                                        </p>

                                                        <p class="mb-0 text-danger">
                                                            <b>Remaining:</b>
                                                            ₹{{ number_format($remainingAmount, 2) }}
                                                        </p>

                                                    </div>

                                                   <div class="col-md-4 text-md-end mt-3 mt-md-0">

                                                        {{-- Status Badges --}}
                                                        <div class="d-flex flex-wrap gap-2 justify-content-md-end mb-3">

                                                            {{-- Payment Status --}}
                                                            <span class="badge px-3 py-2
                                                                @if($subscription->paymwnt_status == 'paid')
                                                                    bg-success
                                                                @elseif($subscription->paymwnt_status == 'partial')
                                                                    bg-warning text-dark
                                                                @else
                                                                    bg-danger
                                                                @endif">

                                                                Payment:
                                                                {{ ucfirst($subscription->paymwnt_status) }}

                                                            </span>

                                                            {{-- Active Status --}}
                                                            <span class="badge px-3 py-2
                                                                {{ $subscription->is_active ? 'bg-success' : 'bg-secondary' }}">

                                                                {{ $subscription->is_active ? 'Active' : 'Inactive' }}

                                                            </span>

                                                        </div>

                                                        {{-- Action Buttons --}}
                                                        <div class="d-flex flex-wrap gap-2 justify-content-md-end">

                                                            {{-- Change Status --}}
                                                            <form action="{{ route('subscriptions.status.update', $subscription->id) }}"
                                                                method="POST">

                                                                @csrf
                                                                @method('PUT')

                                                                <button type="submit"
                                                                        class="btn btn-sm
                                                                        {{ $subscription->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}"

                                                                        onclick="return confirm(
                                                                            'Are you sure you want to {{ $subscription->is_active ? 'Deactivate' : 'Activate' }} this subscription?'
                                                                        )">

                                                                    <i class="ti ti-refresh"></i>

                                                                    {{ $subscription->is_active ? 'Deactivate' : 'Activate' }}

                                                                </button>

                                                            </form>

                                                            <form action="{{ route('subscriptions.destroy', $subscription->id) }}"
                                                                method="POST"
                                                                class="d-inline">

                                                                @csrf
                                                                @method('DELETE')

                                                                <button type="submit"
                                                                        class="btn btn-danger btn-sm"

                                                                        onclick="return confirm(
                                                                            'Are you sure you want to delete this subscription?'
                                                                        )">

                                                                    <i class="ti ti-trash"></i>
                                                                    Delete

                                                                </button>

                                                            </form>

                                                            {{-- Add Payment --}}
                                                            @if($remainingAmount > 0)
                                                                @php
                                                                    $whatsappUrl = dueWhatsappUrl(
                                                                        $customer->name,
                                                                        $customer->mobile,
                                                                        $subscription->plan->name,
                                                                        $subscription->end_date,
                                                                        $remainingAmount
                                                                    )
                                                                @endphp
                                                                <a href="{{ $whatsappUrl }}" target="_blank" type="button" class="btn btn-sm btn-success">
                                                                    <i class="fa-brands fa-whatsapp"></i> Due Chat
                                                                </a>

                                                                <button type="button"
                                                                        class="btn btn-primary btn-sm"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#paymentModal{{ $subscription->id }}">

                                                                    <i class="ti ti-credit-card"></i>
                                                                    Add Payment

                                                                </button>

                                                            @endif

                                                            {{-- Payment History --}}
                                                            <button type="button"
                                                                    class="btn btn-dark btn-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#paymentHistoryModal{{ $subscription->id }}">

                                                                <i class="ti ti-history"></i>
                                                                History

                                                            </button>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>
                                        </div>

                                        {{-- Payment Modal --}}
                                        @if($remainingAmount > 0)

                                            <div class="modal fade"
                                                id="paymentModal{{ $subscription->id }}"
                                                tabindex="-1">

                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <form action="{{ route('customers.payment.store') }}" method="POST">
                                                            @csrf

                                                            <input type="hidden"
                                                                name="subscription_id"
                                                                value="{{ $subscription->id }}">

                                                            <div class="modal-header">
                                                                <h5 class="modal-title">
                                                                    Add Payment
                                                                </h5>

                                                                <button type="button"
                                                                        class="btn-close"
                                                                        data-bs-dismiss="modal"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label class="form-label">
                                                                        Remaining Amount
                                                                    </label>

                                                                    <input type="text"
                                                                        class="form-control"
                                                                        value="₹{{ number_format($remainingAmount, 2) }}"
                                                                        readonly>
                                                                </div>

                                                                <!-- Payment Mode -->
                                                                <div class="mb-3">
                                                                    <label class="form-label">
                                                                        Payment Mode
                                                                    </label>

                                                                    <select name="payment_mode_id"
                                                                            class="form-select"
                                                                            required>

                                                                        <option value="">
                                                                            Select Payment Mode
                                                                        </option>

                                                                        @foreach($paymentModes as $id => $name)

                                                                            <option value="{{ $id }}">
                                                                                {{ $name }}
                                                                            </option>

                                                                        @endforeach

                                                                    </select>
                                                                </div>

                                                                <!-- Amount -->
                                                                <div class="mb-3">
                                                                    <label class="form-label">
                                                                        Amount
                                                                    </label>

                                                                    <input type="number"
                                                                        step="0.01"
                                                                        max="{{ $remainingAmount }}"
                                                                        name="amount"
                                                                        class="form-control"
                                                                        placeholder="Enter Amount"
                                                                        required>
                                                                </div>

                                                                <!-- Date -->
                                                                <div class="mb-3">
                                                                    <label class="form-label">
                                                                        Date
                                                                    </label>

                                                                    <input type="text"
                                                                        name="date"
                                                                        value="{{ date('Y-m-d') }}"
                                                                        class="form-control datepicker"
                                                                        required>
                                                                </div>

                                                            </div>

                                                            <div class="modal-footer">

                                                                <button type="button"
                                                                        class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">
                                                                    Close
                                                                </button>

                                                                <button type="submit"
                                                                        class="btn btn-primary">
                                                                    Save Payment
                                                                </button>

                                                            </div>

                                                        </form>

                                                    </div>
                                                </div>
                                            </div>

                                        @endif

                                        {{-- Payment History Modal --}}
                                        <div class="modal fade"
                                            id="paymentHistoryModal{{ $subscription->id }}"
                                            tabindex="-1"
                                            aria-hidden="true">

                                            <div class="modal-dialog modal-lg modal-dialog-scrollable">

                                                <div class="modal-content">

                                                    <div class="modal-header">

                                                        <h5 class="modal-title">
                                                            Payment History
                                                        </h5>

                                                        <button type="button"
                                                                class="btn-close"
                                                                data-bs-dismiss="modal">
                                                        </button>

                                                    </div>

                                                    <div class="modal-body">

                                                        {{-- Subscription Info --}}
                                                        <div class="mb-3">

                                                            <h6 class="fw-bold mb-2">
                                                                {{ $subscription->plan->name ?? 'N/A' }}
                                                            </h6>

                                                            <div class="row">

                                                                <div class="col-md-4">
                                                                    <small class="text-muted">
                                                                        Total Amount
                                                                    </small>

                                                                    <h6>
                                                                        ₹{{ number_format($subscription->offer_price, 2) }}
                                                                    </h6>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <small class="text-muted">
                                                                        Paid Amount
                                                                    </small>

                                                                    <h6 class="text-success">
                                                                        ₹{{ number_format($subscription->payments->sum('amount'), 2) }}
                                                                    </h6>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <small class="text-muted">
                                                                        Remaining Amount
                                                                    </small>

                                                                    <h6 class="text-danger">
                                                                        ₹{{ number_format(
                                                                            $subscription->offer_price - $subscription->payments->sum('amount'),
                                                                            2
                                                                        ) }}
                                                                    </h6>
                                                                </div>

                                                            </div>

                                                        </div>

                                                        {{-- Payment Table --}}
                                                        @if($subscription->payments->count() > 0)

                                                            <div class="table-responsive">

                                                                <table class="table table-bordered align-middle">

                                                                    <thead class="table-light">

                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Date</th>
                                                                            <th>Payment Mode</th>
                                                                            <th>Amount</th>
                                                                            <th>Created</th>
                                                                        </tr>

                                                                    </thead>

                                                                    <tbody>

                                                                        @foreach($subscription->payments as $key => $payment)

                                                                            <tr>

                                                                                <td>
                                                                                    {{ $key + 1 }}
                                                                                </td>

                                                                                <td>
                                                                                    {{ \Carbon\Carbon::parse($payment->date)->format('d M Y') }}
                                                                                </td>

                                                                                <td>

                                                                                    <span class="badge bg-primary">

                                                                                        {{ $payment->paymentMode->name ?? 'N/A' }}

                                                                                    </span>

                                                                                </td>

                                                                                <td class="fw-bold text-success">

                                                                                    ₹{{ number_format($payment->amount, 2) }}

                                                                                </td>

                                                                                <td>

                                                                                    {{ $payment->created_at->format('d M Y h:i A') }}

                                                                                </td>

                                                                            </tr>

                                                                        @endforeach

                                                                    </tbody>

                                                                    <tfoot class="table-light">

                                                                        <tr>

                                                                            <th colspan="3" class="text-end">
                                                                                Total Paid
                                                                            </th>

                                                                            <th colspan="2" class="text-success">
                                                                                ₹{{ number_format($subscription->payments->sum('amount'), 2) }}
                                                                            </th>

                                                                        </tr>

                                                                    </tfoot>

                                                                </table>

                                                            </div>

                                                        @else

                                                            <div class="text-center py-4">

                                                                <h6 class="text-muted mb-0">
                                                                    No payment history found.
                                                                </h6>

                                                            </div>

                                                        @endif

                                                    </div>

                                                    <div class="modal-footer">

                                                        <button type="button"
                                                                class="btn btn-secondary"
                                                                data-bs-dismiss="modal">

                                                            Close

                                                        </button>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    @endforeach
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

                            {{-- Leaves --}}
                            <div class="tab-pan fade" id="leaves">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLeaveModal">
                                    Add Leave
                                </button>
                                <div class="modal fade" id="addLeaveModal" tabindex="-1" aria-labelledby="addLeaveLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <form action="{{ route('leaves.store') }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="addLeaveLabel">
                                                        Add Leave
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                                                    <!-- Start Date -->
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            Start Date <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text"
                                                            name="start_date"
                                                            class="form-control datepicker"
                                                            autocomplete="OFF"
                                                            required>
                                                    </div>
                                                    <!-- End Date -->
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            End Date
                                                        </label>
                                                        <input type="text"
                                                            name="end_date"
                                                            class="form-control datepicker"
                                                            autocomplete="OFF">
                                                    </div>
                                                    <!-- Status -->
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            Status
                                                        </label>
                                                        <select name="status" class="form-select" required>
                                                            <option value="pending">Pending</option>
                                                            <option value="approved">Approved</option>
                                                            <option value="rejected">Rejected</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                    <button type="submit"
                                                        class="btn btn-primary">
                                                        Save
                                                    </button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>

                                <div class="y-scoll">
                                    <div class="card mt-2">
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>SN</th>
                                                        <th>Start Date</th>
                                                        <th>end Date</th>
                                                        <th>Total Days</th>
                                                        <th class="text-center">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($customer->leaves->sortByDesc('id') as $leave)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $leave->start_date }}</td>
                                                            <td>{{ $leave->end_date }}</td>
                                                            <td>{{ $leave->total_days }}</td>
                                                            <td class="text-center">
                                                                <span class="badge 
                                                                    @if($leave->status == 'pending') bg-warning
                                                                    @elseif($leave->status == 'approved') bg-success
                                                                    @elseif($leave->status == 'rejected') bg-danger
                                                                    @endif">
                                                                    
                                                                    {{ ucfirst($leave->status) }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
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

    <script>

    $(document).ready(function () {

        // Plan Change
        $('select[name="plan_id"]').on('change', function () {

            let price = parseFloat(
                $(this).find(':selected').data('price')
            ) || 0;

            // Set Values
            $('#offer_price').val(price);
            $('#amount').val(price);

            // Set Max Attribute
            $('#offer_price').attr('max', price);
            $('#amount').attr('max', price);

        });

        // Offer Price Validation
        $('#offer_price').on('input', function () {

            let mainPrice = parseFloat(
                $('select[name="plan_id"] option:selected').data('price')
            ) || 0;

            let offerPrice = parseFloat($(this).val()) || 0;

            // Offer Price > Main Price
            if (offerPrice > mainPrice) {

                $(this).val(mainPrice);

                offerPrice = mainPrice;
            }

            // Amount Max = Offer Price
            $('#amount').attr('max', offerPrice);

            // Amount Auto Adjust
            if (
                parseFloat($('#amount').val()) > offerPrice
            ) {

                $('#amount').val(offerPrice);
            }

        });

        // Amount Validation
        $('#amount').on('input', function () {

            let offerPrice = parseFloat(
                $('#offer_price').val()
            ) || 0;

            let amount = parseFloat($(this).val()) || 0;

            // Amount > Offer Price
            if (amount > offerPrice) {

                $(this).val(offerPrice);
            }

        });

    });

</script>
@endpush

<x-datepicker />