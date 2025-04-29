<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminPermissionController;
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserDataController;
use App\Http\Controllers\Admin\UserOrderController;
use Illuminate\Support\Facades\Route;



Route::get('/', [LoginController::class, "index"])->name('login');
Route::post('/login', [LoginController::class, "checkLogin"])->name('admin.check');
Route::get('/logout', [LoginController::class, "loggedOut"])->name('logout');
    
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, "index"])->name('dashboard')->middleware(['check_permission']);
        
        Route::get('/sign', [AdminController::class, "index"])->name('Register')->middleware(['check_permission']);
        Route::post('/sign', [AdminController::class, "registerAdmin"])->name('admin.register');
        
        Route::get('/admin-users', [AdminController::class, "adminShow"])->name('admin.users')->middleware(['check_permission']);
        Route::post('/permission/{id}', [AdminPermissionController::class, 'setPermission'])->name('admin.permission')->middleware(['check_permission']);
        Route::get('/permission/{id}', [AdminPermissionController::class, 'getPermissions'])->name('admin.permission.view');
        Route::get('/admin-search', [AdminController::class, 'getAdminData'])->name('admin.search');

        Route::get('/user-data', [UserDataController::class, 'index'])->name('usersdata')->middleware(['check_permission']);
        Route::get('/user-search', [UserDataController::class, 'getUserData'])->name('user.search');
        Route::post('/user-register', [UserDataController::class, 'createUser'])->name('user.register');

        Route::get('/user-cart', [CartController::class, 'index'])->name('cart')->middleware(['check_permission']);
        
        Route::get('/product', [ProductController::class, "index"])->name("products")->middleware(['check_permission']);
        Route::post('/product', [ProductController::class, "addProduct"])->name("addproduct")->middleware(['check_permission']);
        Route::get('/product-search', [ProductController::class, 'getProducts'])->name('products.search');

        Route::get('/order-details', [UserOrderController::class, 'getOrderDetails'])->name('user.ordersDetails')->middleware(['check_permission']);
        Route::get('/order-search', [UserOrderController::class, 'searchOrderDetails'])->name('user.ordersDetails.search');
        
        Route::get('/order-items', [UserOrderController::class, 'getOrderItems'])->name('user.orderItems')->middleware(['check_permission']);
        Route::post('/order/{id}/ship', [UserOrderController::class, 'shipOrder']);

        Route::get('/shipped-orders', [UserOrderController::class, 'getShippedOrders'])->name('user.shippedOrders')->middleware(['check_permission']);
        Route::get('/shipped-search', [UserOrderController::class, 'searchShippedOrders'])->name('user.shippedOrders.search');
        Route::post('/order/{id}/deliver', [UserOrderController::class, 'deliverOrder']);

        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions')->middleware(['check_permission']);
        Route::get('/transaction-search', [TransactionController::class, 'show'])->name('transaction.search');



    });