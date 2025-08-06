<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'order_number', 'status', 'total_amount', 'note', 'address', 'courier', 'courier_package', 'delivery_price', 'total_weight', 'origin', 'originType', 'destination', 'destinationType', 'postal_code', 'recepient_name', 'recepient_phone_number', 'awb', 'send_date', 'payment_method', 'payment_method_id', 'payment_status', 'payment_proof', 'paid_at', 'payment_notes' ];

    protected $appends = [
        'destination_name'
    ];

    protected $casts = [
        'paid_at' => 'datetime'
    ];

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

    public function products()
    {
        return $this->hasManyThrough(Product::class, OrderItem::class, 'order_id', 'id', 'id', 'product_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function getPaymentProofUrlAttribute()
    {
        return $this->payment_proof ? asset('storage/' . $this->payment_proof) : null;
    }

    public function isPaymentPending()
    {
        return $this->payment_status === 'pending';
    }

    public function isPaymentPaid()
    {
        return $this->payment_status === 'paid';
    }

    public function markAsPaid()
    {
        $this->update([
            'payment_status' => 'paid',
            'paid_at' => now()
        ]);
    }

    public function getTotalAttribute()
    {
        return $this->total_amount + $this->delivery_price;
    }

    public function city() 
    {
        return $this->belongsTo(Regency::class, 'destination');
    }

    protected static function booted()
    {
        static::creating(function ($order) {
            $order->order_number = self::generateOrderNumber();
        });
    }

    public function getDestinationNameAttribute()
    {
        $name = Regency::find($this->destination)->name ?? '';
        return $name;
    }
    

    protected static function generateOrderNumber(): string
    {
        $prefix = 'ORD-';
        $date = now()->format('Ymd');

        // Find the last order today
        $lastOrder = self::whereDate('created_at', now()->toDateString())
            ->orderByDesc('id')
            ->first();

        $sequence = 1;

        if ($lastOrder && str_contains($lastOrder->order_number, $date)) {
            $lastSequence = (int) \Str::afterLast($lastOrder->order_number, '-');
            $sequence = $lastSequence + 1;
        }

        return $prefix . $date . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    public function getCourierPackageDataAttribute(){
        return explode('|', $this->courier_package);
    }

    public function getEstimationArrivalDateAttribubte()
    {
        if($this->courier_package) {
            $date = $this->courier_package_data[3] ?? '';
            if($date) {
                return '';
                // return date('strtotime')
            }
        }

        return '';
    }

}
