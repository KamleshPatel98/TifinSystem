<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $records = State::when(!empty($request->name), function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->name . '%');
        })
            ->when(!empty($request->code), function ($q) use ($request) {
                $q->where('code', $request->code);
            })
            ->when($request->is_active !== null, function ($q) use ($request) {
                $q->where('is_active', $request->is_active);
            })
            ->paginate(getSetting('page_limit'));
        return view('panel.geography.states.index', compact('records'));
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
            'name' => 'required|string|max:255|unique:states,name',
            'code' => 'required|string|max:255|unique:states,code',
            'is_active' => 'required|boolean',
        ]);
        State::create($request->all());
        return back()->with('success', 'State created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(State $state)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(State $state)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, State $state)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:states,name,' . $state->id,
            'code' => 'required|string|max:255|unique:states,code,' . $state->id,
            'is_active' => 'required|boolean',
        ]);
        $state->update($request->all());
        return back()->with('success', 'State updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(State $state)
    {
        //
    }
}
