<?php

namespace App\Http\Controllers;

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
        $cities = City::where('state_id', $request->state_id)->where('is_active', 1)->orderBy('name', 'ASC')->pluck('name', 'id');
        return view('dropdowns.city', compact('cities'));
    }
}
