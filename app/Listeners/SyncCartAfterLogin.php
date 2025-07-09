<?php

namespace App\Listeners;

use App\Models\CartItem;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Session;

class SyncCartAfterLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $sessionCart = Session::get('cart', []);
        $user = $event->user;

        foreach ($sessionCart as $item) {
            $productId = $item['product_id'];
            $variation = $item['variation'];
            $quantity = $item['quantity'];

            // Cari apakah sudah ada item dengan kombinasi ini
            $existing = CartItem::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->where('variation', json_encode($variation))
                ->first();

            if ($existing) {
                $existing->quantity += $quantity;
                $existing->save();
            } else {
                CartItem::create([
                    'user_id' => $user->id,
                    'product_id' => $productId,
                    'variation' => $variation,
                    'quantity' => $quantity,
                ]);
            }
        }

        // Kosongkan session cart setelah sinkron
        Session::forget('cart');
    }
}
