@extends('layouts.panel')

@section('title', 'Dashboard')

@section('content')
{{-- Page Header Card --}}
<div class="card border-0 shadow rounded-4 bg-white mb-2">
    <div class="card-header bg-white border-bottom py-3 px-3 px-md-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h5 class="mb-0 fw-semibold">City Management</h5>
                <small class="text-muted">Create, edit, and manage system cities.</small>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fa fa-plus me-2"></i> Add City
                </a>
            </div>
        </div>
    </div>
</div>

{{-- City Table Card --}}
<div class="card border-0 shadow rounded-0 bg-white">
    {{-- Card Header with Filter --}}
    <div class="card-header bg-white border-bottom py-3 px-3 px-md-4">
        <form action="{{ route('cities.index') }}" method="GET">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <h5 class="mb-0 fw-semibold">🎯 City List</h5>
                </div>
                <div class="col-md-2">
                    <select name="state_id" class="form-select select-dropdown">
                        <option value="">Select State</option>
                        @foreach ($states as $state)
                        <option value="{{ $state->id }}" @selected(request('state_id')==$state->id)>{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="name" value="{{ request('name') }}" placeholder="Search by name..." class="form-control">
                </div>
                {{-- <div class="col-md-2">
                        <input type="text" name="code" value="{{ request('code') }}" placeholder="Search by code..." class="form-control">
            </div> --}}
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
                <a href="{{ route('cities.index') }}" class="btn btn-outline-secondary">
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
                    <th>State Name</th>
                    <th>Name</th>
                    <th class="text-center">Is Active</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($records as $row)
                <tr>
                    <td class="text-end">{{ $loop->iteration }}</td>
                    <td>{{ $row->state->name ?? '' }}</td>
                    <td>{{ $row->name ?? '' }}</td>
                    <td class="text-center">@include('includes.is-active')</td>
                    <td class="text-center d-flex justify-content-center">
                        <a href="#" class="btn btn-sm btn-outline-warning me-1" title="Edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $row->id }}">
                            <i class="fa fa-edit"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No City Found!</td>
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

{{-- Add City Modal --}}
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addStateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStateModalLabel">Add New City <i class="fa fa-plus"></i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('cities.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="form_mode" value="create">
                    <div class="mb-3">
                        <label for="state_id" class="form-label">State <span class="text-danger">*</span></label>
                        <select class="form-select modal-select-dropdown" id="state_id" name="state_id" required>
                            @foreach($states as $state)
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">City Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" maxlength="255" value="{{ old('name') }}" required placeholder="Enter country name">
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

@foreach ($records as $row)
<div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST" action="{{ route('cities.update', $row->id) }}">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Edit City</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">State <span class="text-danger">*</span></label>
                        <select class="form-select select2-edit" id="edit_state_id" name="state_id" required>
                            @foreach($states as $state)
                            <option value="{{ $state->id }}" @selected(old('state_id', $row->state_id)==$state->id)>{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">City Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_name" name="name" maxlength="255" value="{{ old('name', $row->name) }}" required placeholder="Enter country name">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_is_active" name="is_active" required>
                            <option value="1" @selected(old('is_active', $row->is_active)==1)>Active</option>
                            <option value="0" @selected(old('is_active', $row->is_active)==0)>Inactive</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
    $('#editModal{{ $row->id }}').on('shown.bs.modal', function() {
        $(this).find('.select2-edit').select2({
            dropdownParent: $('#editModal{{ $row->id }}'),
            width: '100%',
            placeholder: 'Select State'
        });
    });
</script>
@endforeach

@endsection

@push('scripts')
@if ($errors->any())
<script>
    $(document).ready(function() {
        @if(old('form_mode') === 'create')
        $('#addModal').modal('show');
        @elseif(old('form_mode') === 'edit')
        $('#editModal{{ old('
            id ') }}').modal('show');
        @endif
    });
</script>
@endif
@endpush