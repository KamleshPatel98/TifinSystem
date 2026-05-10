@extends('layouts.panel')

@section('title', 'Vendor List')

@section('content')
{{-- Page Header Card --}}
<div class="card border-0 shadow rounded-4 bg-white mb-2">
    <div class="card-header bg-white border-bottom py-3 px-3 px-md-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h5 class="mb-0 fw-semibold">Vendor Management</h5>
                <small class="text-muted">Create, view, and manage vendors.</small>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('vendors.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus me-2"></i> Add New
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Vendor  Table Card --}}
<div class="card border-0 shadow bg-white">
    <div class="card-header bg-white border-bottom py-3 px-3 px-md-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 fw-semibold">🎯 {{ $list }} Vendor List</h5>
        </div>

        {{-- Filter Form --}}
        <form action="{{ url()->current() }}" method="GET">
            <div class="row g-3 align-items-center">

                {{-- Search Fields --}}
                <div class="col-md">
                    <input type="text" name="bussiness_name" id="bussiness_name"
                        placeholder="Search by bussiness_name..." class="form-control" value="{{ request('bussiness_name') }}">
                </div>
                <div class="col-md">
                    <input type="text" name="phone_number" id="phone_number"
                        placeholder="Search by phone_number..." class="form-control" value="{{ request('phone_number') }}">
                </div>
                <div class="col-md">
                    <select name="approved_status" class="form-select" id="approved_status">
                        <option value="">All Status</option>
                        <option value="pending" @selected(request('approved_status')=='pending' )>Pending</option>
                        <option value="approved" @selected(request('approved_status')=='approved' )>Approved</option>
                        <option value="rejected" @selected(request('approved_status')=='rejected' )>Rejected</option>
                    </select>
                </div>

                <div class="col-md">
                    <select name="status" class="form-select" id="status">
                        <option value="">All Status</option>
                        <option value="active" @selected(request('status')=='active' )>Active</option>
                        <option value="inactive" @selected(request('status')=='inactive' )>Inactive</option>
                        <option value="blocked" @selected(request('status')=='blocked' )>Blocked</option>
                    </select>
                </div>

                {{-- Actions --}}
                <div class="col-md d-flex gap-2">
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
            <table class="table table-bordered table-hover" id="rolesTable">
                <thead class="table-light">
                    <tr>
                        <th class="text-end">SN.</th>
                        <th class="text-start">Bussiness</th>
                        <th class="text-start">Phone Number</th>
                        <th class="text-start">State</th>
                        <th class="text-center">City</th>
                        <th class="text-center">Approved Status</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="list-data">
                    @foreach ($records as $row)
                    <tr>
                        <td class="text-end">{{ ($records->currentPage() -1) * $records->perPage() + $loop->iteration }}</td>
                        <td class="text-start">
                            @if ($row->user->profile_url)
                            <a href="{{ $row->user->profile_url }}" target="_blank">
                                <img src="{{ $row->user->profile_url }}" alt="Vendor Image" width="50" height="50" class="rounded-circle" loading="lazy">
                            </a>
                            @endif
                            {{ $row->bussiness_name ?? '' }}
                        </td>
                        <td>{{ $row->phone_number ?? ''}}</td>
                        <td class="text-start">{{ $row->state->name ?? '' }}</td>
                        <td class="text-center">{{ $row->city->name ?? '' }}</td>
                        <td class="text-center">
                            @include('includes.approved-status')
                        </td>
                        <td class="text-center">
                            @php
                            $badgeClasses = [
                            'active' => 'bg-success',
                            'inactive' => 'bg-secondary',
                            'blocked' => 'bg-danger',
                            ];
                            @endphp

                            <span class="badge {{ $badgeClasses[$row->user->status] ?? 'bg-dark' }}">
                                {{ ucfirst($row->user->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('vendors.show',$row) }}"
                                class="btn btn-sm btn-outline-info me-1"
                                title="View Details">
                                <i class="fa-solid fa-eye"></i>
                            </a>

                            <a href="{{ route('vendors.edit',$row) }}"
                                class="btn btn-sm btn-outline-warning me-1"
                                title="Edit Vendor">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
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