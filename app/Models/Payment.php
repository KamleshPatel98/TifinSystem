<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Payment extends Model
{
    protected $fillable = ['subscription_id', 'payment_mode_id', 'vendor_id', 'customer_id', 'amount', 'date'];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }

    public function paymentMode()
    {
        return $this->belongsTo(PaymentMode::class, 'payment_mode_id');
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    protected static function booted(){
        static::addGlobalScope('accessible', function ($query) {
            if (!Auth::check()) {
                return;
            }

            if (Auth::user()->role !== 'superadmin') {
                $query->where('vendor_id', Auth::user()->vendor->id);
            }
        });
    }
}
