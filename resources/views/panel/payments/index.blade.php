@extends('layouts.panel')

@section('title', 'Payment List')

@section('content')

{{-- Page Header --}}
<div class="card border-0 shadow rounded-4 bg-white mb-2">
    <div class="card-header bg-white border-bottom py-3 px-3 px-md-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">

            <div>
                <h5 class="mb-0 fw-semibold">Payment Management</h5>
                <small class="text-muted">
                    View and manage customer payments.
                </small>
            </div>

        </div>
    </div>
</div>

{{-- Payment List --}}
<div class="card border-0 shadow bg-white">

    <div class="card-header bg-white border-bottom py-3 px-3 px-md-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 fw-semibold">💳 Payment List (₹{{ $totalAmount }})</h5>
        </div>

        {{-- Filter Form --}}
        <form action="{{ url()->current() }}" method="GET">

            <div class="row g-3 align-items-center">

                {{-- Customer Search --}}
                <div class="col-md">
                    <input type="text"
                        name="customer"
                        class="form-control"
                        placeholder="Search customer/mobile..."
                        value="{{ request('customer') }}">
                </div>

                {{-- Plan Filter --}}
                <div class="col-md">
                    <select name="plan_id" class="form-select">

                        <option value="">All Plans</option>

                        @foreach ($plans as $id => $name)
                            <option value="{{ $id }}"
                                @selected(request('plan_id') == $id)>
                                {{ $name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- Payment Mode --}}
                <div class="col-md">
                    <select name="payment_mode_id" class="form-select">

                        <option value="">All Payment Modes</option>

                        @foreach ($paymentModes as $id => $name)
                            <option value="{{ $id }}"
                                @selected(request('payment_mode_id') == $id)>
                                {{ $name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- Actions --}}
                <div class="col-md d-flex gap-2">

                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search me-1"></i> Search
                    </button>

                    <a href="{{ url()->current() }}"
                        class="btn btn-outline-secondary">
                        <i class="fa fa-refresh me-1"></i> Reset
                    </a>

                </div>

            </div>

        </form>

    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>
                        <th class="text-end">SN.</th>
                        <th>Customer</th>
                        <th>Plan</th>
                        <th class="text-end">Amount</th>
                        <th class="text-center">Payment Mode</th>
                        <th class="text-center">Payment Date</th>
                        <th class="text-center">Subscription</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse ($records as $row)

                        <tr>

                            <td class="text-end">
                                {{ ($records->currentPage() - 1) * $records->perPage() + $loop->iteration }}
                            </td>

                            {{-- Customer --}}
                            <td>

                                <div class="d-flex align-items-center gap-2">

                                    @if($row->customer?->profile_url)

                                        <img src="{{ $row->customer->profile_url }}"
                                            alt="Customer"
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

                            {{-- Plan --}}
                            <td>
                                {{ $row->subscription->plan->name ?? '' }}
                            </td>

                            {{-- Amount --}}
                            <td class="text-end">
                                ₹{{ number_format($row->amount, 2) }}
                            </td>

                            {{-- Payment Mode --}}
                            <td class="text-center">
                                {{ $row->paymentMode->name ?? '' }}
                            </td>

                            {{-- Payment Date --}}
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}
                            </td>

                            {{-- Subscription --}}
                            <td class="text-center">

                                <small class="d-block text-success">
                                    {{ $row->subscription->start_date ?? '' }}
                                </small>

                                <small class="d-block text-danger">
                                    {{ $row->subscription->end_date ?? '' }}
                                </small>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="text-center py-4">
                                No payment records found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Pagination --}}
        <div class="mt-3 px-3">
            {{ $records->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>

    </div>

</div>

@endsection