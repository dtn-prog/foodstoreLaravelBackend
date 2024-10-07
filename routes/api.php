<?php

use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [RegisterController::class, 'register'])->name('api.register');

Route::controller(ProductController::class)->prefix('products')->group(function () {
    Route::get('', 'index')->name('api.products.index');

});
