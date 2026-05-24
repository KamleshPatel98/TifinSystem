<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = ['vendor_id', 'customer_id', 'plan_id', 'delivery_boy_id', 'customer_address_id', 'price', 'offer_price', 'start_date', 'end_date', 'paymwnt_status', 'is_active'];

    public function getStartDateAttribute($value)
    {
        return formatDateTodmY($value);
    }
    public function getEndDateAttribute($value)
    {
        return formatDateTodmY($value);
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
