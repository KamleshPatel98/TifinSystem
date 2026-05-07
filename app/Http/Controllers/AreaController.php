<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\State;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $states = State::orderBy('name', 'ASC')->get();

        $records = Area::when($request->has('state_id'), function ($q) use ($request) {
            $q->where('state_id', $request->state_id);
        })
            ->when($request->has('city_id'), function ($q) use ($request) {
                $q->where('city_id', $request->city_id);
            })
            ->when($request->has('search'), function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })
            ->when($request->is_active !== null, function ($q) use ($request) {
                $q->where('is_active', $request->is_active);
            })
            ->latest()
            ->paginate(getSetting('page_limit'));
        return view('panel.geography.areas.index', compact('records', 'states'));
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
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255',
            'pin_code' => 'required|string|max:6',
            'is_active' => 'required|boolean',
        ]);

        $exist = Area::where('city_id', $request->city_id)->where('name', $request->name)->first();
        if ($exist) {
            return back()->with('error', 'Area already exists.');
        }

        Area::create($validated);
        return back()->with('success', 'Area created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Area $area)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Area $area)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Area $area)
    {
        $validated = $request->validate([
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $exist = Area::where('city_id', $request->city_id)->where('name', $request->name)->where('id', '!=', $area->id)->first();
        if ($exist) {
            return back()->with('error', 'Area already exists.');
        }

        $area->update($validated);
        return back()->with('success', 'Area updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Area $area)
    {
        //
    }
}
