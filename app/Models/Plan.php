<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'vendor_id',
        'name',
        'duration',
        'price',
        'total_days',
        'meal_time',
        'description',
        'is_active',
    ];

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
}
