<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CatController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(RoleController::class)->prefix('roles')->group(function () {
    Route::get('', 'index')->name('roles.index');
    Route::get('create', 'create')->name('roles.create');
    Route::post('', 'store')->name('roles.store');
    Route::get('{role}/edit', 'edit')->name('roles.edit');
    Route::put('{role}', 'update')->name('roles.update');
    Route::delete('{role}', 'destroy')->name('roles.destroy');
});


Route::controller(ProductController::class)
    ->prefix('products')
    ->middleware('auth')
    ->group(function () {
        Route::get('', 'index')->name('products.index')->can('view products');
        Route::get('create', 'create')->name('products.create')->can('create products');
        Route::post('', 'store')->name('products.store')->can('create products');
        Route::get('{product}/edit', 'edit')->name('products.edit')->can('edit products');
        Route::put('{product}', 'update')->name('products.update')->can('edit products');
        Route::delete('{product}', 'destroy')->name('products.destroy')->can('delete products');
    });


Route::controller(UserController::class)->prefix('users')->group(function () {
    Route::get('', 'index')->name('users.index');
    Route::get('create', 'create')->name('users.create');
    Route::post('', 'store')->name('users.store');
    Route::get('{user}/edit', 'edit')->name('users.edit');
    Route::put('{user}', 'update')->name('users.update');
    Route::delete('{user}', 'destroy')->name('users.destroy');
});

Route::controller(OrderController::class)->prefix('orders')->group(function () {
    Route::get('', 'index')->name('orders.index');
    Route::get('create', 'create')->name('orders.create');
    Route::post('', 'store')->name('orders.store');
    Route::get('{order}/edit', 'edit')->name('orders.edit');
    Route::put('{order}', 'update')->name('orders.update');
    Route::delete('{order}', 'destroy')->name('orders.destroy');
});

Route::controller(CatController::class)
    ->prefix('cats')
    ->middleware('auth')
    ->group(function () {
        Route::get('', 'index')->name('cats.index')->can('view cats');
        Route::get('create', 'create')->name('cats.create')->can('create cats');
        Route::post('', 'store')->name('cats.store')->can('create cats');
        Route::get('{cat}/edit', 'edit')->name('cats.edit')->can('edit cats');
        Route::put('{cat}', 'update')->name('cats.update')->can('edit cats');
        Route::delete('{cat}', 'destroy')->name('cats.destroy')->can('delete cats');
    });

// Non-admin routes
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('login', [LoginController::class, 'create'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'create'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
