<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class WebController extends Controller
{
    //

    public function index()
    {
        return view('frontend.index', [
            'productCategories' => \App\Models\Category::orderBy('name')
                ->limit(6)
                ->get(),

            'sliders' => \App\Models\Product::orderBy('created_at', 'desc')
                ->limit(3)
                ->whereStatus(1)
                ->get(),
        ]);
    }

    public function shop(Request $request)
    {
        return view('frontend.shop', [
            'productCategories' => \App\Models\Category::orderBy('name')
                ->get(),
            'products' => \App\Models\Product::orderBy('created_at', 'desc')
                ->when($request->category_id, function ($query, $category_id) {
                    return $query->whereHas('categories', function ($query) use ($category_id) {
                        if (is_array($category_id)) {
                            return $query->whereIn('categories.id', $category_id);
                        }

                        return $query->where('categories.id', $category_id);
                    });
                })
                ->whereStatus(1)
                ->paginate(20)
                ->appends($request->except('page')),
        ]);
    }

    public function productDetail($slug = null)
    {
        $product = \App\Models\Product::whereSlug($slug)
            ->whereStatus(1)
            ->firstOrFail();

        //update views count
        $product->views = $product->views + 1;
        $product->save();

        return view('frontend.product-detail', [
            'product' => $product,
            // 'relatedProducts' => $product->categories->first()
            //     ? $product->categories->first()->products()
            //         ->where('id', '!=', $product->id)
            //         ->whereStatus(1)
            //         ->orderBy('created_at', 'desc')
            //         ->limit(6)
            //         ->get()
            //     : [],
        ]);
    }

    public function addToCart(Request $request)
    {
        $product = \App\Models\Product::findOrFail($request->input('product_id'));

        if ($product->status != 1) {
            return redirect()->back()->withErrors(['Product is not available']);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'image' => $product->featured_image,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function checkout()
    {
        return view('frontend.checkout', [
            'addresses' => UserAddress::where('user_id', Auth::id())->get()
        ]);
    }

    public function doCheckout(Request $request)
    {
        $request->validate([
            'note' => 'sometimes'
        ]);

        DB::beginTransaction();

        try {
            $userId = Auth::id();
            $cartItems = Auth::check()
                ? $this->getCartFromDB($userId)
                : $this->getCartFromSession();


            if (count($cartItems) === 0) {
                return back()->with('error', 'Cart is empty.');
            }

            $total = 0;

            // Hitung total
            foreach ($cartItems as $item) {
                $product = Product::find($item['product_id']);
                if (!$product) continue;

                $total += $product->price * $item['quantity'];
            }

            $address = UserAddress::where('user_id', Auth::id())
                ->where('is_default', 1)
                ->first();

            // Simpan order
            $order = Order::create([
                'user_id' => $userId,
                'address' => $address->address,
                'total_amount' => $total,
                'status' => 'pending',
                'note' => $request->note
            ]);


            // Simpan detail order
            foreach ($cartItems as $item) {
                $product = Product::find($item['product_id']);
                if (!$product) continue;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_attributes' => $item['product_attributes'],
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $product->price * $item['quantity'],
                ]);
            }

            // Bersihkan cart
            if (Auth::check()) {
                DB::table('cart_items')->where('user_id', $userId)->delete();
            } else {
                Session::forget('cart');
            }

            DB::commit();

            return redirect()->route('web.my-account', $order->id)
                ->with('success', 'Checkout berhasil!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            return back()->with('error', 'Checkout gagal: ' . $e->getMessage());
        }
    }

    private function getCartFromSession()
    {
        $cart = session('cart', []);
        return array_map(function ($item) {
            return [
                'product_id' => $item['product_id'],
                'variation' => $item['variation'],
                'quantity' => $item['quantity'],
                'product_attributes' => $item['product_attributes'] ?? null
            ];
        }, $cart);
    }

    private function getCartFromDB($userId)
    {
        return DB::table('cart_items')
            ->where('user_id', $userId)
            ->get()
            ->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'variation' => json_decode($item->variation, true),
                    'quantity' => $item->quantity,
                    'product_attributes' => $item->product_attributes
                ];
            })->toArray();
    }

    public function thankyou()
    {
        return view('frontend.thankyou');
    }

    public function myAccount()
    {
        return view('frontend.my-account.index', [
            'user' => auth()->user(),
            'orders' => Order::where('user_id', Auth::id())
                ->get()
        ]);
    }

    public function accountAddresses()
    {
        return view('frontend.my-account.addresses',[
            'addresses' => UserAddress::where('user_id', Auth::id())->get()
        ]);
    }

    public function myPersonalInfo()
    {
        return view('frontend.my-account.personal-info');
    }

    public function myAccountReviews() {
        echo 'testing';
    }
}
