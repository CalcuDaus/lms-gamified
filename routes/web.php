<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Requests\AuthRequest;

// Redirect root ke halaman login
Route::redirect('/', '/login');

// Grouping route otentikasi
Route::controller(AuthController::class)->group(function () {
    // Form routes
    Route::get('/login', 'showLoginForm')->name('login');
    Route::get('/register-form', 'showRegisterForm')->name('register');
    Route::get('/verify-otp-form', 'showVerifyOTPForm')->name('verify-otp');

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
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
});
