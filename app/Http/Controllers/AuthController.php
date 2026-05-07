<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('panel.auth.login');
    }

    public function loginSubmit(Request $request)
    {
        $request->validate([
            'mobile' => 'required|exists:users,mobile',
            'password' => 'required',
        ]);

        $user = User::where('mobile', $request->mobile)->first();
        if ($user->status == 'inactive') {
            return back()->with('error', 'Your account is inactive. Please contact the administrator.');
        } elseif ($user->status == 'suspended') {
            return back()->with('error', 'Your account is suspended. Please contact the administrator.');
        } elseif (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Your password is incorrect. Please try again.');
        } else {
            Auth::login($user);
            return "hello";
        }
    }
}
