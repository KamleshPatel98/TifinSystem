<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Vendor extends Model
{
    protected $fillable = [
        'user_id',
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
        'resignation_request_status',
        'resgination_request_reason',
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

    public function getAadharFrontUrlAttribute()
    {
        return (!empty($this->owner_aadhar_card_front_photo) && Storage::exists('vendors/' . $this->owner_aadhar_card_front_photo))
            ? asset('storage/vendors/' . $this->owner_aadhar_card_front_photo)
            : null;
    }

    public function getAadharBackUrlAttribute()
    {
        return (!empty($this->owner_aadhar_card_back_photo) && Storage::exists('vendors/' . $this->owner_aadhar_card_back_photo))
            ? asset('storage/vendors/' . $this->owner_aadhar_card_back_photo)
            : null;
    }

    public function getPanCardUrlAttribute()
    {
        return (!empty($this->owner_pan_card_photo) && Storage::exists('vendors/' . $this->owner_pan_card_photo))
            ? asset('storage/vendors/' . $this->owner_pan_card_photo)
            : null;
    }

    public function getLogoUrlAttribute()
    {
        return (!empty($this->logo) && Storage::exists('vendors/' . $this->logo))
            ? asset('storage/vendors/' . $this->logo)
            : null;
    }
}
