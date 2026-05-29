<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'is_active',
    ];

    public function vendor()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentMode()
    {
        return $this->belongsTo(PaymentMode::class);
    }
}
