<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UserController;
use Illuminate\Auth\Events\LogOut;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function(){
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('auth', [AuthController::class, 'authProccess'])->name('authProccess');
});

Route::middleware('auth')->group(function(){
    //Logout
    Route::get('logout', [AuthController::class, 'logOut'])->name('logout');
    //Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    //User
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    //Product
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    //Purchases
    Route::get('purchases', [PurchaseController::class, 'index'])->name("purchases.index");
    Route::get('purchases/product', [PurchaseController::class, 'product'])->name("purchases.product");
    Route::post('purchases/create', [PurchaseController::class, 'create'])->name("purchases.create");
    Route::post('purchases/store', [PurchaseController::class, 'store'])->name('purchases.store');
    Route::get('purchases/invoice/{id}', [PurchaseController::class, 'invoice'])->name('purchases.invoice');
    Route::get('purchases/create', [PurchaseController::class, 'storeSales'])->name("purchases.storeSales");
    Route::get('purchases/member/{id}', [PurchaseController::class, 'updateSales'])->name("purchases.member");

    Route::get('/purchases/create', [PurchaseController::class, 'create'])->name('purchases.create');
    Route::post('/purchases/store', [PurchaseController::class, 'store'])->name('purchases.store');
    Route::get('/purchases/sale/member', [PurchaseController::class, 'storeSales'])->name('purchases.sale.member');
    Route::get('/purchases/invoice/{id}', [PurchaseController::class, 'invoice'])->name('purchases.invoice');

    // Route::get('purchases', [PurchaseController::class, 'index'])->name("purchases.index");

    // // Routes untuk produk
    // Route::get('purchases/product', [PurchaseController::class, 'product'])->name("purchases.product");

    // // Routes untuk halaman create dan proses pemilihan member
    // Route::get('purchases/create', [PurchaseController::class, 'create'])->name('purchases.create');
    // Route::post('purchases/create', [PurchaseController::class, 'store'])->name('purchases.store');

    // // Routes untuk proses pembayaran dan invoice
    // Route::get('purchases/invoice/{id}', [PurchaseController::class, 'invoice'])->name('purchases.invoice');

    // // Route untuk proses member (saat memilih member)
    // Route::get('purchases/member/{id}', [PurchaseController::class, 'updateSales'])->name("purchases.member");
    // Route::get('/purchases/sale/member/{id}', [PurchaseController::class, 'storeSales'])->name('purchases.sale.member');
});

