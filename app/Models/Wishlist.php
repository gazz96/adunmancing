<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Check if product is in user's wishlist
     */
    public static function isInWishlist($userId, $productId)
    {
        return self::where('user_id', $userId)
                   ->where('product_id', $productId)
                   ->exists();
    }

    /**
     * Toggle product in wishlist
     */
    public static function toggle($userId, $productId)
    {
        $wishlistItem = self::where('user_id', $userId)
                           ->where('product_id', $productId)
                           ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            return ['action' => 'removed', 'message' => 'Produk dihapus dari wishlist'];
        } else {
            self::create([
                'user_id' => $userId,
                'product_id' => $productId
            ]);
            return ['action' => 'added', 'message' => 'Produk ditambahkan ke wishlist'];
        }
    }
}