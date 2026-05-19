@extends('layouts.panel')

@section('title', 'Dashboard')

@section('content')
{{-- Page Header Card --}}
<div class="card border-0 shadow rounded-4 bg-white mb-2">
    <div class="card-header bg-white border-bottom py-3 px-3 px-md-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h5 class="mb-0 fw-semibold">State Management</h5>
                <small class="text-muted">Create, edit, and manage system states.</small>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fa fa-plus me-2"></i> Add State
                </a>
            </div>
        </div>
    </div>
</div>

{{-- State Table Card --}}
<div class="card border-0 shadow rounded-0 bg-white">
    {{-- Card Header with Filter --}}
    <div class="card-header bg-white border-bottom py-3 px-3 px-md-4">
        <form action="{{ route('states.index') }}" method="GET">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <h5 class="mb-0 fw-semibold">🎯 State List</h5>
                </div>
                <div class="col-md-3">
                    <input type="text" name="name" value="{{ request('name') }}" placeholder="Search by name..." class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="text" name="code" value="{{ request('code') }}" placeholder="Search by code..." class="form-control">
                </div>
                <div class="col-md-2">
                    <select name="is_active" class="form-select">
                        <option value="">All Is Active</option>
                        <option value="1" @selected(request('is_active')=='1' )>Active</option>
                        <option value="0" @selected(request('is_active')=='0' )>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search me-1"></i> Search
                    </button>
                    <a href="{{ route('states.index') }}" class="btn btn-outline-secondary">
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
                        <th>Name</th>
                        <th>Code</th>
                        <th class="text-center">Is Active</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($records as $row)
                    <tr>
                        <td class="text-end"> {{ ($records->currentPage() - 1) * $records->perPage() + $loop->iteration }}</td>
                        <td>{{ $row->name ?? '' }}</td>
                        <td>{{ $row->code ?? '' }}</td>
                        <td class="text-center">@include('includes.is-active')</td>
                        <td class="text-center d-flex justify-content-center">
                            <a href="#" class="btn btn-sm btn-outline-warning me-1" title="Edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $row->id }}">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No State Found!</td>
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

{{-- Add State Modal --}}
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addStateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStateModalLabel">Add New State <i class="fa fa-plus"></i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('states.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="form_mode" value="create">
                    <div class="mb-3">
                        <label for="name" class="form-label">State Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" maxlength="255" value="{{ old('name') }}" required placeholder="Enter country name">
                    </div>
                    <div class="mb-3">
                        <label for="code" class="form-label">State Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="code" name="code" maxlength="255" value="{{ old('code') }}" required placeholder="Enter country code">
                    </div>
                    <div class="mb-3">
                        <label for="is_active" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="is_active" name="is_active" required>
                            <option value="1" @selected(old('is_active')=='1' )>Active</option>
                            <option value="0" @selected(old('is_active')=='0' )>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check"></i> Add
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit State Modal --}}
@foreach($records as $row)
<div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $row->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $row->id }}">Edit State <i class="fa fa-edit"></i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('states.update', $row->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="form_mode" value="edit">
                    <input type="hidden" name="edit_id" value="{{ $row->id }}">

                    <div class="mb-3">
                        <label for="name{{ $row->id }}" class="form-label">State Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name{{ $row->id }}" name="name" value="{{ $row->name }}" required placeholder="Enter country name">
                    </div>
                    <div class="mb-3">
                        <label for="code{{ $row->id }}" class="form-label">State Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="code{{ $row->id }}" name="code" value="{{ $row->code }}" required placeholder="Enter country code">
                    </div>
                    <div class="mb-3">
                        <label for="is_active{{ $row->id }}" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="is_active{{ $row->id }}" name="is_active" required>
                            <option value="1" {{ $row->is_active == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $row->is_active == '0' ? 'selected' : '' }}>Inactive</option>
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

@push('scripts')
@if ($errors->any())
<script>
    $(document).ready(function() {
        @if(old('form_mode') === 'create')
        $('#addModal').modal('show');
        @elseif(old('form_mode') === 'edit')
        $('#editModal{{ old("edit_id") }}').modal('show');
        @endif
    });
</script>
@endif
@endpush