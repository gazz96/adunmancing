<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'price', 'status', 'compare_price', 'sku', 'status', 'featured_image', 'weight', 'dimension'];

    protected $appends = [
        'featured_image_url'
    ];

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function getPriceLabelAttribute()
    {
        return number_format($this->price, 0, '.', ',');
    }

    public function getComparePriceLabelAttribute()
    {
        return $this->compare_price ? number_format($this->compare_price, 0, '.', ',') : null;
    }

    public function getFeaturedImageUrlAttribute()
    {
        return $this->featured_image ? asset('storage/' . $this->featured_image) : null;
    }

    public function getPercentageDiscountByComparePriceAttribute()
    {
        if ($this->compare_price && $this->compare_price > $this->price) {
            return round((($this->compare_price - $this->price) / $this->compare_price) * 100);
        }
        return 0;
    }

    public function getPermalinkAttribute()
    {
        return route('frontend.product-detail', $this->slug);
    }
}
