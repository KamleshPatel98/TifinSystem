<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = [
        'vendor_id',
        'user_id',
        'start_date',
        'end_date',
        'total_days',
        'status',
    ];

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
}
