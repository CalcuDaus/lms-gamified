<?php

use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\DashboardController;

// Redirect root ke halaman login
Route::redirect('/', '/login');


Route::middleware('nonAuth')->group(function () {
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
    });
});
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware('auth')->group(function () {
    // Admin Routes
    Route::middleware('ensureIsAdmin')->group(function () {
        Route::prefix('/admin')->group(function () {
            Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
            Route::resource('users', UserController::class);
            Route::resource('courses', CourseController::class);
            Route::resource('badges', BadgeController::class);
            Route::resource('materials', MaterialController::class);
            Route::resource('quizzes', QuizController::class);
            Route::resource('questions', QuestionController::class);
        });
    });

    // Student Routes
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('courses', [StudentController::class, 'showCourses'])->name('student.courses');
    Route::get('courses/detail/{id}', [StudentController::class, 'showCourseDetail'])->name('student.courses.show');
    Route::get('courses/learning-preview/{id}', [StudentController::class, 'showLearningPreview'])->name('student.courses.learning-preview');
    Route::post('courses/take/{id}', [StudentController::class, 'studentTakeACourse'])->name('student.courses.take');
    Route::get('courses/learn/{id}', [StudentController::class, 'learn'])->name('student.courses.learn');
    Route::get('material/{id}', [StudentController::class, 'viewMaterial'])->name('student.material.view');

    // Quiz Routes
    Route::get('quiz/{quizId}/start', [StudentController::class, 'startQuiz'])->name('student.quiz.start');
    Route::post('quiz/{quizId}/submit', [StudentController::class, 'submitQuiz'])->name('student.quiz.submit');
    Route::get('quiz/results/{attemptId}', [StudentController::class, 'showQuizResults'])->name('student.quiz.results');

    Route::get('leaderboard', [StudentController::class, 'leaderboard'])->name('student.leaderboard');





    Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
});
