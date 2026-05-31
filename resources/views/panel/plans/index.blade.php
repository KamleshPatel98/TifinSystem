@extends('layouts.panel')

@section('title', 'Dashboard')

@section('content')
{{-- Page Header Card --}}
<div class="card border-0 shadow rounded-4 bg-white mb-2">
    <div class="card-header bg-white border-bottom py-3 px-3 px-md-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h5 class="mb-0 fw-semibold">Plan Management</h5>
                <small class="text-muted">Create, edit, and manage system plans.</small>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fa fa-plus me-2"></i> Add Plan
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Plan Table Card --}}
<div class="card border-0 shadow rounded-0 bg-white">
    {{-- Card Header with Filter --}}
    <div class="card-header bg-white border-bottom py-3 px-3 px-md-4">
        <form action="{{ route('plans.index') }}" method="GET">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <h5 class="mb-0 fw-semibold">🎯 Plan List</h5>
                </div>
                <div class="col-md-3">
                    <input type="text" name="name" value="{{ request('name') }}" placeholder="Search by name..." class="form-control">
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
                    <a href="{{ route('plans.index') }}" class="btn btn-outline-secondary">
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
                        <th>Duration</th>
                        <th>Price</th>
                        <th>Total Days</th>
                        <th>Meal Time</th>
                        <th>Description</th>
                        <th class="text-center">Is Active</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($records as $row)
                    <tr>
                        <td class="text-end"> {{ ($records->currentPage() - 1) * $records->perPage() + $loop->iteration }}</td>
                        <td>{{ $row->name ?? '' }}</td>
                        <td>{{ $row->duration ?? '' }}</td>
                        <td>₹{{ number_format($row->price ?? 0, 2) }}</td>
                        <td>{{ $row->total_days ?? '' }}</td>
                        <td>{{ $row->meal_time ?? '' }}</td>
                        <td>{{ $row->description ?? '' }}</td>
                        <td class="text-center">@include('includes.is-active')</td>
                        <td class="text-center d-flex justify-content-center">
                            <a href="#" class="btn btn-sm btn-outline-warning me-1" title="Edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $row->id }}">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No Plan Found!</td>
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

{{-- Add Plan Modal --}}
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addStateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStateModalLabel">Add New Plan <i class="fa fa-plus"></i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('plans.store') }}" method="POST">
                @csrf
                <div class="modal-body row">
                    <input type="hidden" name="form_mode" value="create">
                    <!-- Package Name -->
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">
                            Package Name <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                            class="form-control"
                            id="name"
                            name="name"
                            maxlength="100"
                            value="{{ old('name') }}"
                            placeholder="Enter package name"
                            required>
                    </div>

                    <!-- Duration -->
                    <div class="col-md-6 mb-3">
                        <label for="duration" class="form-label">
                            Duration <span class="text-danger">*</span>
                        </label>
                        <select class="form-select"
                                id="duration"
                                name="duration"
                                required>
                            <option value="">Select Duration</option>
                            <option value="Weekly" {{ old('duration') == 'Weekly' ? 'selected' : '' }}>
                                Weekly
                            </option>
                            <option value="Monthly" {{ old('duration') == 'Monthly' ? 'selected' : '' }}>
                                Monthly
                            </option>
                        </select>
                    </div>

                    <!-- Price -->
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">
                            Price <span class="text-danger">*</span>
                        </label>
                        <input type="number"
                            step="0.01"
                            class="form-control"
                            id="price"
                            name="price"
                            value="{{ old('price') }}"
                            placeholder="Enter package price"
                            required>
                    </div>

                    <!-- Total Days -->
                    <div class="col-md-6 mb-3">
                        <label for="total_days" class="form-label">
                            Total Days <span class="text-danger">*</span>
                        </label>
                        <input type="number"
                            class="form-control"
                            id="total_days"
                            name="total_days"
                            value="{{ old('total_days') }}"
                            placeholder="Enter total days"
                            required>
                    </div>

                    <!-- Meal Time -->
                    <div class="col-md-6 mb-3">
                        <label for="meal_time" class="form-label">
                            Meal Time <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="meal_time" class="form-control" value="{{ old('meal_time') }}" placeholder="Enter meal time" required>
                    </div>

                    <!-- Description -->
                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">
                            Description
                        </label>
                        <textarea class="form-control"
                                id="description"
                                name="description"
                                rows="4"
                                placeholder="Enter package description">{{ old('description') }}</textarea>
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

{{-- Edit Plan Modal --}}
@foreach($records as $row)
<div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $row->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $row->id }}">Edit Plan <i class="fa fa-edit"></i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('plans.update', $row->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body row">
                    <input type="hidden" name="form_mode" value="edit">
                    <input type="hidden" name="edit_id" value="{{ $row->id }}">

                    <!-- Package Name -->
                    <div class="col-md-6 mb-3">
                        <label for="name{{ $row->id }}" class="form-label">
                            Package Name <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                            class="form-control"
                            id="name{{ $row->id }}"
                            name="name"
                            maxlength="100"
                            value="{{ old('name', $row->name) }}"
                            required
                            placeholder="Enter package name">
                    </div>

                    <!-- Duration -->
                    <div class="col-md-6 mb-3">
                        <label for="duration{{ $row->id }}" class="form-label">
                            Duration <span class="text-danger">*</span>
                        </label>
                        <select class="form-select"
                                id="duration{{ $row->id }}"
                                name="duration"
                                required>
                            <option value="">Select Duration</option>
                            <option value="Weekly"
                                {{ old('duration', $row->duration) == 'Weekly' ? 'selected' : '' }}>
                                Weekly
                            </option>
                            <option value="Monthly"
                                {{ old('duration', $row->duration) == 'Monthly' ? 'selected' : '' }}>
                                Monthly
                            </option>
                        </select>
                    </div>

                    <!-- Price -->
                    <div class="col-md-6 mb-3">
                        <label for="price{{ $row->id }}" class="form-label">
                            Price <span class="text-danger">*</span>
                        </label>
                        <input type="number"
                            step="0.01"
                            class="form-control"
                            id="price{{ $row->id }}"
                            name="price"
                            value="{{ old('price', $row->price) }}"
                            required
                            placeholder="Enter package price">
                    </div>

                    <!-- Total Days -->
                    <div class="col-md-6 mb-3">
                        <label for="total_days{{ $row->id }}" class="form-label">
                            Total Days <span class="text-danger">*</span>
                        </label>
                        <input type="number"
                            class="form-control"
                            id="total_days{{ $row->id }}"
                            name="total_days"
                            value="{{ old('total_days', $row->total_days) }}"
                            required
                            placeholder="Enter total days">
                    </div>

                    <!-- Meal Time -->
                    <div class="col-md-6 mb-3">
                        <label for="meal_time{{ $row->id }}" class="form-label">
                            Meal Time <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="meal_time" class="form-control" value="{{ old('meal_time', $row->meal_time) }}" placeholder="Enter meal time" required>
                    </div>

                    <!-- Description -->
                    <div class="col-md-12 mb-3">
                        <label for="description{{ $row->id }}" class="form-label">
                            Description
                        </label>

                        <textarea class="form-control"
                                id="description{{ $row->id }}"
                                name="description"
                                rows="4"
                                placeholder="Enter package description">{{ old('description', $row->description) }}</textarea>
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