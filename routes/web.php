<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::controller(ProductController::class)->prefix('products')->group(function () {
    Route::get('', 'index')->name('products.index');
    Route::get('create', 'create')->name('products.create');
    Route::post('', 'store')->name('products.store');
    Route::get('{product}/edit', 'edit')->name('products.edit');
    Route::put('{product}', 'update')->name('products.update');
    Route::delete('{product}', 'destroy')->name('products.destroy');
});

Route::controller(UserController::class)->prefix('users')->group(function () {
    route::get('', 'index')->name('users.index');
    Route::get('create', 'create')->name('users.create');
    Route::post('', 'store')->name('users.store');
    Route::get('{user}/edit', 'edit')->name('users.edit');
    Route::put('{user}', 'update')->name('users.update');
    Route::delete('{user}', 'destroy')->name('users.destroy');
});

Route::controller(OrderController::class)->prefix('orders')->group(function () {
    route::get('', 'index')->name('orders.index');
    Route::get('create', 'create')->name('orders.create');
    Route::post('', 'store')->name('orders.store');
    Route::get('{order}/edit', 'edit')->name('orders.edit');
    Route::put('{order}', 'update')->name('orders.update');
    Route::delete('{order}', 'destroy')->name('orders.destroy');
});

Route::get('login', [LoginController::class, 'create'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'create'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
