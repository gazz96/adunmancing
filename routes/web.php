<?php

use App\Http\Controllers\AuthController;
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
Route::get('/product/{?slug}', [WebController::class, 'productDetail']) 
    ->name('frontend.product-detail');