<?php

use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;

// Teacher Controllers
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Teacher\CourseController as TeacherCourseController;
use App\Http\Controllers\Teacher\MaterialController as TeacherMaterialController;
use App\Http\Controllers\Teacher\QuizController as TeacherQuizController;
use App\Http\Controllers\Teacher\QuestionController as TeacherQuestionController;
use App\Http\Controllers\Teacher\AnalyticsController as TeacherAnalyticsController;

// Student Controllers
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\CourseController as StudentCourseController;
use App\Http\Controllers\Student\MaterialController as StudentMaterialController;
use App\Http\Controllers\Student\QuizController as StudentQuizController;
use App\Http\Controllers\Student\LeaderboardController as StudentLeaderboardController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\BadgeController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\QuestionController;

// Redirect root to login page
Route::redirect('/', '/login');

// Language switching route (available to all)
Route::post('/language/switch', [LanguageController::class, 'switch'])->name('language.switch');

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
    // Settings Routes (accessible by all authenticated users)
    Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings');
    Route::put('/settings/profile', [App\Http\Controllers\SettingsController::class, 'updateProfile'])->name('settings.profile');
    Route::put('/settings/password', [App\Http\Controllers\SettingsController::class, 'updatePassword'])->name('settings.password');

    // Profile Route (view other users' profiles)
    Route::get('/profile/{userId}', [ProfileController::class, 'show'])->name('profile.show');

    // Admin Routes
    Route::middleware('ensureIsAdmin')->group(function () {
        Route::prefix('/admin')->group(function () {
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
            Route::resource('users', UserController::class);
            Route::resource('courses', CourseController::class);
            Route::resource('badges', BadgeController::class);
            Route::resource('materials', MaterialController::class);
            Route::resource('quizzes', QuizController::class);
            Route::resource('questions', QuestionController::class);
        });
    });

    // Student Routes
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    Route::get('courses', [StudentCourseController::class, 'index'])->name('student.courses');
    Route::get('courses/detail/{id}', [StudentCourseController::class, 'show'])->name('student.courses.show');
    Route::get('courses/learning-preview/{id}', [StudentCourseController::class, 'learningPreview'])->name('student.courses.learning-preview');
    Route::post('courses/take/{id}', [StudentCourseController::class, 'take'])->name('student.courses.take');
    Route::get('courses/learn/{id}', [StudentCourseController::class, 'learn'])->name('student.courses.learn');
    Route::get('material/{id}', [StudentMaterialController::class, 'view'])->name('student.material.view');
    Route::post('material/{id}/complete', [StudentMaterialController::class, 'complete'])->name('student.material.complete');

    // Quiz Routes
    Route::get('quiz/{quizId}/start', [StudentQuizController::class, 'start'])->name('student.quiz.start');
    Route::post('quiz/{quizId}/submit', [StudentQuizController::class, 'submit'])->name('student.quiz.submit');
    Route::get('quiz/results/{attemptId}', [StudentQuizController::class, 'results'])->name('student.quiz.results');

    Route::get('leaderboard', [StudentLeaderboardController::class, 'index'])->name('student.leaderboard');

    // Teacher Routes
    Route::middleware('ensureIsTeacher')->prefix('teacher')->group(function () {
        // Dashboard
        Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('teacher.dashboard');
        
        // Course Management
        Route::get('/courses', [TeacherCourseController::class, 'index'])->name('teacher.courses.index');
        Route::get('/courses/create', [TeacherCourseController::class, 'create'])->name('teacher.courses.create');
        Route::post('/courses', [TeacherCourseController::class, 'store'])->name('teacher.courses.store');
        Route::get('/courses/{id}/edit', [TeacherCourseController::class, 'edit'])->name('teacher.courses.edit');
        Route::put('/courses/{id}', [TeacherCourseController::class, 'update'])->name('teacher.courses.update');
        Route::delete('/courses/{id}', [TeacherCourseController::class, 'destroy'])->name('teacher.courses.destroy');
        
        // Material Management
        Route::get('/courses/{courseId}/materials/create', [TeacherMaterialController::class, 'create'])->name('teacher.materials.create');
        Route::post('/courses/{courseId}/materials', [TeacherMaterialController::class, 'store'])->name('teacher.materials.store');
        Route::get('/materials/{id}/edit', [TeacherMaterialController::class, 'edit'])->name('teacher.materials.edit');
        Route::put('/materials/{id}', [TeacherMaterialController::class, 'update'])->name('teacher.materials.update');
        Route::delete('/materials/{id}', [TeacherMaterialController::class, 'destroy'])->name('teacher.materials.destroy');
        
        // Quiz Management
        Route::get('/materials/{materialId}/quizzes/create', [TeacherQuizController::class, 'create'])->name('teacher.quizzes.create');
        Route::post('/materials/{materialId}/quizzes', [TeacherQuizController::class, 'store'])->name('teacher.quizzes.store');
        Route::get('/quizzes/{id}/edit', [TeacherQuizController::class, 'edit'])->name('teacher.quizzes.edit');
        Route::put('/quizzes/{id}', [TeacherQuizController::class, 'update'])->name('teacher.quizzes.update');
        Route::delete('/quizzes/{id}', [TeacherQuizController::class, 'destroy'])->name('teacher.quizzes.destroy');
        
        // Question Management
        Route::get('/quizzes/{quizId}/questions', [TeacherQuestionController::class, 'index'])->name('teacher.questions.manage');
        Route::post('/quizzes/{quizId}/questions', [TeacherQuestionController::class, 'store'])->name('teacher.questions.store');
        Route::get('/questions/{id}/edit', [TeacherQuestionController::class, 'edit'])->name('teacher.questions.edit');
        Route::put('/questions/{id}', [TeacherQuestionController::class, 'update'])->name('teacher.questions.update');
        Route::delete('/questions/{id}', [TeacherQuestionController::class, 'destroy'])->name('teacher.questions.destroy');
        
        // Student Monitoring
        Route::get('/courses/{id}/analytics', [TeacherAnalyticsController::class, 'courseAnalytics'])->name('teacher.analytics.course');
        Route::get('/students/{userId}/progress', [TeacherAnalyticsController::class, 'studentProgress'])->name('teacher.analytics.student');
    });
});
