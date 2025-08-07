<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'error' => 'Anda harus login untuk menambah ke wishlist',
                'redirect' => route('login')
            ], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $result = Wishlist::toggle(Auth::id(), $request->product_id);

        return response()->json([
            'success' => true,
            'action' => $result['action'],
            'message' => $result['message'],
            'is_wishlist' => $result['action'] === 'added'
        ]);
    }

    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $wishlists = Wishlist::where('user_id', Auth::id())
                           ->with('product')
                           ->orderBy('created_at', 'desc')
                           ->paginate(12);

        return view('frontend.wishlist.index', compact('wishlists'));
    }

    public function remove(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        Wishlist::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk dihapus dari wishlist'
        ]);
    }
}