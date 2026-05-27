@extends('layouts.panel')

@section('title', 'Subscription List')

@section('content')

{{-- Page Header --}}
<div class="card border-0 shadow rounded-4 bg-white mb-2">
    <div class="card-header bg-white border-bottom py-3 px-3 px-md-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h5 class="mb-0 fw-semibold">Subscription Management</h5>
                <small class="text-muted">View and manage customer subscriptions.</small>
            </div>
        </div>
    </div>
</div>

{{-- Subscription Table --}}
<div class="card border-0 shadow bg-white">
    <div class="card-header bg-white border-bottom py-3 px-3 px-md-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 fw-semibold">📦 Subscription List</h5>
        </div>

        {{-- Filter Form --}}
        <form action="{{ url()->current() }}" method="GET">
            <div class="row g-3 align-items-center">

                <div class="col-md-3">
                    <input type="text"
                        name="customer"
                        class="form-control"
                        placeholder="Search customer name/mobile..."
                        value="{{ request('customer') }}">
                </div>

                <div class="col-md-3">
                    <select name="plan_id" class="form-select select-dropdown">
                        <option value="">All Plan</option>
                        @foreach($plans as $id => $name)    
                            <option value="{{ $id }}" @selected(request('plan_id') == $id )>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md">
                    <select name="paymwnt_status" class="form-select">
                        <option value="">All Payment Status</option>
                        <option value="pending" @selected(request('paymwnt_status') == 'pending')>Pending</option>
                        <option value="partial" @selected(request('paymwnt_status') == 'partial')>Partial</option>
                        <option value="paid" @selected(request('paymwnt_status') == 'paid')>Paid</option>
                    </select>
                </div>

                <div class="col-md">
                    <select name="is_active" class="form-select">
                        <option value="">All Status</option>
                        <option value="1" @selected(request('is_active') == '1')>Active</option>
                        <option value="0" @selected(request('is_active') == '0')>Inactive</option>
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search me-1"></i> Search
                    </button>

                    <a href="{{ url()->current() }}" class="btn btn-outline-secondary">
                        <i class="fa fa-refresh me-1"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-end">SN.</th>
                        <th>Customer</th>
                        <th>Plan</th>
                        <th class="text-center">Meal Time</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Start Date</th>
                        <th class="text-center">End Date</th>
                        <th class="text-center">Due Payment</th>
                        <th class="text-center">Payment Status</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($records as $row)
                        <tr>
                            <td class="text-end">
                                {{ ($records->currentPage() - 1) * $records->perPage() + $loop->iteration }}
                            </td>

                            <td>
                                <div class="d-flex align-items-center gap-2">

                                    @if($row->customer?->profile_url)
                                        <img src="{{ $row->profile_url }}"
                                            alt="Profile"
                                            width="45"
                                            height="45"
                                            class="rounded-circle border shadow-sm object-fit-cover">
                                    @else
                                        <img src="{{ asset('assets/images/customer.webp') }}"
                                            alt="Default"
                                            width="45"
                                            height="45"
                                            class="rounded-circle border shadow-sm object-fit-cover">
                                    @endif

                                    <div>
                                        <div class="fw-semibold">
                                            {{ $row->customer->name ?? '' }}
                                        </div>

                                        <small class="text-muted">
                                            {{ $row->customer->mobile ?? '' }}
                                        </small>
                                    </div>

                                </div>
                            </td>

                            <td>
                                <div class="fw-semibold">
                                    {{ $row->plan->name ?? '' }}
                                </div>

                                <small class="text-muted">
                                    {{ $row->plan->total_days ?? 0 }} Days
                                </small>
                            </td>

                            <td class="text-center">
                                {{ $row->plan->meal_time ?? '' }}
                            </td>

                            <td class="text-center">
                                ₹{{ number_format($row->offer_price, 2) }}
                            </td>

                            <td class="text-center">
                                {{ $row->start_date }}
                            </td>

                            <td class="text-center">
                                {{ $row->end_date }}
                            </td>

                            <td>
                                @if($row->offer_price > $row->payments_sum_amount)
                                @php
                                    $whatsappUrl = dueWhatsappUrl(
                                        $row->customer->name,
                                        $row->customer->mobile,
                                        $row->plan->name,
                                        $row->end_date,
                                        $row->offer_price - $row->payments_sum_amount,
                                    )
                                @endphp

                                    <a href="{{ $whatsappUrl }}" target="_blank" type="button" class="btn btn-sm btn-success">
                                        <i class="fa-brands fa-whatsapp me-1"></i> Chat
                                    </a>

                                    <button type="button"
                                            class="btn btn-primary btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#paymentModal{{ $row->id }}">

                                        <i class="ti ti-credit-card"></i>
                                        Add Payment
                                    </button>

                                    <div class="modal fade"
                                        id="paymentModal{{ $row->id }}"
                                        tabindex="-1">

                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <form action="{{ route('customers.payment.store') }}" method="POST">
                                                    @csrf

                                                    <input type="hidden"
                                                        name="subscription_id"
                                                        value="{{ $row->id }}">

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
                                                                value="₹{{ number_format($row->offer_price - $row->payments_sum_amount, 2) }}"
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
                                                                max="{{ $row->offer_price - $row->payments_sum_amount }}"
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
                                                                value="{{ date('d-m-Y') }}"
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
                                @else
                                    N/A
                                @endif
                            </td>

                            <td class="text-center">
                                @php
                                    $paymentBadge = [
                                        'paid' => 'bg-success',
                                        'pending' => 'bg-warning text-dark',
                                        'partial' => 'bg-secondary',
                                    ];
                                @endphp
                                
                                <span class="badge {{ $paymentBadge[$row->paymwnt_status] ?? 'bg-secondary' }}">
                                    {{ ucfirst($row->paymwnt_status) }}
                                </span>
                            </td>

                            <td class="text-center">
                                @if($row->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3 px-3">
                {{ $records->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>
</div>

@endsection