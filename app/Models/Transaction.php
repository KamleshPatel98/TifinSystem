<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    protected $fillable = [
        'vendor_id',
        'type',
        'description',
        'amount',
        'date',
        'payment_mode_id',
        'reference_no',
    ];

    public function getDateattribute($value)
    {
        return formatDateTodmY($value);
    }

    public function vendor()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentMode()
    {
        return $this->belongsTo(PaymentMode::class);
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
