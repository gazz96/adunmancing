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
        if (!$this->product_attributes) {
            return '';
        }

        try {
            $attributes = json_decode($this->product_attributes, true);
            if (!$attributes || !is_array($attributes)) {
                return '';
            }

            $labels = [];
            foreach ($attributes as $attributeId => $valueId) {
                $attribute = \App\Models\Attribute::find($attributeId);
                $value = \App\Models\AttributeValue::find($valueId);
                
                if ($attribute && $value) {
                    $labels[] = $attribute->name . ': ' . $value->display_value;
                }
            }

            return implode(', ', $labels);
        } catch (\Exception $e) {
            return '';
        }
    }

}
