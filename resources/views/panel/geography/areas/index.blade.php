@extends('layouts.panel')

@section('title', 'Dashboard')

@section('content')
{{-- Page Header Card --}}
<div class="card border-0 shadow rounded-4 bg-white mb-2">
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-1 py-md-3 px-2 px-md-4">
        <div>
            <h5 class="mb-0 fw-semibold">Area Management</h5>
            <small class="text-muted">Create, edit, and manage system areas.</small>
        </div>
        <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fa fa-plus me-2"></i> Add Area
        </a>
    </div>
</div>

{{-- Area Table Card --}}
<div class="card border-0 shadow rounded-0 bg-white">
    {{-- Card Header with Filter --}}
    <div class="card-header bg-white border-bottom py-3 py-md-3 px-2 px-md-4">
        <form action="{{ route('areas.index') }}" method="GET">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <h5 class="mb-0 fw-semibold">🎯 Area List</h5>
                </div>
                <div class="col-md-2">
                    <select name="state_id" class="form-select select-dropdown" id="search_state_id">
                        <option value="">All States</option>
                        @foreach($states as $state)
                        <option value="{{ $state->id }}" {{ $state->id == request('state_id') ? 'selected' : ''}}>{{ $state->name }}</option>
                        @endforeach
                    </select>
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
                    <a href="{{ route('areas.index') }}" class="btn btn-outline-secondary">
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
                        <th>City Name</th>
                        <th>Name</th>
                        <th class="text-center">Pin Code</th>
                        <th class="text-center">Is Active</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($records as $row)
                    <tr>
                        <td class="text-end">{{ $loop->iteration }}</td>
                        <td>{{ $row->state->name ?? '' }}</td>
                        <td>{{ $row->city->name ?? '' }}</td>
                        <td>{{ $row->name ?? '' }}</td>
                        <td class="text-center">{{ $row->pin_code ?? '' }}</td>
                        <td class="text-center">@include('includes.is-active')</td>
                        <td class="text-center d-flex justify-content-center">
                            {{-- <a href="#" class="btn btn-sm btn-outline-warning me-1" title="Edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $row->id }}">
                            <i class="fa fa-edit"></i>
                            </a> --}}
                            <a href="#"
                                class="btn btn-sm btn-outline-warning editAreaBtn"
                                data-bs-toggle="modal"
                                data-bs-target="#editAreaModal"
                                data-id="{{ $row->id }}"
                                data-state="{{ $row->state_id }}"
                                data-city="{{ $row->city_id }}"
                                data-name="{{ $row->name }}"
                                data-pin="{{ $row->pin_code }}"
                                data-active="{{ $row->is_active }}">
                                <i class="fa fa-edit"></i>
                            </a>


                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No Area Found!</td>
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

{{-- Add Area Modal --}}
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addStateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStateModalLabel">Add New Area <i class="fa fa-plus"></i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('areas.store') }}" method="POST">
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
                        <label for="city_id" class="form-label">City <span class="text-danger">*</span></label>
                        <select class="form-select modal-select-dropdown" id="city_id" name="city_id" required>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Area Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" maxlength="255" value="{{ old('name') }}" required placeholder="Enter country name">
                    </div>
                    <div class="mb-3">
                        <label for="pin_code" class="form-label">Pin Code</label>
                        <input type="text" class="form-control" id="pin_code" name="pin_code" maxlength="255" value="{{ old('pin_code') }}" placeholder="Enter country name">
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

<div class="modal fade" id="editAreaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST" id="editAreaForm">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Edit Area</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">State <span class="text-danger">*</span></label>
                        <select class="form-select modal-select-dropdown" id="edit_state_id" name="state_id" required>

                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">City <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_city_id" name="city_id" required>
                            <option value="">Select City</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Area Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="pin_code" class="form-label">Pin Code</label>
                        <input type="text" name="pin_code" class="form-control" id="edit_pin_code">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_is_active" name="is_active" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
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


@endsection

@push('scripts')
@if ($errors->any())
<script>
    $(document).ready(function() {
        @if(old('form_mode') === 'create')
        $('#addModal').modal('show');
        @endif
    });
</script>
@endif

<script>
    $(document).ready(function() {
        $('#state_id').on('change', function() {
            var stateId = $(this).val();
            $.ajax({
                url: "{{ route('dropdowns.city') }}",
                type: 'GET',
                data: {
                    state_id: stateId
                },
                success: function(data) {
                    $('#city_id').html(data);
                }
            });
        });
    });
</script>

<script>
    const areaUpdateRoute = "{{ route('areas.update', ':id') }}";

    $(document).on('click', '.editAreaBtn', function() {

        let id = $(this).data('id');
        let state = $(this).data('state');
        let city = $(this).data('city');
        let name = $(this).data('name');
        let pin = $(this).data('pin');
        let active = $(this).data('active');

        // Set form action
        let actionUrl = areaUpdateRoute.replace(':id', id);
        $('#editAreaForm').attr('action', actionUrl);

        // Set basic values
        $('#edit_name').val(name);
        $('#edit_pin_code').val(pin);
        $('#edit_is_active').val(active);

        // Load state & city
        loadStates(state, city);
    });

    /* ---------------------------
    State Change → Load Cities
    ----------------------------*/
    $('#edit_state_id').on('change', function() {
        let stateId = $(this).val();
        loadCities(stateId);
    });


    /* ---------------------------
    Load States Function
    ----------------------------*/
    function loadStates(selectedState = null, selectedCity = null) {

        $.ajax({
            url: "{{ route('dropdowns.state') }}",
            type: "GET",
            success: function(data) {

                $('#edit_state_id').html(data);

                if (selectedState) {
                    $('#edit_state_id').val(selectedState);
                }

                if (selectedState && selectedCity) {
                    loadCities(selectedState, selectedCity);
                }
            }
        });
    }


    /* ---------------------------
    Load Cities Function
    ----------------------------*/
    function loadCities(stateId, selectedCity = null) {

        $.ajax({
            url: "{{ route('dropdowns.city') }}",
            type: "GET",
            data: {
                state_id: stateId
            },

            success: function(data) {

                $('#edit_city_id').html(data);

                if (selectedCity) {
                    $('#edit_city_id').val(selectedCity);
                }
            }
        });
    }
</script>


@endpush