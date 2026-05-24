<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'mobile',
        'alt_mobile',
        'email',
        'password',
        'role',
        'status',
        'gender',
        'dob',
        'profile_pic',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getProfileUrlAttribute()
    {
        return (!empty($this->profile_pic) && Storage::exists('vendors/' . $this->profile_pic))
            ? asset('storage/vendors/' . $this->profile_pic)
            : null;
    }

     public function getCustomerProfileUrlAttribute()
    {
        return (!empty($this->profile_pic) && Storage::exists('customers/' . $this->profile_pic))
            ? asset('storage/customers/' . $this->profile_pic)
            : null;
    }


    public function getDobAttribute($value)
    {
        return formatDateTodmY($value);
    }

    public function vendor()
    {
        return $this->hasOne(Vendor::class  , 'user_id');
    }

    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class  , 'user_id');
    }
}
