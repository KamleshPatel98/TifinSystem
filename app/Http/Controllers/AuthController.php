<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return to_route('auth.dashboard')->with('success', 'You are already logged in.');
        }
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
            return to_route('auth.dashboard')->with('success', 'Login successfully.');
        }
    }

    public function dashboard()
    {
        $customers = User::where('role', 'customer')->count();
        $plans = Plan::count();
        $activeSubscriptions = Subscription::where('is_active', true)->count();
        $revenue = Payment::sum('amount');

        $statics = [
            'customers' => $customers,
            'plans' => $plans,
            'activeSubscriptions' => $activeSubscriptions,
            'revenue' => $revenue,
        ];

        return view('panel.dashboard', compact('statics'));
    }

    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect()->route('login')->with('success', 'Logout successfully.');
    }
}
