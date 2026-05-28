<?php

namespace App\Http\Controllers;

use App\Models\PaymentMode;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $records = Subscription::with([
                'customer:id,name,mobile,profile_pic',
                'plan:id,name,total_days,meal_time',
                'payments:id,amount,date,subscription_id',
            ])
            ->withSum('payments', 'amount')
            ->when($request->customer !== null, function ($q) use ($request) {
                $q->whereRelation('customer', 'name', 'like', '%' . $request->customer . '%')
                    ->orWhereRelation('customer', 'mobile', 'like', '%' . $request->customer . '%');
            })
            ->when($request->plan_id !== null, function ($q) use ($request) {
                $q->where('plan_id', $request->plan_id);
            })
            ->when($request->paymwnt_status !== null, function ($q) use ($request) {
                $request->paymwnt_status === 'due'
                    ? $q->where('paymwnt_status', '!=', 'paid')
                    : $q->where('paymwnt_status', $request->paymwnt_status);

            })
            ->when($request->is_active !== null, function ($q) use ($request) {
                $q->where('is_active', $request->is_active);
            })
            ->latest()
            ->paginate(getSetting('page_limit'));
        $plans = Plan::where('is_active', 1)->pluck('name','id');
        $paymentModes = PaymentMode::where('is_active', 1)->pluck('name','id');
        return view('panel.subscriptions.index', compact('records', 'paymentModes','plans'));
    }
}
