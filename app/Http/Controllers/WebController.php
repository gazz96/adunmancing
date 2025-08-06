<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\Option;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Regency;
use App\Models\UserAddress;
use App\Services\Rajaongkir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

            'sliders' => \App\Models\Slider::active()
                ->ordered()
                ->get(),

            'youtubeVideos' => \App\Models\YouTubeVideo::active()
                ->ordered()
                ->get(),

            'newProducts' => \App\Models\Product::active()
                ->orderBy('created_at', 'DESC')
                ->take(5)
                ->get(),

            'featuredProducts' => \App\Models\Product::active()
                ->featured()
                ->orderBy('created_at', 'DESC')
                ->take(8)
                ->get(),

            'featuredProductsByCategory' => \App\Models\Category::with(['products' => function($query) {
                    $query->active()->featured()->take(4);
                }])
                ->whereHas('products', function($query) {
                    $query->active()->featured();
                })
                ->take(4)
                ->get(),

            'makanProducts' => \App\Models\Product::active()
                ->orderBy('created_at', 'DESC')
                ->whereHas('categories', function($query){
                    return $query->where('categories.id', 1);
                })
                ->take(5)
                ->get()
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

        // Get popular products (excluding current product)
        $popularProducts = Product::active()
            ->where('id', '!=', $product->id)
            ->popular()
            ->take(4)
            ->get();

        // Get recent blog posts  
        $blogPosts = Blog::whereIsPublished(1)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Get most viewed products (excluding current product)
        $viewedProducts = Product::active()
            ->where('id', '!=', $product->id)
            ->popular()
            ->take(4)
            ->get();

        return view('frontend.product-detail', [
            'product' => $product,
            'popularProducts' => $popularProducts,
            'blogPosts' => $blogPosts,
            'viewedProducts' => $viewedProducts,
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

    public function cart()
    {
        $cartItems = $this->getCartItems();
        
        return view('frontend.cart.list', [
            'carts' => $cartItems
        ]);
    }

    public function addToCart(Request $request)
    {
        try {
            // Check if user is authenticated
            if (!Auth::check()) {
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'error' => 'Anda harus login terlebih dahulu untuk menambahkan produk ke keranjang',
                        'redirect' => route('login')
                    ], 401);
                }
                return redirect()->route('login')
                    ->with('error', 'Anda harus login terlebih dahulu untuk menambahkan produk ke keranjang')
                    ->with('intended', $request->fullUrl());
            }

            $request->validate([
                'product_id' => 'required|exists:products,id'
            ]);

            $product = \App\Models\Product::findOrFail($request->input('product_id'));

            if ($product->status != 1) {
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json(['error' => 'Produk tidak tersedia'], 400);
                }
                return redirect()->back()->withErrors(['Produk tidak tersedia']);
            }

            // Add to database cart for authenticated users
            $cartItem = \App\Models\CartItem::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->first();

            if ($cartItem) {
                $cartItem->increment('quantity');
            } else {
                \App\Models\CartItem::create([
                    'user_id' => Auth::id(),
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'variation' => json_encode([]),
                    'product_attributes' => null
                ]);
            }

            // Return JSON response for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                $cartItems = $this->getCartItems();
                return response()->json([
                    'success' => true,
                    'message' => 'Product added to cart successfully!',
                    'cart_html' => view('frontend.cart.list', ['carts' => $cartItems])->render(),
                    'cart_count' => $this->getCartCount()
                ]);
            }

            return redirect()->back()->with('success', 'Product added to cart successfully!');

        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['error' => 'Failed to add product to cart'], 500);
            }
            return redirect()->back()->with('error', 'Failed to add product to cart');
        }
    }

    public function updateCart(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1'
            ]);

            $productId = $request->product_id;
            $quantity = $request->quantity;

            if (Auth::check()) {
                // Update database cart
                $cartItem = \App\Models\CartItem::where('user_id', Auth::id())
                    ->where('product_id', $productId)
                    ->first();

                if ($cartItem) {
                    $cartItem->update(['quantity' => $quantity]);
                }
            } else {
                // Update session cart
                $cart = session()->get('cart', []);
                $cartKey = $productId . '_' . json_encode([]);

                if (isset($cart[$cartKey])) {
                    $cart[$cartKey]['quantity'] = $quantity;
                    session()->put('cart', $cart);
                }
            }

            // Return updated cart list view
            $cartItems = $this->getCartItems();
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cart updated successfully!',
                    'cart_html' => view('frontend.cart.list', ['carts' => $cartItems])->render(),
                    'cart_count' => $this->getCartCount()
                ]);
            }

            return redirect()->back()->with('success', 'Cart updated successfully!');

        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['error' => 'Failed to update cart'], 500);
            }
            return redirect()->back()->with('error', 'Failed to update cart');
        }
    }

    public function removeFromCart(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id'
            ]);

            $productId = $request->product_id;

            if (Auth::check()) {
                // Remove from database cart
                \App\Models\CartItem::where('user_id', Auth::id())
                    ->where('product_id', $productId)
                    ->delete();
            } else {
                // Remove from session cart
                $cart = session()->get('cart', []);
                $cartKey = $productId . '_' . json_encode([]);

                if (isset($cart[$cartKey])) {
                    unset($cart[$cartKey]);
                    session()->put('cart', $cart);
                }
            }

            // Return updated cart list view
            $cartItems = $this->getCartItems();
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product removed from cart!',
                    'cart_html' => view('frontend.cart.list', ['carts' => $cartItems])->render(),
                    'cart_count' => $this->getCartCount()
                ]);
            }

            return redirect()->back()->with('success', 'Product removed from cart!');

        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['error' => 'Failed to remove product from cart'], 500);
            }
            return redirect()->back()->with('error', 'Failed to remove product from cart');
        }
    }

    private function getCartCount()
    {
        if (Auth::check()) {
            return \App\Models\CartItem::where('user_id', Auth::id())->sum('quantity');
        } else {
            $cart = session('cart', []);
            return array_sum(array_column($cart, 'quantity'));
        }
    }

    public function checkout()
    {
        // Get couriers from database instead of hardcoded
        $couriers = \App\Models\Courier::active()
            ->pluck('name', 'code')
            ->toArray();
            
        $provinces = Rajaongkir::new()->getProvinces();
        $paymentMethods = \App\Models\PaymentMethod::active()->ordered()->get();
        
        // Get user addresses if authenticated, empty collection if guest
        $addresses = Auth::check() 
            ? UserAddress::where('user_id', Auth::id())->get() 
            : collect([]);
            
        return view('frontend.checkout', [
            'addresses' => $addresses,
            'couriers' => $couriers,
            'provinces' => $provinces,
            'paymentMethods' => $paymentMethods,
            'carts' => $this->getCartItems()
        ]);
    }

    public function doCheckout(Request $request)
    {
        // Base validation
        $validationRules = [
            'note' => 'sometimes',
            'courier' => 'sometimes',
            'courier_package' => 'sometimes',
            'shipping_package' => 'required|string',
            'shipping_cost' => 'required|numeric|min:0',
            'payment_method_id' => 'required|exists:payment_methods,id'
        ];
        
        // Add address validation based on user authentication
        if (Auth::check()) {
            $validationRules['address_id'] = 'required|exists:user_addresses,id';
        } else {
            // Guest checkout validation - matching user_addresses table structure
            $validationRules['name'] = 'required|string|max:150';
            $validationRules['recipient_name'] = 'required|string|max:100';
            $validationRules['phone_number'] = 'required|string|max:20';
            $validationRules['address'] = 'required|string';
            $validationRules['city_name'] = 'required|string|max:100';
            $validationRules['province_name'] = 'required|string|max:100';
            $validationRules['postal_code'] = 'required|string|max:10';
            $validationRules['destination_type'] = 'required|string|max:100';
        }
        
        $request->validate($validationRules);

        // Parse shipping package data - format: "courier-service"
        $shippingPackageParts = explode('-', $request->shipping_package);
        $courier = $shippingPackageParts[0] ?? '';
        $courierService = $shippingPackageParts[1] ?? '';
        $deliveryPrice = $request->shipping_cost;

        // Get payment method
        $paymentMethod = \App\Models\PaymentMethod::findOrFail($request->payment_method_id);


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
            $total_weight = 0;

            // Hitung total
            foreach ($cartItems as $item) {
                $product = Product::find($item['product_id']);
                if (!$product) continue;

                $total += $product->price * $item['quantity'];
                $total_weight += (double)$product->weight * (double)$item['quantity'];
            }

            if($total_weight <= 1000) {
                $total_weight = 1000;
            }

            // Get address based on user authentication
            if (Auth::check()) {
                $address = UserAddress::find($request->address_id);
                if (!$address) {
                    return back()->with('error', 'Selected address not found.');
                }
            } else {
                // For guest checkout, create temporary address data
                $address = (object) [
                    'name' => $request->name,
                    'recipient_name' => $request->recipient_name,
                    'phone_number' => $request->phone_number,
                    'address' => $request->address,
                    'city_name' => $request->city_name,
                    'province_name' => $request->province_name,
                    'postal_code' => $request->postal_code,
                    'destination_type' => $request->destination_type,
                    'regency_id' => null // Will need to be handled separately for guest
                ];
            }

            $originId  = Option::getByKey('store_regency_id');
            $origin = Regency::find($originId);

            // Simpan order
            $order = Order::create([
                'user_id' => $userId,
                'address' => $address->address,
                'total_amount' => $total,
                'status' => 'pending',
                'note' => $request->note,
                'courier' => $courier,
                'courier_package' => $courierService,
                'delivery_price' => $deliveryPrice,
                'origin' => $originId,
                'originType' => 'city',
                'destination' => $address->city_id,
                'payment_method' => $paymentMethod->type,
                'payment_method_id' => $paymentMethod->id,
                'payment_status' => 'pending',
                'destinationType' => 'city',
                'total_weight' => $total_weight,
                'postal_code' => $address->postal_code,
                'recepient_name' => $address->recipient_name,
                'recepient_phone_number' => $address->phone_number
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
                    'weight' => $product->weight
                ]);
            }

            // Bersihkan cart
            if (Auth::check()) {
                DB::table('cart_items')->where('user_id', $userId)->delete();
            } else {
                Session::forget('cart');
            }

            DB::commit();

            // Redirect based on payment method type
            if ($paymentMethod->type === 'bank_transfer') {
                return redirect()->route('web.payment', $order->id);
            } else {
                return redirect()->route('web.my-account', $order->id)
                    ->with('success', 'Checkout berhasil!');
            }
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
    
    private function getCartItems()
    {
        if (Auth::check()) {
            // Get cart from database with product relationships
            return \App\Models\CartItem::where('user_id', Auth::id())
                ->with('product')
                ->get();
        } else {
            // Get cart from session and load products
            $cart = session('cart', []);
            $cartItems = collect([]);
            
            foreach ($cart as $item) {
                $product = \App\Models\Product::find($item['product_id']);
                if ($product) {
                    $cartItems->push((object) [
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'variation' => $item['variation'] ?? null,
                        'product_attributes' => $item['product_attributes'] ?? null,
                        'product' => $product
                    ]);
                }
            }
            
            return $cartItems;
        }
    }

    public function thankyou()
    {
        return view('frontend.thankyou');
    }

    public function myAccount(Request $request)
    {
        return view('frontend.my-account.index', [
            'user' => auth()->user(),
            'orders' => Order::with(['paymentMethod', 'items.product'])
                ->where('user_id', Auth::id())
                ->when($request->status, function($query, $status){
                    return $query->where('status', $status);
                })
                ->orderBy('created_at', 'desc')
                ->get()
        ]);
    }

    public function accountAddresses()
    {
        $provinces = Rajaongkir::new()->getProvinces();
        
        return view('frontend.my-account.addresses',[
            'addresses' => UserAddress::where('user_id', Auth::id())->get(),
            'provinces' => $provinces
        ]);
    }

    public function saveAccountAddresses(Request $request) 
    {
        $validated = $request->validate([
            'id' => 'sometimes',
            'name' => 'required',
            'recipient_name' => 'required',
            'phone_number' => 'required',
            'province_id' => 'required',
            'province_name' => 'required',
            'city_name' => 'required',
            'city_id' => 'required',
            'postal_code' => 'required',
            'address' => 'required',
            'is_default' => 'sometimes'
        ]);

        $validated['user_id'] = Auth::id();

        $userAddress = UserAddress::updateOrCreate(
            [
                'id' => $validated['id'] ?? ''
            ], 
            $validated
        );

        $id = $validated['id'] ?? $userAddress->id;

        if($validated['is_default'] ?? '')
        {
            UserAddress::where('user_id', Auth::id())
                ->whereNotIn('id', [$id])
                ->update([
                    'is_default' => 0
                ]);
        }

        return back();

    }

    public function personalInfo()
    {

       

        return view('frontend.my-account.personal-info', [
            'user' => Auth::user()
        ]);
    }

    public function savePersonalInfo(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100|min:2',
                'birth_date' => 'required|date|before:today',
                'phone_number' => 'required|string|max:20|min:10'
            ], [
                'name.required' => 'Nama lengkap wajib diisi',
                'name.min' => 'Nama lengkap minimal 2 karakter',
                'name.max' => 'Nama lengkap maksimal 100 karakter',
                'birth_date.required' => 'Tanggal lahir wajib diisi',
                'birth_date.date' => 'Format tanggal lahir tidak valid',
                'birth_date.before' => 'Tanggal lahir harus sebelum hari ini',
                'phone_number.required' => 'Nomor telepon wajib diisi',
                'phone_number.min' => 'Nomor telepon minimal 10 karakter',
                'phone_number.max' => 'Nomor telepon maksimal 20 karakter'
            ]);

            Auth::user()->update($validated);
            
            return back()->with('success', 'Profil berhasil diperbarui');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            $validated = $request->validate([
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:6|confirmed'
            ], [
                'current_password.required' => 'Password lama wajib diisi',
                'new_password.required' => 'Password baru wajib diisi',
                'new_password.min' => 'Password baru minimal 6 karakter',
                'new_password.confirmed' => 'Konfirmasi password tidak cocok'
            ]);

            $user = Auth::user();

            // Cek apakah password lama cocok
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama tidak cocok']);
            }

            // Cek apakah password baru sama dengan password lama
            if (Hash::check($request->new_password, $user->password)) {
                return back()->withErrors(['new_password' => 'Password baru harus berbeda dengan password lama']);
            }

            $user->update([
                'password' => Hash::make($validated['new_password'])
            ]);

            return back()->with('success', 'Password berhasil diperbarui');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengubah password. Silakan coba lagi.');
        }


    }

    public function blogs(Request $request)
    {
        $posts = Blog::whereIsPublished(1)
            ->when($request->s, function($query, $keyword){
                return $query->where('title', 'LIKE', '%' . $keyword . '%');
            })
            ->when($request->category_id, function($query, $category_id){
               return $query->whereHas('categories', function ($query) use ($category_id) {
                if (is_array($category_id)) {
                    return $query->whereIn('blog_category_id', $category_id);
                }

                return $query->where('blog_category_id', $category_id);
            });
            })
            ->paginate(20);
        $trendingPosts = Blog::trending()->take(5)->get();

        return view('frontend.blogs', [
            'posts' => $posts,
            'categories' => BlogCategory::orderBy('name', 'ASC')->get(),
            'trendingPosts' => $trendingPosts
        ]);
    }

    public function blogPost($slug)
    {
        $post = Blog::where('slug', $slug)->firstOrFail();

        $post->increment('views');

        return view('frontend.blog-post', compact('post'));
    }

    public function myAccountReviews() {
        echo 'testing';
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function payment($orderId)
    {
        $order = Order::with('paymentMethod', 'items.product')->findOrFail($orderId);
        
        // Ensure user has access to this order
        if (!Auth::check() || $order->user_id !== Auth::id()) {
            return redirect()->route('web.shop')->with('error', 'Order not found.');
        }
        
        return view('frontend.payment', compact('order'));
    }

    public function uploadPaymentProof(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        
        // Ensure user has access to this order
        if (!Auth::check() || $order->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'payment_notes' => 'nullable|string|max:500'
        ]);
        
        try {
            // Store the uploaded file
            $file = $request->file('payment_proof');
            $fileName = 'payment_proof_' . $order->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('payment_proofs', $fileName, 'public');
            
            // Update order with payment proof
            $order->update([
                'payment_proof' => $filePath,
                'payment_notes' => $request->payment_notes,
                'payment_status' => 'verification' // Change status to verification pending
            ]);
            
            return redirect()->route('web.my-account')
                ->with('success', 'Bukti pembayaran berhasil diupload. Pesanan Anda sedang diverifikasi.');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengupload bukti pembayaran: ' . $e->getMessage());
        }
    }
}


