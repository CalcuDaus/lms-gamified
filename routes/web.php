<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('layout.app');
})->name('home');

Route::get('/verify-otp', function () {
    return view('auth.verify-otp');
})->name('auth.verify-otp');
Route::get('/register-form', [AuthController::class, 'showRegisterForm'])->name('auth.register.form');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/verify-otp', [AuthController::class, 'verifyOTP'])->name('auth.verify-otp.post');

Route::resource('users', UserController::class);