<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\UserAddressController;
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
    ->name('login');
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

Route::get('blogs', [WebController::class, 'blogs'])
    ->name('web.blogs');
Route::get('/post/{slug?}', [WebController::class, 'blogPost'])
    ->name('web.blog-post');

Route::get('about-us', [WebController::class, 'about']);
Route::get('contact-us', [WebController::class, 'contact']);

Route::get('/logout', [AuthController::class, 'logout'])->name('web.my-account.logout');


Route::prefix('my-account')->middleware('auth')->group(function(){
    Route::get('/', [WebController::class, 'myAccount'])
        ->name('web.my-account');
    Route::get('/addresses', [WebController::class, 'accountAddresses'])
        ->name('web.my-account.addresses');
    Route::post('/addresses', [WebController::class, 'saveAccountAddresses'])
        ->name('web.my-account.save-addresses');
    Route::get('/personal-info', [WebController::class, 'personalInfo'])
        ->name('web.my-account.personal-info');
    Route::post('/personal-info', [WebController::class, 'savePersonalInfo'])
        ->name('web.my-account.save-personal-info');
    Route::post('/update-password', [WebController::class, 'updatePassword'])
        ->name('web.my-account.update-password');
});

Route::prefix('shipping')
    ->group(function(){
        Route::get('provinces', [ShippingController::class, 'getProvinces'])
            ->name('web.shipping.provinces');
        Route::get('regencies', [ShippingController::class, 'getRegencies'])
            ->name('web.shipping.regencies');
        Route::get('couriers', [ShippingController::class, 'getCouriers'])
            ->name('web.shipping.couriers');
        
        Route::post('cost', [ShippingController::class, 'getCost'])
            ->name('web.shipping.cost');
    });

Route::get('/shop', [WebController::class, 'shop'])
    ->name('web.shop');

// CART ROUTES (available for both auth and guest users)
Route::get('/cart', [WebController::class, 'cart'])->name('cart.index');
Route::post('/add-to-cart', [WebController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [WebController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [WebController::class, 'removeFromCart'])->name('cart.remove');
Route::get('checkout', [WebController::class, 'checkout'])->name('web.checkout');
Route::post('checkout', [WebController::class, 'doCheckout'])->name('web.do-checkout');

// Payment routes (auth required)
Route::middleware('auth')->group(function () {
    Route::get('/payment/{orderId}', [WebController::class, 'payment'])->name('web.payment');
    Route::post('/payment/{orderId}/upload-proof', [WebController::class, 'uploadPaymentProof'])->name('web.payment.upload-proof');
});

// User Address routes (auth required)
Route::middleware('auth')->group(function () {
    Route::post('/addresses', [UserAddressController::class, 'store'])->name('user.addresses.store');
    Route::post('/addresses/set-default', [UserAddressController::class, 'setDefault'])->name('user.addresses.set-default');
});

// Test route for debugging provinces
Route::get('/test-provinces', function() {
    $controller = new App\Http\Controllers\ShippingController();
    $request = new Illuminate\Http\Request();
    return $controller->getProvinces($request);
});

