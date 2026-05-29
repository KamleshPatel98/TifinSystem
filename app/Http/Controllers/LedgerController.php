<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentMode;
use App\Models\Transaction;
use Illuminate\Http\Request;

class LedgerController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->start_date ?? date('d-m-Y');
        $endDate = $request->end_date ?? date('d-m-Y');

        $openingIncome = Payment::whereDate('date', '<', formatDateToYmd($startDate))
            ->sum('amount');

        $openingTransactionIncome = Transaction::where('type', 'income')
            ->whereDate('date', '<', formatDateToYmd($startDate))
            ->sum('amount');

        $openingExpense = Transaction::where('type', 'expense')
            ->whereDate('date', '<', formatDateToYmd($startDate))
            ->sum('amount');

        $openingBalance =
            ($openingIncome + $openingTransactionIncome)
            - $openingExpense;

        if ($request->type != 'expense') {
            // Payments => Income
            $payments = Payment::whereDate('date', '>=', formatDateToYmd($startDate))
                ->whereDate('date', '<=', formatDateToYmd($endDate))
                ->when($request->payment_mode_id, function ($q) use ($request) {
                    $q->where('payment_mode_id', $request->payment_mode_id);
                })
                ->selectRaw("
                    date,
                    'Payment Received' as description,
                    amount as credit,
                    0 as debit,
                    'income' as type,
                    payment_mode_id,
                    created_at
                ");
        }

        // Transactions
        $transactions = Transaction::whereDate('date', '>=', formatDateToYmd($startDate))
            ->whereDate('date', '<=', formatDateToYmd($endDate))
            ->when($request->type, function ($q) use ($request) {
                $q->where('type', $request->type);
            })
            ->when($request->payment_mode_id, function ($q) use ($request) {
                $q->where('payment_mode_id', $request->payment_mode_id);
            })
            ->selectRaw("
                date,
                description,
                CASE WHEN type='income' THEN amount ELSE 0 END as credit,
                CASE WHEN type='expense' THEN amount ELSE 0 END as debit,
                type,
                payment_mode_id,
                created_at
            ");

        if ($request->type == 'expense') {
            $ledgers = $transactions
                ->orderBy('date', 'asc')
                ->orderBy('created_at', 'asc')
                ->get();

        } else {
            $ledgers = $payments
                ->unionAll($transactions)
                ->orderBy('date', 'asc')
                ->orderBy('created_at', 'asc')
                ->get();
        }

        // Running Balance
        $balance = $openingBalance;

        $ledgers->transform(function ($item) use (&$balance) {

            $balance += $item->credit;
            $balance -= $item->debit;

            $item->balance = $balance;
            $item->date = formatDateTodmY($item->date);
            $item->created_at = formatDateTodmY($item->created_at);

            return $item;
        });

        $closingBalance = $balance;

        $paymentModes = PaymentMode::where('is_active', 1)->pluck('name','id');
        return view('panel.ledgers.index', compact('ledgers', 'paymentModes', 'openingBalance', 'closingBalance'));
    }
}
