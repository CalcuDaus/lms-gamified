<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;


// Redirect root ke halaman login
Route::redirect('/', '/login');

// Grouping route otentikasi
Route::controller(AuthController::class)->group(function () {
    // Form routes
    Route::get('/login', 'showLoginForm')->name('login');
    Route::get('/register-form', 'showRegisterForm')->name('register.form');
    Route::get('/verify-otp-form', 'showVerifyOTPForm')->name('verify-otp.form');

    // Action routes
    Route::post('/login', 'login')->name('login.post');
    Route::post('/register', 'register')->name('register.post');
    Route::post('/verify-otp', 'verifyOTP')->name('verify-otp.post');
    Route::get('/logout', 'logout')->name('logout');
});


Route::middleware('auth')->group(function () {
    // Admin Routes
    Route::middleware('ensureIsAdmin')->group(function () {
        Route::prefix('/admin')->group(function () {
            Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
            Route::resource('users', UserController::class);
            Route::resource('courses', CourseController::class);
        });
    });

    // Student Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
