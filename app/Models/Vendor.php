<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'owner_aadhar_card_front_photo',
        'owner_aadhar_card_back_photo',
        'owner_pan_card_photo',
        'bussiness_name',
        'logo',
        'phone_number',
        'state_id',
        'city_id',
        'area_id',
        'pincode',
        'address',
        'latitude',
        'longitude',
        'approved_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
