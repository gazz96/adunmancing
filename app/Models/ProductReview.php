<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 
        'user_id', 
        'rating', 
        'review',
        'is_verified_purchase',
        'is_approved',
        'admin_reply'
    ];

    protected $casts = [
        'is_verified_purchase' => 'boolean',
        'is_approved' => 'boolean',
        'rating' => 'integer'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified_purchase', true);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at->format('d M Y');
    }

    // Check if user has purchased this product
    public static function hasUserPurchasedProduct($userId, $productId)
    {
        return \App\Models\OrderItem::whereHas('order', function($query) use ($userId) {
            $query->where('user_id', $userId)
                  ->whereIn('status', ['completed', 'processing']); // Only completed or processing orders
        })->where('product_id', $productId)->exists();
    }

    // Check if user already reviewed this product
    public static function hasUserReviewedProduct($userId, $productId)
    {
        return self::where('user_id', $userId)
                   ->where('product_id', $productId)
                   ->exists();
    }

    // Get average rating for a product
    public static function getAverageRating($productId)
    {
        return self::where('product_id', $productId)->avg('rating') ?: 0;
    }

    // Get rating distribution for a product
    public static function getRatingDistribution($productId)
    {
        return self::where('product_id', $productId)
                   ->selectRaw('rating, COUNT(*) as count')
                   ->groupBy('rating')
                   ->pluck('count', 'rating')
                   ->toArray();
    }
}
