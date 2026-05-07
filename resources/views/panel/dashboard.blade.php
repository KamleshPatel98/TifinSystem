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
                <h6 class="text-muted mb-2">Total Admins</h6>
                <h3 class="fw-bold mb-0">5</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted mb-2">Revenue</h6>
                <h3 class="fw-bold mb-0">₹3000</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted mb-2">Total Enquiries</h6>
                <h3 class="fw-bold mb-0">65</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted mb-2">Pending Enquiries</h6>
                <h3 class="fw-bold mb-0">5</h3>
            </div>
        </div>
    </div>
</div>
@endsection