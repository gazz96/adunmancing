<?php 

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $carts = [];

        if (Auth::check()) {
            $carts = CartItem::with('product')
                ->where('user_id', Auth::id())
                ->get();
        } else {
            $sessionCart = Session::get('cart', []); 
            foreach ($sessionCart as $key => $item) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    $carts[] = (object)[
                        'key' => $key,
                        'id' => $item['product_id'],
                        'product' => $product,
                        'variation' => $item['variation'],
                        'quantity' => $item['quantity'],
                        'product_attributes' => $item['product_attributes'],
                        'attribute_labels' => $item['atribute_labels'] ?? ''
                    ];
                }
            }
        }

        return view('frontend.cart.list', compact('carts'));
    }

    public function add(Request $request)
    {


        $validated = $request->validate([
            'product_id' => 'required',
            'attributes' => 'sometimes',
            'variation' => 'sometimes',
            'qty' => 'sometimes'
        ]);

        $productId = $request->input('product_id');
        $variation = $request->input('variation');
        $quantity = $request->input('quantity', 1);
        $attributes = $validated['attributes'] ?? '';

        if (Auth::check()) {
            // Logged-in user: check if same item+variation already exists
            $existing = CartItem::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->when($attributes, function($query, $attributes){
                    return $query ->where('product_attributes', json_encode($attributes)); // Compare JSON string
                })
                ->first();

            //dd(json_encode($attributes));

            if ($existing) {
                // Update quantity
                $existing->quantity += $quantity;
                $existing->save();
            } else {

                $data = [
                    'user_id' => Auth::id(),
                    'product_id' => $productId,
                    'variation' => $variation,
                    'quantity' => $quantity,
                ];

                if($attributes) {
                    $data['product_attributes'] = json_encode($attributes);
                }

                // Create new cart item
                CartItem::create($data);
            }
        } else {
            // Guest user: use session
            $cart = Session::get('cart', []);
            $key = $productId . '-' . md5(json_encode($variation)); // Unique key

            if (isset($cart[$key])) {
                $cart[$key]['quantity'] += $quantity;
            } else {
                $cart[$key] = [
                    'id' => $productId,
                    'product_id' => $productId,
                    'variation' => $variation,
                    'quantity' => $quantity,
                    'product_attributes' => $attributes ?? []
                ];
            }

            Session::put('cart', $cart);
        }

        return response()->json(['status' => 'success']);
    }

    public function update(Request $request)
    {
        $key = $request->input('key');
        $quantity = (int) $request->input('quantity');

        if (Auth::check()) {
            $item = CartItem::find($key); // key = cart item ID
            if ($item && $item->user_id == Auth::id()) {
                if ($quantity > 0) {
                    $item->quantity = $quantity;
                    $item->save();
                } else {
                    $item->delete();
                }
            }
        } else {
            $cart = Session::get('cart', []);
            if (isset($cart[$key])) {
                if ($quantity > 0) {
                    $cart[$key]['quantity'] = $quantity;
                } else {
                    unset($cart[$key]);
                }
            }
            Session::put('cart', $cart);
        }

        return response()->json(['status' => 'updated']);
    }

    public function remove(Request $request)
    {
        $key = $request->input('key');
        dd($key);
        if (Auth::check()) {
            $item = CartItem::find($key); // ID
            if ($item && $item->user_id == Auth::id()) {
                $item->delete();
            }
        } else {
            $cart = Session::get('cart', []);
            unset($cart[$key]);
            
            Session::put('cart', $cart);
        }

        return response()->json(['status' => 'removed']);
    }
}
