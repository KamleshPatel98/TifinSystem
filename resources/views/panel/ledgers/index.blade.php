@extends('layouts.panel')

@section('title', 'Ledger Management')

@section('content')

{{-- Page Header Card --}}
<div class="card border-0 shadow rounded-4 bg-white mb-2">
    <div class="card-header bg-white border-bottom py-3 px-3 px-md-4">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">

            <div>
                <h5 class="mb-0 fw-semibold">Ledger Management</h5>
                <small class="text-muted">
                    View all income and expense ledger entries.
                </small>
            </div>

        </div>

    </div>
</div>

{{-- Ledger Table Card --}}
<div class="card border-0 shadow rounded-0 bg-white">

    {{-- Card Header with Filter --}}
    <div class="card-header bg-white border-bottom py-3 px-3 px-md-4">

        <form action="{{ route('ledgers.index') }}" method="GET">

            <div class="row align-items-end">

                <div class="col-md-2">
                    <label class="form-label">Start Date</label>

                    <input type="text"
                        name="start_date"
                        value="{{ request('start_date') ?? date('d-m-Y') }}"
                        autocomplete="OFF"
                        class="form-control datepicker">
                </div>

                <div class="col-md-2">
                    <label class="form-label">End Date</label>

                    <input type="text"
                        name="end_date"
                        value="{{ request('end_date') ?? date('d-m-Y') }}"
                        autocomplete="OFF"
                        class="form-control datepicker">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Type</label>

                    <select name="type" class="form-select">

                        <option value="">All</option>

                        <option value="income"
                            @selected(request('type') == 'income')>
                            Income
                        </option>

                        <option value="expense"
                            @selected(request('type') == 'expense')>
                            Expense
                        </option>

                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Payment Mode</label>

                    <select name="payment_mode_id" class="form-select">

                        <option value="">All Payment Modes</option>

                        @foreach ($paymentModes as $id => $name)

                            <option value="{{ $id }}"
                                @selected(request('payment_mode_id') == $id)>

                                {{ $name }}

                            </option>

                        @endforeach

                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">

                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search me-1"></i> Search
                    </button>

                    <a href="{{ route('ledgers.index') }}"
                        class="btn btn-outline-secondary">

                        <i class="fa fa-refresh me-1"></i> Reset

                    </a>

                </div>

            </div>

        </form>

    </div>

    {{-- Table Section --}}
    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-bordered table-hover mb-0">

                <thead class="table-light">

                    <tr>

                        <th class="text-end">SN.</th>

                        <th>Date</th>

                        <th>Description</th>

                        <th>Mode</th>

                        <th class="text-end text-danger">
                            Debit
                        </th>

                        <th class="text-end text-success">
                            Credit
                        </th>

                        <th class="text-end">
                            Balance
                        </th>

                    </tr>

                </thead>

                {{-- Opening Balance Row --}}
                <tbody>

                    <tr class="table-info">

                        <td colspan="6" class="text-end fw-bold">
                            Opening Balance
                        </td>

                        <td class="text-end fw-bold">
                            ₹{{ number_format($openingBalance, 2) }}
                        </td>

                    </tr>

                    @php
                        $totalDebit = 0;
                        $totalCredit = 0;
                    @endphp

                    @forelse ($ledgers as $row)

                        @php
                            $totalDebit += $row->debit;
                            $totalCredit += $row->credit;
                        @endphp

                        <tr>

                            <td class="text-end">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $row->date }}
                            </td>

                            <td>
                                {{ $row->description }}
                            </td>

                            <td>{{ $row->paymentMode->name ?? '-' }}</td>

                            <td class="text-end text-danger">

                                @if($row->debit > 0)
                                    ₹{{ number_format($row->debit, 2) }}
                                @else
                                    -
                                @endif

                            </td>

                            <td class="text-end text-success">

                                @if($row->credit > 0)
                                    ₹{{ number_format($row->credit, 2) }}
                                @else
                                    -
                                @endif

                            </td>

                            <td class="text-end fw-bold">

                                ₹{{ number_format($row->balance, 2) }}

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="text-center">
                                No Ledger Record Found!
                            </td>
                        </tr>

                    @endforelse

                </tbody>
                <tfoot class="table-light">

                    <tr>

                        <th colspan="4" class="text-end">
                            Total
                        </th>

                        <th class="text-end text-danger">
                            ₹{{ number_format($totalDebit, 2) }}
                        </th>

                        <th class="text-end text-success">
                            ₹{{ number_format($totalCredit, 2) }}
                        </th>

                        <th class="text-end fw-bold">
                            ₹{{ number_format($closingBalance, 2) }}
                        </th>

                    </tr>

                    {{-- Closing Balance --}}
                    <tr class="table-success">

                        <th colspan="6" class="text-end">
                            Closing Balance
                        </th>

                        <th class="text-end fw-bold">
                            ₹{{ number_format($closingBalance, 2) }}
                        </th>

                    </tr>

                </tfoot>

            </table>

        </div>

    </div>

</div>

@endsection