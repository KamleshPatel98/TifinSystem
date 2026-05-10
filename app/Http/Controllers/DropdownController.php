<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;

class DropdownController extends Controller
{
   public function state(Request $request)
    {
        $states = State::where('is_active', 1)->orderBy('name', 'ASC')->pluck('name', 'id');
        return view('dropdowns.state', compact('states'));
    }

    public function city(Request $request)
    {
        $cities = City::when($request->state_id !== null, function ($q) use ($request) {
                $q->where('state_id', $request->state_id);
            })
            ->where('is_active', 1)
            ->orderBy('name', 'ASC')
            ->pluck('name', 'id');
        return view('dropdowns.city', compact('cities'));
    }

    public function area(Request $request)
    {
        $areas = Area::when($request->city_id !== null, function ($q) use ($request) {
                $q->where('city_id', $request->city_id);
            })
            ->where('is_active', 1)
            ->orderBy('name', 'ASC')
            ->pluck('name', 'id');
        return view('dropdowns.area', compact('areas'));
    }
}
