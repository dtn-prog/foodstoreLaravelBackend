<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CatController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



// Roles Routes
Route::controller(RoleController::class)->prefix('roles')->middleware('auth')->group(function () {
    Route::get('', 'index')->name('roles.index')->can('view roles');
    Route::get('create', 'create')->name('roles.create')->can('create roles');
    Route::post('', 'store')->name('roles.store')->can('create roles');
    Route::get('{role}/edit', 'edit')->name('roles.edit')->can('edit roles');
    Route::put('{role}', 'update')->name('roles.update')->can('edit roles');
    Route::delete('{role}', 'destroy')->name('roles.destroy')->can('delete roles');
});

// Products Routes
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

// Users Routes
Route::controller(UserController::class)->prefix('users')->middleware('auth')->group(function () {
    Route::get('', 'index')->name('users.index')->can('view users');
    Route::get('create', 'create')->name('users.create')->can('create users');
    Route::post('', 'store')->name('users.store')->can('create users');
    Route::get('{user}/edit', 'edit')->name('users.edit')->can('edit users');
    Route::put('{user}', 'update')->name('users.update')->can('edit users');
    Route::delete('{user}', 'destroy')->name('users.destroy')->can('delete users');
});

// Orders Routes
Route::controller(OrderController::class)
    ->prefix('orders')
    ->middleware('auth') // Apply auth middleware
    ->group(function () {
        Route::get('', 'index')->name('orders.index')->can('view orders');
        Route::post('', 'store')->name('orders.store')->can('create orders'); // Uncommented for order creation
        Route::get('{order}/edit', 'edit')->name('orders.edit')->can('edit orders');
        Route::put('{order}', 'update')->name('orders.update')->can('edit orders');
        Route::delete('{order}', 'destroy')->name('orders.destroy')->can('delete orders');
    });

// Cats Routes
Route::controller(CatController::class)
    ->prefix('cats')
    ->middleware('auth') // Apply auth middleware
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

Route::get('/sms', function() {

    $request = new HTTP_Request2();
    $request->setUrl('https://e5xzq3.api.infobip.com/sms/2/text/advanced');
    $request->setMethod(HTTP_Request2::METHOD_POST);
    $request->setConfig(array(
        'follow_redirects' => TRUE
    ));
    $request->setHeader(array(
        'Authorization' => 'App 07edae3507a29787c6307b76b2874c6f-d19665bb-7be9-4d54-babc-0dde6a641948',
        'Content-Type' => 'application/json',
        'Accept' => 'application/json'
    ));
    $request->setBody('{"messages":[{"destinations":[{"to":"84989674293"}],"from":"ServiceSMS","text":"123456"}]}');
    try {
        $response = $request->send();
        if ($response->getStatus() == 200) {
            echo $response->getBody();
        }
        else {
            echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
            $response->getReasonPhrase();
        }
    }
    catch(HTTP_Request2_Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
});
