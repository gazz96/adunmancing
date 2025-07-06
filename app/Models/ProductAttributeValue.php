<?php 

namespace App\Models;

class ProductAttributeValue extends \Illuminate\Database\Eloquent\Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'product_attribute_id',
        'value',
    ];

    public function productAttribute()
    {
        return $this->belongsTo(ProductAttribute::class);
    }
}