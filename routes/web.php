<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('auth', [AuthController::class, 'authProccess'])->name('authProccess');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {

    // Logout
    Route::get('logout', [AuthController::class, 'logOut'])->name('logout');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.duplicate');

    // User 
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    // Product 
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
    });

    // Transactions
    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('index');
        Route::get('/show', [TransactionController::class, 'show'])->name('show');
        Route::get('/create', [TransactionController::class, 'create'])->name('create');
        Route::post('/create', [TransactionController::class, 'store'])->name('store');

        // Sales
        Route::post('/sale/create', [TransactionController::class, 'storeSales'])->name('sale.store');
        Route::get('/sale/member/{id}', [TransactionController::class, 'updateSales'])->name('sale.member');
        Route::post('/sale/detail-print/{id}', [TransactionController::class, 'printdetailStore'])->name('sale.detail.store');
        Route::get('/sale/detail-print/{id}', [TransactionController::class, 'printDetail'])->name('sale.print');
    });

    // PDF Export
    Route::prefix('print')->name('pdf.')->group(function () {
        Route::get('/{id}', [TransactionController::class, 'pdf'])->name('print');
    });

    // Excel Export
    Route::prefix('excel')->name('excel.')->group(function () {
        Route::get('/transactions', [TransactionController::class, 'excel'])->name('print');
    });

});
