<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return redirect()->route('auth.login.form');
});


Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::get('/login-form', [AuthController::class, 'showLoginForm'])->name('auth.login.form');
Route::get('/register-form', [AuthController::class, 'showRegisterForm'])->name('auth.register.form');
Route::get('/verify-otp-form', [AuthController::class, 'showVerifyOTPForm'])->name('auth.verify-otp.form');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::post('/verify-otp', [AuthController::class, 'verifyOTP'])->name('auth.verify-otp.post');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('courses', CourseController::class);
    Route::resource('users', UserController::class);
});
