<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/testing', function () {
    return 'Testing route is working!';
});

Route::get('/login', [AuthController::class, 'login'])
    ->name('web.auth.login');
Route::post('/login', [AuthController::class, 'doLogin'])
    ->name('web.auth.doLogin');
Route::get('/register', [AuthController::class, 'register'])
    ->name('web.auth.register');           
Route::post('/register', [AuthController::class, 'doRegister'])
    ->name('web.auth.doRegister');

Route::get('/', [WebController::class, 'index'])
    ->name('frontend.index');
Route::get('/shop', [WebController::class, 'shop']) 
    ->name('frontend.shop');
Route::get('/product/{slug?}', [WebController::class, 'productDetail']) 
    ->name('frontend.product-detail');


Route::prefix('my-account')->middleware('auth')->group(function(){
    Route::get('/', [WebController::class, 'myAccount'])
        ->name('web.my-account');
    Route::get('/addresses', [WebController::class, 'accountAddresses'])
        ->name('web.my-account.addresses');
});

Route::prefix('shipping')
    ->group(function(){
        Route::get('provinces', [ShippingController::class, 'getProvinces'])
            ->name('web.shipping.provinces');
        Route::get('regencies', [ShippingController::class, 'getRegencies'])
            ->name('web.shipping.regencies');
    });

Route::get('/shop', [WebController::class, 'shop'])
    ->name('web.shop');
    // CART ROUTES
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('checkout', [WebController::class, 'checkout'])->name('web.checkout');
    Route::post('checkout', [WebController::class, 'doCheckout'])->name('web.do-checkout');
});

