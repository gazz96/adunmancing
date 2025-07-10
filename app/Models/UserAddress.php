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
        'receipt_name',
        'phone_number',
        'province_id',
        'regency_id',
        'city_id',
        'district_id',
        'postal_code',
        'address',
        'is_default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
