<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FaceRecognitionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionGeneratorController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Authentication routes
Auth::routes();

// Home route after login
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Courses routes (public)
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
Route::post('/courses/{course}/enroll', [CourseController::class, 'enroll'])->middleware('auth')->name('courses.enroll');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Student routes
    Route::middleware(['role:student'])->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

        // Courses routes
        Route::get('/courses', [StudentDashboardController::class, 'courses'])->name('courses');
        Route::get('/courses/{course}', [StudentDashboardController::class, 'showCourse'])->name('courses.show');

        // Modules routes
        Route::get('/modules/{module}', [StudentDashboardController::class, 'showModule'])->name('modules.show');

        // Lessons routes
        Route::get('/lessons/{lesson}', [StudentDashboardController::class, 'showLesson'])->name('lessons.show');
        Route::post('/lessons/{lesson}/complete', [StudentDashboardController::class, 'completeLesson'])->name('lessons.complete');

        // Quizzes routes
        Route::get('/quizzes/{quiz}', [StudentDashboardController::class, 'showQuiz'])->name('quizzes.show');
        Route::post('/quizzes/{quiz}/submit', [StudentDashboardController::class, 'submitQuiz'])->name('quizzes.submit');
        Route::post('/quizzes/{quiz}/autosave', [StudentDashboardController::class, 'autosaveQuiz'])->name('quizzes.autosave');

        // Results routes
        Route::get('/results', [StudentDashboardController::class, 'results'])->name('results');
        Route::get('/results/{quizResult}', [StudentDashboardController::class, 'showResult'])->name('results.show');
    });

    // Teacher routes
    Route::middleware(['role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
        Route::resource('courses', CourseController::class)->except(['index', 'show']);
        Route::resource('modules', ModuleController::class)->except(['index', 'show']);
        Route::resource('lessons', LessonController::class)->except(['index', 'show']);
        Route::resource('quizzes', QuizController::class)->except(['index', 'show']);
        Route::get('/quizzes/{quiz}/generate-questions', [QuestionGeneratorController::class, 'generateQuestions'])->name('quizzes.generate-questions');
        Route::resource('questions', QuestionController::class)->except(['index', 'show']);
        Route::get('/students', [TeacherDashboardController::class, 'students'])->name('students');
        Route::get('/students/{user}', [TeacherDashboardController::class, 'showStudent'])->name('students.show');
    });

    // Admin routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/users', [AdminDashboardController::class, 'users'])->name('users');
        Route::get('/users/{user}/edit', [AdminDashboardController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}', [AdminDashboardController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [AdminDashboardController::class, 'destroyUser'])->name('users.destroy');
        Route::get('/courses', [AdminDashboardController::class, 'courses'])->name('courses');
        Route::get('/reports', [AdminDashboardController::class, 'reports'])->name('reports');
    });

    // Face recognition routes
    Route::post('/face-recognition/verify', [FaceRecognitionController::class, 'verify'])->name('face-recognition.verify');
    Route::post('/face-recognition/register', [FaceRecognitionController::class, 'register'])->name('face-recognition.register');
});
