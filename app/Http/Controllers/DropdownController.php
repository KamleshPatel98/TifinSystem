<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

class DropdownController extends Controller
{
    public function state(Request $request)
    {
        $states = State::where('is_active', 1)->pluck('name', 'id');
        return view('dropdowns.state', compact('states'));
    }
}
