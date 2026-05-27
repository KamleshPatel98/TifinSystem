@extends('layouts.panel')

@section('title', 'Dashboard')

@section('content')
{{-- Page Header Card --}}
<div class="card border-0 shadow rounded-4 bg-white mb-2">
    <div class="card-header bg-white border-bottom py-3 px-3 px-md-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h5 class="mb-0 fw-semibold">Leave Management</h5>
                <small class="text-muted">Create, edit, and manage system leaves.</small>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fa fa-plus me-2"></i> Add Leave
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Leave Table Card --}}
<div class="card border-0 shadow rounded-0 bg-white">
    {{-- Card Header with Filter --}}
    <div class="card-header bg-white border-bottom py-3 px-3 px-md-4">
        <form action="{{ route('leaves.index') }}" method="GET">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <h5 class="mb-0 fw-semibold">🎯 Leave List</h5>
                </div>
                <div class="col-md-3">
                    <input type="text" name="customer" value="{{ request('customer') }}" placeholder="Search by customer name/mobile" class="form-control">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending" @selected(request('status')=='pending' )>Pending</option>
                        <option value="approved" @selected(request('status')=='approved' )>Approved</option>
                        <option value="rejected" @selected(request('status')=='rejected' )>Rejected</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search me-1"></i> Search
                    </button>
                    <a href="{{ route('leaves.index') }}" class="btn btn-outline-secondary">
                        <i class="fa fa-refresh me-1"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Table Section --}}
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="rolesTable">
                <thead class="table-light">
                    <tr>
                        <th class="text-end">SN.</th>
                        <th>Customer</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Total Days</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($records as $row)
                    <tr>
                        <td class="text-end"> {{ ($records->currentPage() - 1) * $records->perPage() + $loop->iteration }}</td>
                        <td class="d-flex align-items-center gap-2">
                            <img 
                                src="{{ $row->customer->profile_url ?? asset('assets/images/customer.webp') }}"
                                alt="Profile"
                                width="40"
                                height="40"
                                class="rounded-circle object-fit-cover border"
                                onerror="this.onerror=null;this.src='{{ asset('assets/images/customer.webp') }}';"
                            >

                            <div>
                                <div class="fw-semibold">
                                    {{ $row->customer->name ?? 'N/A' }}
                                </div>
                                <small class="text-muted">
                                    {{ $row->customer->mobile ?? '' }}
                                </small>
                            </div>
                        </td>
                        <td>{{ $row->start_date ?? '' }}</td>
                        <td>{{ $row->end_date ?? '' }}</td>
                        <td>{{ $row->total_days ?? '' }}</td>
                        <td class="text-center">
                            <span class="badge 
                                @if($row->status == 'pending') bg-warning
                                @elseif($row->status == 'approved') bg-success
                                @elseif($row->status == 'rejected') bg-danger
                                @endif">
                                
                                {{ ucfirst($row->status) }}
                            </span>
                        </td>
                        <td class="text-center d-flex justify-content-center">
                            @if($row->status != "approved")
                            <a href="#" class="btn btn-sm btn-outline-warning me-1" title="Edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $row->id }}">
                                <i class="fa fa-edit"></i>
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No Leave Found!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3 px-3" id="pagination-links">
                {{ $records->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

{{-- Edit Leave Modal --}}
@foreach($records as $row)
<div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $row->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $row->id }}">Edit Leave <i class="fa fa-edit"></i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('leaves.update', $row->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="form_mode" value="edit">
                    <input type="hidden" name="edit_id" value="{{ $row->id }}">
                    <input type="hidden" name="customer_id" value="{{ $row->customer_id }}">

                    <!-- Start Date -->
                    <div class="mb-3">
                        <label class="form-label">
                            Start Date <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                            name="start_date"
                            class="form-control datepicker"
                            autocomplete="OFF"
                            value="{{ old('start_date', $row->start_date ?? '') }}"
                            required>
                    </div>
                    <!-- End Date -->
                    <div class="mb-3">
                        <label class="form-label">
                            End Date <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                            name="end_date"
                            class="form-control datepicker"
                            autocomplete="OFF"
                            value="{{ old('end_date', $row->end_date ?? '') }}"
                            required>
                    </div>
                    <!-- Status -->
                    <div class="mb-3">
                        <label class="form-label">
                            Status
                        </label>
                        <select name="status" class="form-select" required>
                            <option value="pending" @selected(old('status', $row->status ?? '') == "pending")>Pending</option>
                            <option value="approved" @selected(old('status', $row->status ?? '') == "approved")>Approved</option>
                            <option value="rejected" @selected(old('status', $row->status ?? '') == "rejected")>Rejected</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection