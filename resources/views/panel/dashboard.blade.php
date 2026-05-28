@extends('layouts.panel')

@section('title', 'Dashboard')

@section('content')
<!-- Page Header Card  -->
<div class="card border-0 shadow rounded-0 bg-white mb-4">
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3 px-4">
        <div>
            <h5 class="mb-0 fw-semibold">Dashboard</h5>
            <small class="text-muted">Overview of your application's performance and registrations.</small>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <a href="{{ route('customers.index') }}" class="text-decoration-none text-dark">
                    <h6 class="text-muted mb-2">Total Customer</h6>
                    <h3 class="fw-bold mb-0">{{ $statics['customers'] }}</h3>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <a href="{{ route('subscriptions.index') }}" class="text-decoration-none text-dark">
                    <h6 class="text-muted mb-2">Active Subscription</h6>
                    <h3 class="fw-bold mb-0">{{ $statics['activeSubscriptions'] }}</h3>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <a href="{{ route('leaves.index',['date'=>date('d-m-Y')]) }}" class="text-decoration-none text-dark">
                    <h6 class="text-muted mb-2">Today Leaves</h6>
                    <h3 class="fw-bold mb-0">{{ $statics['todayLeaves'] }}</h3>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted mb-2">Today Food Requirement</h6>
                <h3 class="fw-bold mb-0">{{ $statics['todayFoodRequirement'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <a href="{{ route('payments.index') }}" class="text-decoration-none text-dark">
                    <h6 class="text-muted mb-2">Revenue</h6>
                    <h3 class="fw-bold mb-0">₹{{ $statics['revenue'] }}</h3>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <a href="{{ route('subscriptions.index', ['paymwnt_status' => 'due']) }}" class="text-decoration-none text-dark">
                    <h6 class="text-muted mb-2">Due Amount</h6>
                    <h3 class="fw-bold mb-0">₹{{ $statics['dueAmout'] }}</h3>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <a href="{{ route('leaves.index', ['status' => 'pending']) }}" class="text-decoration-none text-dark">
                    <h6 class="text-muted mb-2">Pending Leave</h6>
                    <h3 class="fw-bold mb-0">{{ $statics['pendingLeaves'] }}</h3>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <a href="{{ route('plans.index') }}" class="text-decoration-none text-dark">
                    <h6 class="text-muted mb-2">Total Plan</h6>
                    <h3 class="fw-bold mb-0">{{ $statics['plans'] }}</h3>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-1">
    <!-- Expiring Soon -->
    <div class="col-lg-6">
        <div class="card shadow-sm rounded-4 overflow-auto h-100">
            <!-- Header -->
            <div class="card-header bg-warning bg-opacity-10 border-0 py-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1 text-warning fw-bold">
                            <i class="bi bi-clock-history me-2"></i>
                            Expiring Soon
                        </h5>
                        <small class="text-muted">
                            Subscriptions expiring within 7 days
                        </small>
                    </div>
                    <div class="bg-warning text-dark rounded-pill px-3 py-2 fw-bold">
                        {{ $subscriptionsExpiringSoon->count() }}
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="card-body p-0">
                @forelse($subscriptionsExpiringSoon as $subscription)
                    @php
                        $daysLeft = now()->diffInDays($subscription->end_date, false);
                    @endphp
                    <div class="d-flex justify-content-between align-items-center p-3 border-bottom flex-wrap gap-3">
                        <!-- Left Section -->
                        <div class="d-flex align-items-center flex-grow-1">

                            <!-- Avatar -->
                            <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center fw-bold shadow-sm me-3"
                                style="width:55px;height:55px;font-size:20px;min-width:55px;">
                                {{ strtoupper(substr($subscription->customer->name ?? 'C',0,1)) }}
                            </div>

                            <!-- Customer Details -->
                            <div>
                                <h6 class="mb-1 fw-bold text-dark">
                                    {{ $subscription->customer->name ?? '' }}
                                </h6>

                                <div class="d-flex flex-wrap gap-2 align-items-center">

                                    <span class="badge bg-light text-dark border">
                                        <i class="fa fa-utensils me-1 text-warning"></i>
                                        {{ $subscription->plan->name ?? '' }}
                                    </span>

                                    <small class="text-muted">
                                        <i class="fa fa-phone me-1"></i>
                                        {{ $subscription->customer->mobile ?? '' }}
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Expiry -->
                        <div class="text-center px-2">
                            <small class="text-muted d-block mb-1">
                                Expiry Date
                            </small>

                            <div class="fw-semibold text-dark">
                                {{ \Carbon\Carbon::parse($subscription->end_date)->format('d M Y') }}
                            </div>
                        </div>

                        <!-- Days Left -->
                        <div class="text-center px-2">
                            <small class="text-muted d-block mb-1">
                                Remaining
                            </small>

                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                {{ ceil($daysLeft) }} Days Left
                            </span>
                        </div>

                        <!-- WhatsApp Button -->
                        <div>
                            @php
                                $whatsappUrl = expireSoonWhatsappUrl(
                                    $subscription->customer->name,
                                    $subscription->customer->mobile,
                                    $subscription->plan->name,
                                    $subscription->end_date
                                );
                            @endphp
                            <a href="{{ $whatsappUrl }}"
                                target="_blank"
                                class="btn btn-success btn-sm rounded-pill px-3 shadow-sm">
                                <i class="fa-brands fa-whatsapp me-1"></i>
                                Remind
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="bi bi-check-circle text-success fs-1"></i>
                        <h6 class="mt-3 mb-1">
                            All subscriptions are active
                        </h6>
                        <small class="text-muted">
                            No subscriptions expiring soon
                        </small>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Expired Subscriptions -->
    <div class="col-lg-6">
        <div class="card shadow-sm rounded-4 overflow-auto h-100">
            <!-- Header -->
            <div class="card-header bg-danger bg-opacity-10 border-0 py-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1 text-danger fw-bold">
                            <i class="bi bi-x-circle me-2"></i>
                            Expired Subscriptions
                        </h5>

                        <small class="text-muted">
                            Recently expired subscriptions
                        </small>
                    </div>

                    <div class="bg-danger text-white rounded-pill px-3 py-2 fw-bold">
                        {{ $expiredSubscriptions->count() }}
                    </div>

                </div>
            </div>

            <!-- Body -->
            <div class="card-body p-0">
                @forelse($expiredSubscriptions as $subscription)
                    <div class="d-flex justify-content-between align-items-center p-3 border-bottom flex-wrap gap-3">
                        <!-- Customer -->
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center fw-bold me-3"
                                style="width:50px;height:50px;">
                                {{ strtoupper(substr($subscription->customer->name ?? 'C',0,1)) }}
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold">
                                    {{ $subscription->customer->name ?? '' }}
                                </h6>

                                <small class="text-muted">
                                    {{ $subscription->customer->mobile ?? '' }}
                                </small>
                            </div>
                        </div>

                        <!-- Plan -->
                        <div>
                            <span class="badge bg-light text-dark border px-3 py-2">
                                {{ $subscription->plan->name ?? '' }}
                            </span>
                        </div>

                        <!-- Expired Date -->
                        <div class="text-md-end">
                            <small class="text-muted d-block">
                                Expired On
                            </small>

                            <span class="fw-semibold">
                                {{ \Carbon\Carbon::parse($subscription->end_date)->format('d M Y') }}
                            </span>
                        </div>

                        <!-- Status -->
                        <div>
                            <span class="badge bg-danger px-3 py-2 rounded-pill">
                                Expired
                            </span>
                        </div>

                         <!-- WhatsApp Button -->
                        <div>
                            @php
                                $whatsappUrl = expiredWhatsappUrl(
                                    $subscription->customer->name,
                                    $subscription->customer->mobile,
                                    $subscription->plan->name,
                                    $subscription->end_date,
                                );
                            @endphp
                            <a href="{{ $whatsappUrl }}"
                                target="_blank"
                                class="btn btn-success btn-sm rounded-pill px-3 shadow-sm">
                                    <i class="fa-brands fa-whatsapp me-1"></i>
                                    Remind
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="bi bi-emoji-smile text-success fs-1"></i>
                        <h6 class="mt-3 mb-1">
                            No expired subscriptions
                        </h6>
                        <small class="text-muted">
                            Everything looks good
                        </small>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection