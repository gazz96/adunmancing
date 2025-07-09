<?php

namespace App\Providers;

use App\Models\CartItem;
use App\Models\Menu;
use App\Models\Option;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::share('option', new Option());
        View::share('mainMenus', Menu::find(1));

        


        View::composer('*', function ($view) {
            if (app()->runningInConsole()) {
                return;
            }

            $cartCount = 0;

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
                            'product' => $product,
                            'variation' => $item['variation'],
                            'quantity' => $item['quantity'],
                        ];
                    }
                }
            }

            $carts = collect($carts);
            View::share('carts', $carts);
        });
        


    }
}
