<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'price', 'status', 'is_featured', 'compare_price', 'sku', 
        'featured_image', 'weight', 'dimension', 'manage_stock', 'stock_quantity', 
        'allow_backorders', 'low_stock_threshold', 'warranty_information', 'delivery_shipping', 'views'
    ];

    protected $casts = [
        'manage_stock' => 'boolean',
        'allow_backorders' => 'boolean',
        'is_featured' => 'boolean',
    ];

    protected $appends = [
        'featured_image_url'
    ];

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_attributes')
                    ->withPivot('attribute_values')
                    ->withTimestamps();
    }

    public function productAttributes()
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
        if (!$this->featured_image) {
            return null;
        }
        
        // Check if it's an external URL (starts with http:// or https://)
        if (filter_var($this->featured_image, FILTER_VALIDATE_URL)) {
            return $this->featured_image;
        }
        
        // Otherwise, it's a local file
        return asset('storage/' . $this->featured_image);
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

    // Stock Management Methods
    public function isInStock()
    {
        if (!$this->manage_stock) {
            return true; // If stock management is disabled, always in stock
        }

        return $this->stock_quantity > 0 || $this->allow_backorders;
    }

    public function getStockStatus()
    {
        if (!$this->manage_stock) {
            return 'in_stock';
        }

        if ($this->stock_quantity <= 0) {
            return $this->allow_backorders ? 'on_backorder' : 'out_of_stock';
        }

        if ($this->low_stock_threshold && $this->stock_quantity <= $this->low_stock_threshold) {
            return 'low_stock';
        }

        return 'in_stock';
    }

    public function getStockStatusLabelAttribute()
    {
        $status = $this->getStockStatus();
        
        return match($status) {
            'in_stock' => 'Tersedia',
            'low_stock' => 'Stok Terbatas',
            'on_backorder' => 'Pre-order',
            'out_of_stock' => 'Habis',
            default => 'Tersedia'
        };
    }

    public function canPurchase($quantity = 1)
    {
        if (!$this->manage_stock) {
            return true;
        }

        if ($this->stock_quantity >= $quantity) {
            return true;
        }

        return $this->allow_backorders;
    }

    public function reduceStock($quantity)
    {
        if (!$this->manage_stock) {
            return true;
        }

        if ($this->stock_quantity >= $quantity) {
            $this->decrement('stock_quantity', $quantity);
            return true;
        }

        if ($this->allow_backorders) {
            $this->decrement('stock_quantity', $quantity);
            return true;
        }

        return false;
    }

    public function restoreStock($quantity)
    {
        if (!$this->manage_stock) {
            return true;
        }

        $this->increment('stock_quantity', $quantity);
        return true;
    }

    // Scopes for popular and most viewed products
    public function scopePopular($query)
    {
        return $query->orderBy('views', 'desc');
    }

    public function scopeMostViewed($query, $limit = 10)
    {
        return $query->popular()->limit($limit);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Get product variations based on attributes
    public function getVariationsAttribute()
    {
        $variations = [];
        $productAttributes = $this->productAttributes()->with(['attribute.values'])->get();
        
        foreach ($productAttributes as $productAttribute) {
            $attribute = $productAttribute->attribute;
            $selectedValueIds = $productAttribute->attribute_values ?? [];
            
            $selectedValues = $attribute->values()
                ->whereIn('id', $selectedValueIds)
                ->active()
                ->ordered()
                ->get();
            
            if ($selectedValues->isNotEmpty()) {
                $variations[$attribute->slug] = [
                    'attribute' => $attribute,
                    'selected_values' => $selectedValues
                ];
            }
        }
        
        return $variations;
    }

    public function hasVariations()
    {
        return $this->productAttributes()->count() > 0;
    }
}
