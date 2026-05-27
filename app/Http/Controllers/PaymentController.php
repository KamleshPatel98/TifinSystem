<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentMode;
use App\Models\Plan;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $records = Payment::with([
                'customer:id,name,mobile,profile_pic',
                'paymentMode:id,name',
                'subscription:id,start_date,end_date,paymwnt_status,offer_price,plan_id',
                'subscription.plan:id,name'
            ])
            ->when($request->customer !== null, function ($q) use ($request) {
                $q->whereRelation('customer', 'name', 'like', '%' . $request->customer . '%')
                    ->orWhereRelation('customer', 'mobile', 'like', '%' . $request->customer . '%');
            })
            ->when($request->plan_id !== null, function ($q) use ($request) {
                $q->whereRelation('subscription', 'plan_id', $request->plan_id);
            })
            ->latest()
            ->paginate(getSetting('page_limit'));
        $totalAmount = Payment::sum('amount');
        $plans = Plan::where('is_active', 1)->pluck('name','id');
        $paymentModes = PaymentMode::where('is_active', 1)->pluck('name','id');
        return view('panel.payments.index', compact('records', 'paymentModes','plans','totalAmount'));
    }
}
