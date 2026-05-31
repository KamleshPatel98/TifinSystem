@extends('layouts.panel')

@section('title', 'Transaction Management')

@section('content')

{{-- Page Header Card --}}
<div class="card border-0 shadow rounded-4 bg-white mb-2">
    <div class="card-header bg-white border-bottom py-3 px-3 px-md-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h5 class="mb-0 fw-semibold">Transaction Management</h5>
                <small class="text-muted">Manage income and expense transactions.</small>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <a href="#" class="btn btn-primary d-flex align-items-center"
                    data-bs-toggle="modal"
                    data-bs-target="#addModal">
                    <i class="fa fa-plus me-2"></i> Add Transaction
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Transaction Table Card --}}
<div class="card border-0 shadow rounded-0 bg-white">

    {{-- Filter --}}
    <div class="card-header bg-white border-bottom py-3 px-3 px-md-4">
        <form action="{{ route('transactions.index') }}" method="GET">
            <div class="row g-2 align-items-center">
                <div class="col-md-2">
                    <h5 class="mb-0 fw-semibold">💰 Transactions</h5>
                </div>
                <div class="col-md-2">
                    <select name="type" class="form-select">
                        <option value="">All Type</option>
                        <option value="income" @selected(request('type') == 'income')>Income</option>
                        <option value="expense" @selected(request('type') == 'expense')>Expense</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="text"
                        name="start_date"
                        value="{{ request('start_date') }}"
                        placeholder="Start Date""
                        autocomplete="OFF"
                        class="form-control datepicker">
                </div>
                <div class="col-md-2">
                    <input type="text"
                        name="end_date"
                        value="{{ request('end_date') }}"
                        placeholder="End Date"
                        autocomplete="OFF"
                        class="form-control datepicker">
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search me-1"></i> Search
                    </button>
                    <a href="{{ route('transactions.index') }}"
                        class="btn btn-outline-secondary">
                        <i class="fa fa-refresh me-1"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-end">SN.</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Payment Mode</th>
                        <th>Reference No</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($records as $row)
                    <tr>
                        <td class="text-end">
                            {{ ($records->currentPage() - 1) * $records->perPage() + $loop->iteration }}
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}
                        </td>
                        <td>
                            @if($row->type == 'income')
                            <span class="badge bg-success">
                                Income
                            </span>
                            @else
                            <span class="badge bg-danger">
                                Expense
                            </span>
                            @endif
                        </td>
                        <td>
                            {{ $row->description ?? '' }}
                        </td>
                        <td>
                            ₹ {{ number_format($row->amount, 2) }}
                        </td>
                        <td>
                            {{ $row->paymentMode->name ?? '-' }}
                        </td>
                        <td>
                            {{ $row->reference_no ?? '-' }}
                        </td>
                        <td class="text-center d-flex justify-content-center">

                            <a href="#"
                                class="btn btn-sm btn-outline-warning me-1"
                                title="Edit"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $row->id }}">
                                <i class="fa fa-edit"></i>
                            </a>

                            <form action="{{ route('transactions.destroy', $row->id) }}"
                                method="POST"
                                class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-outline-danger btn-sm"
                                        title="Delete""
                                        onclick="return confirm(
                                            'Are you sure you want to delete this transaction?'
                                        )">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            No Transaction Found!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3 px-3">
                {{ $records->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

{{-- Add Modal --}}
<div class="modal fade"
    id="addModal"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Add Transaction
                    <i class="fa fa-plus"></i>
                </h5>

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <form action="{{ route('transactions.store') }}"
                method="POST">

                @csrf

                <div class="modal-body">

                    <input type="hidden" name="form_mode" value="create">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Type <span class="text-danger">*</span>
                            </label>

                            <select name="type"
                                class="form-select"
                                required>

                                <option value="">Select Type</option>

                                <option value="income"
                                    @selected(old('type') == 'income')>
                                    Income
                                </option>

                                <option value="expense"
                                    @selected(old('type') == 'expense')>
                                    Expense
                                </option>

                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Date <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                name="date"
                                class="form-control datepicker"
                                value="{{ old('date', date('d-m-Y')) }}"
                                autocomplete="OFF"
                                required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Amount <span class="text-danger">*</span>
                            </label>

                            <input type="number"
                                step="0.01"
                                min="0"
                                name="amount"
                                class="form-control"
                                value="{{ old('amount') }}"
                                placeholder="Enter amount"
                                required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Payment Mode
                            </label>

                            <select name="payment_mode_id"
                                class="form-select">

                                <option value="">
                                    Select Payment Mode
                                </option>

                                @foreach($paymentModes as $paymentMode)

                                <option value="{{ $paymentMode->id }}"
                                    @selected(old('payment_mode_id') == $paymentMode->id)>

                                    {{ $paymentMode->name }}

                                </option>

                                @endforeach

                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">
                                Description <span class="text-danger">*</span>
                            </label>

                            <textarea name="description"
                                rows="3"
                                class="form-control"
                                placeholder="Enter description"
                                required>{{ old('description') }}</textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Reference No
                            </label>

                            <input type="text"
                                name="reference_no"
                                class="form-control"
                                value="{{ old('reference_no') }}"
                                placeholder="Enter reference no">
                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        <i class="fa fa-times"></i> Cancel

                    </button>

                    <button type="submit"
                        class="btn btn-primary">

                        <i class="fa fa-check"></i> Save

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

{{-- Edit Modal --}}
@foreach($records as $row)

<div class="modal fade"
    id="editModal{{ $row->id }}"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Edit Transaction
                    <i class="fa fa-edit"></i>
                </h5>

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <form action="{{ route('transactions.update', $row->id) }}"
                method="POST">

                @csrf
                @method('PUT')

                <div class="modal-body">

                    <input type="hidden" name="form_mode" value="edit">
                    <input type="hidden" name="edit_id" value="{{ $row->id }}">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Type <span class="text-danger">*</span>
                            </label>

                            <select name="type"
                                class="form-select"
                                required>

                                <option value="income"
                                    {{ $row->type == 'income' ? 'selected' : '' }}>
                                    Income
                                </option>

                                <option value="expense"
                                    {{ $row->type == 'expense' ? 'selected' : '' }}>
                                    Expense
                                </option>

                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Date <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                name="date"
                                class="form-control datepicker"
                                value="{{ $row->date }}"
                                autocomplete="OFF"
                                required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Amount <span class="text-danger">*</span>
                            </label>

                            <input type="number"
                                step="0.01"
                                min="0"
                                name="amount"
                                class="form-control"
                                value="{{ $row->amount }}"
                                required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Payment Mode
                            </label>

                            <select name="payment_mode_id"
                                class="form-select">

                                <option value="">
                                    Select Payment Mode
                                </option>

                                @foreach($paymentModes as $paymentMode)

                                <option value="{{ $paymentMode->id }}"
                                    {{ $row->payment_mode_id == $paymentMode->id ? 'selected' : '' }}>

                                    {{ $paymentMode->name }}

                                </option>

                                @endforeach

                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">
                                Description <span class="text-danger">*</span>
                            </label>

                            <textarea name="description"
                                rows="3"
                                class="form-control"
                                required>{{ $row->description }}</textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Reference No
                            </label>

                            <input type="text"
                                name="reference_no"
                                class="form-control"
                                value="{{ $row->reference_no }}"
                                placeholder="Enter reference no">
                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        <i class="fa fa-times"></i> Cancel

                    </button>

                    <button type="submit"
                        class="btn btn-primary">

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