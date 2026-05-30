<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ getsetting('app_name') }} | Ledger Report</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #333;
            margin: 15px;
        }

        .header-table,
        .report-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            border: none !important;
            padding: 2px;
        }

        .logo {
            width: 70px;
            height: auto;
        }

        .company-name {
            font-size: 22px;
            font-weight: bold;
            color: #000;
        }

        .company-info {
            font-size: 11px;
            color: #555;
            line-height: 18px;
        }

        .report-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 10px 0;
        }

        .divider {
            border: none;
            border-top: 1px solid #999;
            margin: 10px 0;
        }

        .report-table th {
            background: #e5e7eb;
            border: 1px solid #999;
            padding: 8px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
        }

        .report-table td {
            border: 1px solid #cfcfcf;
            padding: 7px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .opening-balance {
            background: #eaf4ff;
            font-weight: bold;
        }

        .total-row {
            background: #f3f4f6;
            font-weight: bold;
        }

        .closing-balance {
            background: #e8f8ec;
            font-weight: bold;
        }

        .footer {
            margin-top: 15px;
            text-align: center;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>

<body>

    {{-- Header --}}
    <table class="header-table">

        <tr>

            <td width="15%">
                <img src="{{ public_path('assets/images/logo.jpg') }}" class="logo">
            </td>

            <td width="70%" class="text-center">

                <div class="company-name">
                    {{ getsetting('app_name') }}
                </div>

                @if(getsetting('app_address'))
                    <div class="company-info">
                        {{ getsetting('app_address') }}
                    </div>
                @endif

                <div class="company-info">
                    Mobile : {{ getsetting('app_phone') }}
                </div>

                @if(getsetting('app_email'))
                    <div class="company-info">
                        Email : {{ getsetting('app_email') }}
                    </div>
                @endif

            </td>

            <td width="15%" class="text-right">

                <strong>Generated On</strong><br>

                {{ now()->format('d-m-Y') }}

            </td>

        </tr>

    </table>

    <hr class="divider">

    <div class="report-title">
        Ledger Report
    </div>

    <table class="header-table" style="margin-bottom:15px;">

        <tr>

            <td width="33%">
                <strong>From :</strong>
                {{ request('start_date') ?? date('d-m-Y') }}
            </td>

            <td width="33%">
                <strong>To :</strong>
                {{ request('end_date') ?? date('d-m-Y') }}
            </td>

            <td width="34%" class="text-right">
                <strong>Type :</strong>
                {{ request('type') ? ucfirst(request('type')) : 'All' }}
            </td>

        </tr>

    </table>

    {{-- Ledger Table --}}
    <table class="report-table">

        <thead>

            <tr>
                <th width="5%">SN</th>
                <th width="12%">Date</th>
                <th width="30%">Description</th>
                <th width="15%">Mode</th>
                <th width="12%">Debit</th>
                <th width="12%">Credit</th>
                <th width="14%">Balance</th>
            </tr>

        </thead>

        <tbody>

            <tr class="opening-balance">

                <td colspan="6" class="text-right">
                    Opening Balance
                </td>

                <td class="text-right">
                    ₹{{ number_format($openingBalance, 2) }}
                </td>

            </tr>

            @php
                $totalDebit = 0;
                $totalCredit = 0;
            @endphp

            @forelse($ledgers as $row)

                @php
                    $totalDebit += $row->debit;
                    $totalCredit += $row->credit;
                @endphp

                <tr>

                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $row->date }}
                    </td>

                    <td>
                        {{ $row->description }}
                    </td>

                    <td>
                        {{ $row->paymentMode->name ?? '-' }}
                    </td>

                    <td class="text-right">
                        {{ $row->debit > 0 ? '₹'.number_format($row->debit,2) : '-' }}
                    </td>

                    <td class="text-right">
                        {{ $row->credit > 0 ? '₹'.number_format($row->credit,2) : '-' }}
                    </td>

                    <td class="text-right">
                        ₹{{ number_format($row->balance,2) }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="7" class="text-center">
                        No Ledger Record Found
                    </td>

                </tr>

            @endforelse

        </tbody>

        <tfoot>

            <tr class="total-row">

                <td colspan="4" class="text-right">
                    Total
                </td>

                <td class="text-right">
                    ₹{{ number_format($totalDebit,2) }}
                </td>

                <td class="text-right">
                    ₹{{ number_format($totalCredit,2) }}
                </td>

                <td class="text-right">
                    ₹{{ number_format($closingBalance,2) }}
                </td>

            </tr>

            <tr class="closing-balance">

                <td colspan="6" class="text-right">
                    Closing Balance
                </td>

                <td class="text-right">
                    ₹{{ number_format($closingBalance,2) }}
                </td>

            </tr>

        </tfoot>

    </table>

    <div class="footer">
        This is a system generated ledger report.
    </div>

</body>

</html>