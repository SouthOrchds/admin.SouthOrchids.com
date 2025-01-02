<?php

use App\Http\Controllers\Admin\LoginController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin-login', [LoginController::class, 'index'])->name('login');

Route::post('/admin-login', [LoginController::class, 'checkLogin'])->name('adminCheck');
