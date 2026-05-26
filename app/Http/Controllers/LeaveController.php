<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;

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
        //
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
