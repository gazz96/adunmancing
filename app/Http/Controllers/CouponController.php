<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CouponController extends Controller
{
    /**
     * Validate a coupon code
     */
    public function validateCoupon(Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'required|string',
            'total' => 'required|numeric|min:0'
        ]);

        $coupon = Coupon::where('code', strtoupper($request->code))
                        ->active()
                        ->valid()
                        ->available()
                        ->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Kode kupon tidak valid atau sudah tidak berlaku.',
            ], 404);
        }

        if (!$coupon->canBeUsed($request->total)) {
            $minAmount = number_format($coupon->minimum_amount, 0, ',', '.');
            return response()->json([
                'success' => false,
                'message' => "Kupon ini memerlukan minimal belanja Rp {$minAmount}.",
            ], 400);
        }

        $discount = $coupon->calculateDiscount($request->total);
        $newTotal = $request->total - $discount;

        return response()->json([
            'success' => true,
            'message' => 'Kupon berhasil diterapkan!',
            'coupon' => [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'name' => $coupon->name,
                'description' => $coupon->description,
                'discount_type' => $coupon->discount_type,
                'discount_amount' => $coupon->discount_amount,
                'discount_percent' => $coupon->discount_percent,
                'minimum_amount' => $coupon->minimum_amount,
            ],
            'discount' => $discount,
            'discount_formatted' => 'Rp ' . number_format($discount, 0, ',', '.'),
            'original_total' => $request->total,
            'new_total' => $newTotal,
            'new_total_formatted' => 'Rp ' . number_format($newTotal, 0, ',', '.'),
        ]);
    }

    /**
     * Get available coupons for user
     */
    public function getAvailable(): JsonResponse
    {
        $coupons = Coupon::active()
                        ->valid()
                        ->available()
                        ->select(['id', 'code', 'name', 'description', 'discount_type', 'discount_amount', 'discount_percent', 'minimum_amount'])
                        ->get()
                        ->map(function ($coupon) {
                            return [
                                'id' => $coupon->id,
                                'code' => $coupon->code,
                                'name' => $coupon->name,
                                'description' => $coupon->description,
                                'discount_display' => $coupon->discount_display,
                                'minimum_amount' => $coupon->minimum_amount,
                                'minimum_amount_formatted' => $coupon->minimum_amount ? 'Rp ' . number_format($coupon->minimum_amount, 0, ',', '.') : null,
                            ];
                        });

        return response()->json([
            'success' => true,
            'coupons' => $coupons
        ]);
    }

    /**
     * Apply coupon to session cart
     */
    public function apply(Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'required|string',
            'total' => 'required|numeric|min:0'
        ]);

        $coupon = Coupon::where('code', strtoupper($request->code))
                        ->active()
                        ->valid()
                        ->available()
                        ->first();

        if (!$coupon || !$coupon->canBeUsed($request->total)) {
            return response()->json([
                'success' => false,
                'message' => 'Kupon tidak dapat diterapkan.',
            ], 400);
        }

        // Store coupon in session
        session([
            'applied_coupon' => [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'name' => $coupon->name,
                'discount' => $coupon->calculateDiscount($request->total),
            ]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kupon berhasil diterapkan!',
            'coupon' => session('applied_coupon')
        ]);
    }

    /**
     * Remove coupon from session
     */
    public function remove(): JsonResponse
    {
        session()->forget('applied_coupon');

        return response()->json([
            'success' => true,
            'message' => 'Kupon berhasil dihapus.'
        ]);
    }
}