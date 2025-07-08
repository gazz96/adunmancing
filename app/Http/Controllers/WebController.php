<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function myAccount()
    {
        return view('frontend.my-account.index', [
            'user' => auth()->user(),
        ]);
    }


    public function shop(Request $request)
    {
        return view('frontend.shop', [
            'productCategories' => \App\Models\Category::orderBy('name')
                ->get(),
            'products' => \App\Models\Product::orderBy('created_at', 'desc')
                ->whereStatus(1)
                ->paginate(12)
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

}
