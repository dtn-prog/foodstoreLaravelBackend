<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\CatController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OtpController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function() {
    // Route to send OTP
    Route::post('send-otp', [OtpController::class, 'sendOtp'])->name('api.send.otp');

    // Route to verify OTP
    Route::post('verify-otp', [OtpController::class, 'verifyOtp'])->name('api.verify.otp');
});

Route::post('register', [RegisterController::class, 'register'])->name('api.register');
Route::post('login', [LoginController::class, 'login'])->name('api.login');


Route::middleware('auth:sanctum')->group(function() {
    Route::post('logout', [LoginController::class, 'logout'])->name('api.logout');

    Route::post('orders/place', [OrderController::class, 'place'])->name("api.orders.place");

    Route::get('orders/history', [OrderController::class, 'history'])->name("api.orders.history");
});


Route::controller(ProductController::class)->prefix('products')->group(function () {
    Route::get('', 'index')->name('api.products.index');
});

Route::get('location',[LocationController::class, 'get']);

Route::get('cats',[CatController::class, 'index']);

Route::get('cats/products', [CatController::class, 'productsThroughCats']);
Route::get('cats/{cat}/products', [CatController::class, 'productsByCat']);
