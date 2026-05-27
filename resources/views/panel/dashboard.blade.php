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

<div class="row g-4 mb-4">
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
                <a href="{{ route('customers.index') }}" class="text-decoration-none text-dark">
                    <h6 class="text-muted mb-2">Active Subscription</h6>
                    <h3 class="fw-bold mb-0">{{ $statics['activeSubscriptions'] }}</h3>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <a href="{{ route('customers.index') }}" class="text-decoration-none text-dark">
                    <h6 class="text-muted mb-2">Revenue</h6>
                    <h3 class="fw-bold mb-0">₹{{ $statics['revenue'] }}</h3>
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
@endsection