<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\OrderHistoryController;
use App\Http\Controllers\Api\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;

Route::post("/signup", [UserController::class, "register"]);
Route::post("/login", [LoginController::class,"loginCheck"]);
Route::get("/products", [ProductController::class, "sendmsg"]);
Route::get("/user-info", [UserController::class, "UserData"])->middleware('auth');
Route::middleware('auth')->group(function () {
    Route::post("/cart/add", [CartController::class, "AddCartItem"]);
    Route::get("/cart", [CartController::class, "ShowCartItems"]);
    Route::delete("/cart/remove/{product_id}", [CartController::class, "DeleteCartItme"]);
});
Route::middleware('auth')->group(function () {
    Route::post("/create-order", [PaymentController::class, "createOrder"]);
    Route::post("/payment-success", [PaymentController::class, "handlePaymentSuccess"]);
    Route::post("/payment-failure", [PaymentController::class, "handlePaymentFailure"]);
});
Route::get("/order-history", [OrderHistoryController::class, "orderHistory"])->middleware('auth');