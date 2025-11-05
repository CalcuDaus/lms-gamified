<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('auth.login.form');
});

Route::get('/verify-otp', function () {
    return view('auth.verify-otp');
})->name('auth.verify-otp');
Route::get('/register-form', [AuthController::class, 'showRegisterForm'])->name('auth.register.form');
Route::get('/login-form', [AuthController::class, 'showLoginForm'])->name('auth.login.form');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/verify-otp', [AuthController::class, 'verifyOTP'])->name('auth.verify-otp.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
});
