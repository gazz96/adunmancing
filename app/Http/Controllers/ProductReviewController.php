<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000'
        ], [
            'rating.required' => 'Rating harus dipilih',
            'rating.min' => 'Rating minimal 1 bintang',
            'rating.max' => 'Rating maksimal 5 bintang',
            'review.required' => 'Review harus diisi',
            'review.max' => 'Review maksimal 1000 karakter'
        ]);

        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'error' => 'Anda harus login untuk memberikan review'
            ], 401);
        }

        $userId = Auth::id();
        $productId = $request->product_id;

        // Check if user has already reviewed this product
        if (ProductReview::hasUserReviewedProduct($userId, $productId)) {
            return response()->json([
                'error' => 'Anda sudah memberikan review untuk produk ini'
            ], 422);
        }

        // Check if user has purchased this product
        $hasPurchased = ProductReview::hasUserPurchasedProduct($userId, $productId);

        // Create review
        $review = ProductReview::create([
            'product_id' => $productId,
            'user_id' => $userId,
            'rating' => $request->rating,
            'review' => $request->review,
            'is_verified_purchase' => $hasPurchased,
            'is_approved' => true // Auto approve for now
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review berhasil ditambahkan!',
            'review' => $review->load('user')
        ]);
    }

    public function canUserReview(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['can_review' => false, 'reason' => 'not_logged_in']);
        }

        $userId = Auth::id();
        $productId = $request->product_id;

        // Check if already reviewed
        if (ProductReview::hasUserReviewedProduct($userId, $productId)) {
            return response()->json(['can_review' => false, 'reason' => 'already_reviewed']);
        }

        // Check if purchased
        $hasPurchased = ProductReview::hasUserPurchasedProduct($userId, $productId);

        return response()->json([
            'can_review' => true,
            'has_purchased' => $hasPurchased
        ]);
    }
}
