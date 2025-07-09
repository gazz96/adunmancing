<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'variation',
        'product_attributes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getAttributeLabelsAttribute()
    {
        if($this->product_attributes)
        {
            $product_attributes = collect(json_decode($this->product_attributes));
            return $product_attributes->values()->join(',');
        }

        return '';
    }

}
