<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::controller(ProductController::class)->prefix('products')->group(function () {
    Route::get('', 'index')->name('products.index');
    Route::get('create', 'create')->name('products.create');
    Route::post('', 'store')->name('products.store');
    Route::get('{product}/edit', 'edit')->name('products.edit');
    Route::put('{product}', 'update')->name('products.update');
    Route::delete('{product}', 'destroy')->name('products.destroy');
});
