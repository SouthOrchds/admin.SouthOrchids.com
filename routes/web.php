<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserDataController;
use App\Http\Controllers\Admin\UserOrderController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::get('/sign', [AdminController::class, "index"]);
    Route::post('/sign', [AdminController::class, "registerAdmin"])->name('adminRegister');
    Route::get('/login', [LoginController::class, "index"])->name('login');
    Route::post('/login', [LoginController::class, "checkLogin"])->name('adminCheck');
    
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, "index"])->name('dashboard');
        Route::get('/product', [ProductController::class, "index"])->name("product");
        Route::post('/product', [ProductController::class, "addProduct"])->name("addproduct");
        Route::get('/product-search', [ProductController::class, 'getProducts'])->name('products.search');
        Route::get('/user-data', [UserDataController::class, 'index'])->name('usersdata');
        Route::get('/user-search', [UserDataController::class, 'getUserData'])->name('user.search');

        Route::get('/orders', [UserOrderController::class, 'getOrders'])->name('user.orders');

        Route::get('/order-items', [UserOrderController::class, 'getOrderItems'])->name('user.orderItems');
        Route::post('/order/{id}/ship', [UserOrderController::class, 'shipOrder']);

        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');
        Route::get('/transaction-search', [TransactionController::class, 'show'])->name('transaction.search');
    });
});