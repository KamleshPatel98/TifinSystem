<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

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
        $activeCustomerIds = Subscription::where('is_active', true)->pluck('customer_id');
        $todayLeaves = Leave::where('status', 'approved')
            ->whereIn('customer_id', $activeCustomerIds)
            ->whereDate('start_date', '>=', date('Y-m-d'))
            ->whereDate('end_date', '<=', date('Y-m-d'))
            ->count();
        $todayFoodRequirement = $activeSubscriptions - $todayLeaves;
        $offerPrice = Subscription::sum('offer_price');
        $revenue = Payment::sum('amount');
        $dueAmout = $offerPrice - $revenue;
        $pendingLeaves = Leave::where('status', 'pending')->count();

        $statics = [
            'customers' => $customers,
            'plans' => $plans,
            'activeSubscriptions' => $activeSubscriptions,
            'todayLeaves' => $todayLeaves,
            'todayFoodRequirement' => $todayFoodRequirement,
            'revenue' => $revenue,
            'dueAmout' => $dueAmout,
            'todayLeaves' => $todayLeaves,
            'pendingLeaves' => $pendingLeaves,
        ];

        $latestSubscriptionIds = Subscription::selectRaw('MAX(id) as id')
            ->groupBy('customer_id')
            ->pluck('id');

        $subscriptionsExpiringSoon = Subscription::with(['customer', 'plan'])
            ->whereIn('id', $latestSubscriptionIds)
            ->whereDate('end_date', '>=', now())
            ->whereDate('end_date', '<=', now()->addDays(7))
            ->get();

        $expiredSubscriptions = Subscription::with(['customer', 'plan'])
            ->whereIn('id', $latestSubscriptionIds)
            ->whereDate('end_date', '<', now())
            ->get();

        return view('panel.dashboard', compact('statics','subscriptionsExpiringSoon','expiredSubscriptions'));
    }

    public function changePassword()
    {
        return view('panel.auth.change-password');
    }

    public function changePasswordSubmit(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => [
                'required',
                'confirmed',
                Password::min(10)
                    ->letters()
                    ->numbers()
                    ->symbols(),
            ],
        ]);

        try {
            $user = User::find(Auth::user()->id);
            if (Hash::check($request->old_password, $user->password)) {
                User::where('id', $user->id)->update([
                    'password' => Hash::make($request->password),
                ]);

                Auth::logout();
                session()->flush();
                return to_route('auth.login')->with('success', 'Password changed successfully. Please login again with your new password.');
            } else {
                return back()->with('error', 'Old password does not match');
            }
        } catch (\Exception $ex) {
            Log::error('Change Password Error!', [
                'ex' => $ex->getMessage(),
                'method' => __METHOD__,
                'line' => __LINE__
            ]);
            return back()->with('error', 'Something went wrong');
        }
    }

    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect()->route('login')->with('success', 'Logout successfully.');
    }
}
