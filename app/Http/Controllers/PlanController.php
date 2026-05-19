<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $records = Plan::when($request->name !== null, function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            })
            ->when($request->is_active !== null, function ($q) use ($request) {
                $q->where('is_active', $request->is_active);
            })
            ->where('vendor_id', Auth::user()->vendor->id)
            ->paginate(getSetting('page_limit'));
        return view('panel.plans.index', compact('records'));
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
            'name' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'price' => 'required|numeric',
            'total_days' => 'required|integer',
            'meal_time' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $vendorId = Auth::user()->vendor->id;
        $exist = Plan::where('vendor_id', $vendorId)
            ->where('name', $request->name)
            ->first();
        if ($exist) {
            return back()->with('error', 'Plan already exists.');
        }

        Plan::create(array_merge(['vendor_id' => $vendorId], $request->all()));
        return back()->with('success', 'Plan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plan $plan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'price' => 'required|numeric',
            'total_days' => 'required|integer',
            'meal_time' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $vendorId = Auth::user()->vendor->id;
        $exist = Plan::where('vendor_id', $vendorId)
            ->where('name', $request->name)
            ->where('id', '!=', $plan->id)
            ->first();
        if ($exist) {
            return back()->with('error', 'Plan already exists.');
        }

        Plan::where('id',$plan->id)->where('vendor_id', $vendorId)->update($validated);
        return back()->with('success', 'Plan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        $plan->where('vendor_id', Auth::user()->vendor->id)->delete();
        return back()->with('success', 'Plan deleted successfully.');
    }
}
