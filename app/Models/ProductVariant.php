<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'sku', 'price', 'status'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function options()
    {
        return $this->hasMany(VariantOption::class);
    }

    public function images()
    {
        return $this->hasMany(ProductVariantImage::class);
    }

    protected static function booted()
    {
        static::creating(function ($variant) {
            // Don't overwrite if SKU already set
            if (!empty($variant->sku)) return;

            $base = strtoupper(\Str::slug(optional($variant->product)->name ?? 'SKU'));

            // Attempt to read loaded options relationship (only works if eager loaded)
            $optionPart = '';
            if ($variant->relationLoaded('options')) {
                $optionPart = $variant->options
                    ->pluck('value')
                    ->map(fn($val) => strtoupper(\Str::slug($val)))
                    ->implode('-');
            }

            $sku = $base . ($optionPart ? '-' . $optionPart : '');

            // Ensure uniqueness
            $originalSku = $sku;
            $suffix = 1;
            while (self::where('sku', $sku)->exists()) {
                $sku = $originalSku . '-' . $suffix++;
            }

            $variant->sku = $sku;
        });
    } 
}
