<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ReclamationController;
use App\Http\Controllers\FaceRecognitionController;
use App\Http\Controllers\AnalyticsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('public.welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('register', [UserController::class, 'showRegister'])->name('register');
    Route::post('register', [UserController::class, 'register']);
    Route::get('login', [UserController::class, 'showLogIn'])->name('login');
    Route::post('login', [UserController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [UserController::class, 'LogOut'])->name('logout');

    // Face Recognition Routes
    Route::get('/face/register', [FaceRecognitionController::class, 'showRegistration'])->name('face.register');
    Route::post('/face/register', [FaceRecognitionController::class, 'registerFace'])->name('face.register.post');
    Route::post('/face/verify', [FaceRecognitionController::class, 'verifyFace'])->name('face.verify');
    Route::get('/face/data', [FaceRecognitionController::class, 'getFaceData'])->name('face.data');
});

Route::get('/about', [UserController::class, 'showAbout']);
Route::get('/courses', [UserController::class, 'showCourses']);

Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'showAdmin'])->name('admin.dashboard');

    Route::get('/admin/users', [AdminController::class, 'showUsers'])->name('admin.users');
    Route::put('/admin/users/{id}/role', [AdminController::class, 'updateRole'])->name('admin.updateRole');
    Route::put('/admin/users/{id}/ban', [AdminController::class, 'banUser'])->name('admin.banUser');
    Route::put('/admin/users/{id}/unban', [AdminController::class, 'unbanUser'])->name('admin.unbanUser');

    Route::get('/admin/quizzes', [AdminController::class, 'showQuizzes'])->name('admin.quizzes');
    Route::get('/admin/quizzes/create', [QuizController::class, 'createQuiz'])->name('admin.createQuiz');
    Route::post('/admin/quizzes', [QuizController::class, 'storeQuiz'])->name('admin.storeQuiz');
    Route::get('/admin/quizzes/{id}/edit', [QuizController::class, 'editQuiz'])->name('admin.editQuiz');
    Route::put('/admin/quizzes/{id}', [QuizController::class, 'updateQuiz'])->name('admin.updateQuiz');
    Route::delete('/admin/quizzes/{id}', [QuizController::class, 'deleteQuiz'])->name('admin.deleteQuiz');

    Route::get('/admin/quizzes/{id}/questions', [AdminController::class, 'showQuizQuestions'])->name('admin.quizQuestions');
    Route::get('/admin/quizzes/{quizId}/questions/create', [QuizController::class, 'createQuestion'])->name('admin.createQuestion');
    Route::post('/admin/quizzes/{quizId}/questions', [QuizController::class, 'storeQuestion'])->name('admin.storeQuestion');
    Route::get('/admin/questions/{id}/edit', [QuizController::class, 'editQuestion'])->name('admin.editQuestion');
    Route::put('/admin/questions/{id}', [QuizController::class, 'updateQuestion'])->name('admin.updateQuestion');
    Route::delete('/admin/questions/{id}', [QuizController::class, 'deleteQuestion'])->name('admin.deleteQuestion');

    // AI Quiz Generation
    Route::get('/admin/courses/{courseId}/generate-quiz', [QuizController::class, 'showGenerateAIQuiz'])->name('admin.showGenerateAIQuiz');
    Route::post('/admin/courses/{courseId}/generate-quiz', [QuizController::class, 'generateAIQuiz'])->name('admin.generateAIQuiz');
    Route::post('/admin/courses/{courseId}/preview-quiz', [QuizController::class, 'previewAIQuiz'])->name('admin.previewAIQuiz');

    Route::get('/admin/courses', [AdminController::class, 'showCourses'])->name('admin.courses');
    Route::get('/admin/courses/create', [AdminController::class, 'createCourse'])->name('admin.createCourse');
    Route::get('/admin/courses/{id}', [AdminController::class, 'showCourse'])->name('admin.showCourse');
    Route::post('/admin/courses', [CourseController::class, 'storeCourse'])->name('admin.storeCourse');
    Route::get('/admin/courses/{id}/edit', [CourseController::class, 'editCourse'])->name('admin.editCourse');
    Route::put('/admin/courses/{id}/edit', [CourseController::class, 'updateCourse'])->name('admin.updateCourse');
    Route::delete('/admin/courses/{id}/delete', [CourseController::class, 'deleteCourse'])->name('admin.deleteCourse');

    Route::get('/admin/categories', [CategoryController::class, 'showCategories'])->name('admin.categories');
    Route::get('/admin/categories/create', [CategoryController::class, 'createCategory'])->name('admin.createCategory');
    Route::post('/admin/categories', [CategoryController::class, 'storeCategory'])->name('admin.storeCategory');
    Route::get('/admin/categories/{id}/edit', [CategoryController::class, 'editCategory'])->name('admin.editCategory');
    Route::put('/admin/categories/{id}', [CategoryController::class, 'updateCategory'])->name('admin.updateCategory');
    Route::delete('/admin/categories/{id}', [CategoryController::class, 'deleteCategory'])->name('admin.deleteCategory');

    Route::get('/admin/reclamations', [AdminController::class, 'showReclamations'])->name('admin.reclamations');
    Route::get('/admin/reclamations/{id}/respond', [AdminController::class, 'respondReclamation'])->name('admin.respondReclamation');
    Route::post('/admin/reclamations/{id}/respond', [ReclamationController::class, 'submitReclamationResponse'])->name('admin.submitReclamationResponse');
    Route::delete('/admin/reclamations/{id}/delete', [ReclamationController::class, 'deleteReclamation'])->name('admin.deleteReclamation');

    // Analytics Routes
    Route::get('/admin/analytics', [AnalyticsController::class, 'instructorDashboard'])->name('admin.analytics');
    Route::get('/admin/analytics/course/{courseId}', [AnalyticsController::class, 'courseAnalytics'])->name('admin.analytics.course');
    Route::get('/admin/analytics/quiz/{quizId}', [AnalyticsController::class, 'quizAnalytics'])->name('admin.analytics.quiz');
    Route::get('/admin/analytics/course/{courseId}/report', [AnalyticsController::class, 'downloadCourseReport'])->name('admin.analytics.course.report');
    Route::get('/admin/analytics/student/{studentId}/report', [AnalyticsController::class, 'downloadStudentReport'])->name('admin.analytics.student.report');
});

Route::middleware(['auth','role:user'])->group(function () {
    Route::get('/student', [StudentController::class, 'index'])->name('student.dashboard');
    Route::get('/student/courses', [StudentController::class, 'showCourses'])->name('student.courses');
    Route::get('/student/courses/{id}', [StudentController::class, 'showCourse'])->name('student.showCourse');
    Route::get('/student/myCourses', [StudentController::class, 'showMyCourses'])->name('student.myCourses');
    Route::get('/student/course-content', [StudentController::class, 'showCourseContent'])->name('student.courseContent');

    Route::get('/student/profile', [StudentController::class, 'showProfile'])->name('student.profile');
    Route::post('/student/profile', [StudentController::class, 'updateProfile'])->name('student.profile.update');
    Route::post('/student/profile/password', [StudentController::class, 'updatePassword'])->name('student.profile.password');

    Route::get('/student/progress', [StudentController::class, 'showProgress'])->name('student.progress');
    Route::get('/student/analytics', [AnalyticsController::class, 'studentDashboard'])->name('student.analytics');
    Route::get('/student/analytics/report', [AnalyticsController::class, 'downloadStudentReport'])->name('student.analytics.report');

    Route::get('/student/quiz/{id}', [QuizController::class, 'takeQuiz'])->name('student.quiz');
    Route::get('/student/quiz/result', [StudentController::class, 'showQuizResult'])->name('student.quizResult');
    Route::post('/quiz/submit', [QuizController::class, 'submitQuiz'])->name('student.submitQuiz');

    // Secure Exam with Face Recognition
    Route::get('/student/secure-exam/{quizId}', [FaceRecognitionController::class, 'showExamVerification'])->name('student.secureExam');

    Route::get('/student/leaderboard', [StudentController::class, 'showLeaderboard'])->name('student.leaderboard');

    Route::get('/student/support', [StudentController::class, 'showSupport'])->name('student.support');
    Route::post('/student/support', [StudentController::class, 'submitSupport'])->name('student.support.submit');

    Route::get('/student/achievements', [StudentController::class, 'showAchievements'])->name('student.achievements');
});

Route::middleware(['auth','role:agent'])->group(function () {
    Route::get('/agent', [AgentController::class, 'index'])->name('agent.dashboard');
    Route::get('/agent/courses', [AgentController::class, 'showCourses'])->name('agent.courses');
    Route::get('/agent/reclamations', [AgentController::class, 'showReclamations'])->name('agent.reclamations');

    Route::get('/agent/reclamations', [AgentController::class, 'showReclamations'])->name('agent.reclamations');
    Route::get('/agent/reclamations/{id}/respond', [AgentController::class, 'respondReclamation'])->name('agent.respondReclamation');
    Route::post('/agent/reclamations/{id}/respond', [ReclamationController::class, 'submitReclamationResponse'])->name('agent.submitReclamationResponse');
});