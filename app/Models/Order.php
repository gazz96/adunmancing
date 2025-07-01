<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'order_number', 'status', 'total_amount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function coupons()
    {
        return $this->hasMany(OrderCoupon::class);
    }

    public function shipping()
    {
        return $this->hasOne(OrderShipping::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
