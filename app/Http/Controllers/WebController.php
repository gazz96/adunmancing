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

    public function shop()
    {
        return view('frontend.shop.index', [
            'productCategories' => \App\Models\Category::orderBy('name')
                ->limit(6)
                ->get(),
        ]);
    }

    public function myAccount()
    {
        return view('frontend.my-account.index', [
            'user' => auth()->user(),
        ]);
    }
}
