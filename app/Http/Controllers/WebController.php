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

            'sliders' => \App\Models\Product::orderBy('created_at', 'desc')
                ->limit(3)
                ->whereStatus(1)
                ->get(),

            'newProducts' => \App\Models\Product::orderBy('created_at', 'DESC')
                ->take(5)
                ->get(),
            'makanProducts' => \App\Models\Product::orderBy('created_at', 'DESC')
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
                'weight' => $product->weight
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function checkout()
    {
        $couriers = Rajaongkir::new()->getCouriers();
        return view('frontend.checkout', [
            'addresses' => UserAddress::where('user_id', Auth::id())->get(),
            'couriers' => $couriers
        ]);
    }

    public function doCheckout(Request $request)
    {
        $request->validate([
            'note' => 'sometimes',
            'courier' => 'required',
            'courier_package' => 'required'
        ]);

        $deliveryPrice = explode('|', $request->courier_package)[2];


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

            $address = UserAddress::where('user_id', Auth::id())
                ->where('is_default', 1)
                ->first();

            $originId  = Option::getByKey('store_regency_id');
            $origin = Regency::find($originId);

            // Simpan order
            $order = Order::create([
                'user_id' => $userId,
                'address' => $address->address,
                'total_amount' => $total,
                'status' => 'pending',
                'note' => $request->note,
                'courier' => $request->courier,
                'courier_package' => $request->courier_package,
                'delivery_price' => $deliveryPrice,
                'origin' => $originId,
                'originType' => 'city',
                'destination' => $address->city_id,
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

    public function myAccount(Request $request)
    {
        return view('frontend.my-account.index', [
            'user' => auth()->user(),
            'orders' => Order::where('user_id', Auth::id())
                ->when($request->status, function($query, $status){
                    return $query->where('status', $status);
                })
                ->get()
        ]);
    }

    public function accountAddresses()
    {

        $cities = Cache::remember('regencies', 86400, function () {
            $response = \App\Services\Rajaongkir::new()->getRegencies(); 
            $data = $response->getData();
            $cities = collect($data->rajaongkir->results ?? []);
            return $cities;
        });
        return view('frontend.my-account.addresses',[
            'addresses' => UserAddress::where('user_id', Auth::id())->get(),
            'cities' => $cities
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
        $validated = $request->validate([
            'name' => 'required|max:100',
            'birth_date' => 'required|date',
            'phone_number' => 'required|max:100'
        ]);

        Auth::user()
            ->update($validated);

        return back()
            ->with('success', 'Profile berhasil diperbarui');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required'
        ]);

        $user = Auth::user();

        // Cek apakah password lama cocok
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah']);
        }

        $user->update([
            'password' => Hash::make($validated['new_password'])
        ]);

        return back()->with('success', 'Password berhasil diperbarui');


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
}


