<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $records = City::with('state:id,name')
            ->when(!empty($request->name), function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            })
            ->when(!empty($request->state_id), function ($q) use ($request) {
                $q->where('state_id', $request->state_id);
            })
            ->when($request->is_active !== null, function ($q) use ($request) {
                $q->where('is_active', $request->is_active);
            })
            ->paginate(getSetting('page_limit'));

        return view('panel.geography.cities.index', compact('records'));
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
            'name' => 'required|string|max:255|unique:cities,name',
            'state_id' => 'required|exists:states,id',
            'is_active' => 'required|boolean',
        ]);

        $exist = City::where('name', $validated['name'])->where('state_id', $validated['state_id'])->first();
        if ($exist) {
            return back()->with('error', 'City already exists.');
        }

        City::create($validated);
        return back()->with('success', 'City created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cities,name,' . $city->id,
            'state_id' => 'required|exists:states,id',
            'is_active' => 'required|boolean',
        ]);

        $exist = City::where('name', $validated['name'])->where('state_id', $validated['state_id'])->where('id', '!=', $city->id)->first();
        if ($exist) {
            return back()->with('error', 'City already exists.');
        }

        $city->update($validated);
        return back()->with('success', 'City updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        //
    }
}
