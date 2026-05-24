<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
