<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'recipient_name',
        'phone_number',
        'province_id',
        'province_name',
        'regency_id',
        'city_id',
        'city_name',
        'district_id',
        'postal_code',
        'address',
        'is_default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class, 'city_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
