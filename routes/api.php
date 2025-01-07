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

// Route to get the authenticated user
Route::middleware(['auth:sanctum', 'check.blacklisted'])->get('/user', function (Request $request) {
    return $request->user();
});

// Group for routes that require authentication and blacklist check
Route::middleware(['auth:sanctum', 'check.blacklisted'])->group(function() {
    Route::post('send-otp', [OtpController::class, 'sendOtp'])->name('api.send.otp');
    Route::post('verify-otp', [OtpController::class, 'verifyOtp'])->name('api.verify.otp');

    Route::post('logout', [LoginController::class, 'logout'])->name('api.logout');

    // Route to get order history
    Route::get('orders/history', [OrderController::class, 'history'])->name("api.orders.history");
});

// Password reset routes (not requiring blacklisted check)
Route::post('password/reset/request', [OtpController::class, 'requestPasswordReset'])
    ->name('api.password.reset.request');
Route::post('password/reset/verify', [OtpController::class, 'verifyPasswordReset'])
    ->name('api.password.reset.verify');

// Registration route (not requiring blacklisted check)
Route::post('register', [RegisterController::class, 'register'])->name('api.register');

// Login route with blacklisted check
Route::post('login', [LoginController::class, 'login'])->name('api.login')->middleware('check.blacklisted');

// Group for routes requiring both authentication and phone verification
Route::middleware(['auth:sanctum', 'check.blacklisted', 'check.phone.verified'])->group(function() {
    Route::post('orders/place', [OrderController::class, 'place'])->name("api.orders.place");
});



Route::controller(ProductController::class)->prefix('products')->group(function () {
    Route::get('', 'index')->name('api.products.index');
});

Route::get('location',[LocationController::class, 'get']);

Route::get('cats',[CatController::class, 'index']);

Route::get('cats/products', [CatController::class, 'productsThroughCats']);
Route::get('cats/{cat}/products', [CatController::class, 'productsByCat']);
