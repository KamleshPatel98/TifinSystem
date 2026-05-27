<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $records = Leave::with('customer:id,name,mobile,profile_pic')
            ->when($request->customer !== null, function ($q) use ($request) {
                $q->whereRelation('customer', 'name', 'like', '%' . $request->customer . '%')
                    ->orWhereRelation('customer', 'mobile', 'like', '%' . $request->customer . '%');
            })
            ->when($request->statuss !== null, function ($q) use ($request) {
                $q->where('statuss', $request->statuss);
            })
            ->latest()
            ->paginate(getSetting('page_limit'));
        return view('panel.leaves.index', compact('records'));
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
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'status'      => 'required|in:pending,approved,rejected',
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate   = Carbon::parse($request->end_date);
        $totalDays = $startDate->diffInDays($endDate) + 1;

        // exist check
        $alreadyExists = Leave::where('customer_id', $request->customer_id)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);

                    });

            })
            ->exists();
        if ($alreadyExists) {
            return back()->with('error', 'Leave already exists for selected date range.');
        }

        Leave::create([
            'vendor_id'   => Auth::user()->vendor->id ?? null,
            'customer_id' => $request->customer_id,
            'start_date'  => $startDate,
            'end_date'    => $request->end_date ? $endDate : null,
            'total_days'  => $request->end_date ? $totalDays : null,
            'status'      => $request->status,
        ]);

        $subscription = Subscription::where('customer_id', $request->customer_id)
            ->where('start_date', '<=', $startDate)
            ->where('end_date', '>=', $endDate)
            ->where('is_active', true)
            ->first();
        // plan extend
        if ($subscription && $request->status == 'approved') {
            $newEndDate = Carbon::parse($subscription->end_date)
                ->addDays($totalDays);

            $subscription->update([
                'end_date' => $newEndDate,
            ]);
        }

        return to_route('customers.show',['customer' => $request->customer_id, 'tab' => 'leaves'])
            ->with('success', 'Leave added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Leave $leave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leave $leave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leave $leave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leave $leave)
    {
        //
    }
}
