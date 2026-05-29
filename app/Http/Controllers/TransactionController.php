<?php

namespace App\Http\Controllers;

use App\Models\PaymentMode;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $records = Transaction::orderBy('id', 'desc')
            ->when($request->type !== null, function ($q) use ($request) { 
                $q->where('type', $request->type); 
            }) 
            ->when($request->is_active !== null, function ($q) use ($request) { 
                $q->where('is_active', $request->is_active); 
            }) 
            ->when($request->start_date, function ($q) use ($request) { 
                $q->whereDate('date', '>=', formatDateToYmd($request->start_date)); 
            })
            ->when($request->end_date, function ($q) use ($request) { 
                $q->whereDate('date', '<=', formatDateToYmd($request->end_date)); 
            })
            ->paginate(getSetting('page_limit'));

        $paymentModes = PaymentMode::where('is_active', true) 
            ->orderBy('name') 
            ->get();
        return view('panel.transactions.index', compact('records', 'paymentModes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([ 
            'type' => 'required|in:income,expense', 
            'description' => 'required|string|max:255', 
            'amount' => 'required|numeric|min:0', 
            'date' => 'required|date', 
            'payment_mode_id' => 'nullable|exists:payment_modes,id', 
            'reference_no' => 'nullable|string|max:255', 
        ]); 

        $validated['date'] = formatDateToYmd($validated['date']);
        Transaction::create(array_merge($validated, ['vendor_id' => Auth::user()->vendor->id])); 
        return back()->with('success', 'Transaction created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([ 
            'type' => 'required|in:income,expense', 
            'description' => 'required|string|max:255', 
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date', 
            'payment_mode_id' => 'nullable|exists:payment_modes,id', 
            'reference_no' => 'nullable|string|max:255', 
        ]); 

        $validated['date'] = formatDateToYmd($validated['date']);
        $transaction->update($validated); 
        return back()->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete(); 
        return back()->with('success', 'Transaction deleted successfully.');
    }
}
