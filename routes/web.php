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
use App\Http\Controllers\AdaptiveLearningController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TwoFactorAuthController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\PracticeQuestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('public.welcome_new');
});

Route::middleware('guest')->group(function () {
    Route::get('register', [UserController::class, 'showRegister'])->name('register');
    Route::post('register', [UserController::class, 'register']);
    Route::get('login', [UserController::class, 'showLogIn'])->name('login');
    Route::post('login', [UserController::class, 'login']);
});

// Two-Factor Authentication Challenge Routes
Route::middleware(['auth', 'two-factor.challenge'])->group(function () {
    Route::get('/two-factor-challenge', [TwoFactorAuthController::class, 'showChallenge'])->name('two-factor.challenge');
    Route::post('/two-factor-challenge', [TwoFactorAuthController::class, 'verifyChallenge']);
});

// Logout route without prevent.concurrent.logins middleware
Route::middleware(['auth'])->group(function () {
    Route::post('logout', [UserController::class, 'LogOut'])->name('logout');
});

// Other authenticated routes
Route::middleware(['auth'])->group(function () {

    // Face Recognition Routes
    Route::prefix('face-recognition')->name('face.')->group(function () {
        Route::get('/register', [FaceRecognitionController::class, 'showRegistration'])->name('register');
        Route::get('/modern-register', [FaceRecognitionController::class, 'showModernRegistration'])->name('modern.register');
        Route::get('/debug-register', [FaceRecognitionController::class, 'showDebugRegistration'])->name('debug.register');
        Route::post('/register', [FaceRecognitionController::class, 'registerFace'])->name('register.post');
        Route::post('/verify', [FaceRecognitionController::class, 'verifyFace'])->name('verify');
        Route::get('/data', [FaceRecognitionController::class, 'getFaceData'])->name('data');

        // Exam session routes
        Route::post('/exam-session/{quizId}', [FaceRecognitionController::class, 'startExamSession'])->name('exam.session.start');
        Route::post('/terminate-session/{sessionId}', [FaceRecognitionController::class, 'terminateSession'])->name('exam.session.terminate');

        // Exam monitoring (for teachers/admins)
        Route::get('/monitoring', [FaceRecognitionController::class, 'showExamMonitoring'])
            ->name('exam.monitoring')
            ->middleware('role:teacher,admin');
    });

    // Two-Factor Authentication Routes
    Route::prefix('profile/two-factor')->name('profile.two-factor.')->group(function () {
        Route::get('/', [TwoFactorAuthController::class, 'show'])->name('show');
        Route::post('/', [TwoFactorAuthController::class, 'enable'])->name('enable');
        Route::delete('/', [TwoFactorAuthController::class, 'disable'])->name('disable');
        Route::post('/recovery-codes', [TwoFactorAuthController::class, 'regenerateRecoveryCodes'])->name('regenerate-recovery-codes');
    });

    // Profile Routes
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');
    Route::patch('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [UserController::class, 'updatePassword'])->name('profile.password.update');

    // User Activity Log
    Route::get('/profile/activity', [ActivityLogController::class, 'userActivity'])->name('profile.activity');

    // Browser Sessions
    Route::get('/profile/sessions', [SessionController::class, 'index'])->name('profile.sessions');
    Route::delete('/profile/sessions', [SessionController::class, 'destroyOtherSessions'])->name('profile.sessions.destroy');
});

Route::get('/about', function() {
    return view('public.about-updated');
});
Route::get('/courses', [UserController::class, 'showCourses']);
Route::get('/courses/{id}', [\App\Http\Controllers\CourseController::class, 'showCourse'])->name('course.show');

// Image routes
Route::get('/images/default-course.svg', [\App\Http\Controllers\ImageController::class, 'defaultCourse'])->name('images.default-course');

// Legal Routes
Route::prefix('legal')->name('legal.')->group(function () {
    Route::get('/privacy', function () {
        return view('legal.privacy');
    })->name('privacy');

    Route::get('/terms', function () {
        return view('legal.terms');
    })->name('terms');

    Route::get('/cookies', function () {
        return view('legal.cookies');
    })->name('cookies');

    Route::get('/accessibility', function () {
        return view('legal.accessibility');
    })->name('accessibility');
});

Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'showAdmin'])->name('admin.dashboard');

    // Activity Logs Routes
    Route::get('/admin/activity-logs', [ActivityLogController::class, 'index'])->name('admin.activity-logs.index');
    Route::get('/admin/activity-logs/{id}', [ActivityLogController::class, 'show'])->name('admin.activity-logs.show');
    Route::delete('/admin/activity-logs', [ActivityLogController::class, 'clear'])->name('admin.activity-logs.clear');

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
    Route::get('/admin/analytics', [App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('admin.analytics');
    Route::get('/admin/analytics/course/{courseId}', [AnalyticsController::class, 'courseAnalytics'])->name('admin.analytics.course');
    Route::get('/admin/analytics/quiz/{quizId}', [AnalyticsController::class, 'quizAnalytics'])->name('admin.analytics.quiz');
    Route::get('/admin/analytics/course/{courseId}/report', [AnalyticsController::class, 'downloadCourseReport'])->name('admin.analytics.course.report');
    Route::get('/admin/analytics/student/{studentId}/report', [AnalyticsController::class, 'downloadStudentReport'])->name('admin.analytics.student.report');
});

Route::middleware(['auth','role:user'])->group(function () {
    Route::get('/student', [StudentController::class, 'index'])->name('student.dashboard');
    Route::get('/student/courses', [StudentController::class, 'showCourses'])->name('student.courses');
    Route::get('/student/courses/{id}', [StudentController::class, 'showCourse'])->name('student.showCourse');
    Route::post('/student/courses/{id}/enroll', [StudentController::class, 'enrollCourse'])->name('student.enrollCourse');

    // Lesson Progress Routes
    Route::post('/student/courses/{courseId}/lessons/{lessonId}/complete', [StudentController::class, 'markLessonCompleted'])->name('student.lesson.complete');
    Route::post('/student/courses/{courseId}/lessons/{lessonId}/progress', [StudentController::class, 'updateLessonProgress'])->name('student.lesson.progress');

    // Content Progress Routes (for old system)
    Route::post('/student/courses/{courseId}/contents/{contentId}/complete', [StudentController::class, 'markContentCompleted'])->name('student.content.complete');

    // Simple test route
    Route::get('/test-complete-simple/{courseId}/{contentId}', function($courseId, $contentId) {
        $user = auth()->user();
        if (!$user) return 'Not logged in';

        session()->put("content_completed_{$user->id}_{$contentId}", true);

        return redirect()->route('student.showCourse', $courseId)->with('success', 'Content marked as completed!');
    });

    Route::get('/student/myCourses', [StudentController::class, 'showMyCourses'])->name('student.myCourses');
    Route::get('/student/course-content', [StudentController::class, 'showCourseContent'])->name('student.courseContent');

    Route::get('/student/profile', [StudentController::class, 'showProfile'])->name('student.profile');
    Route::post('/student/profile', [StudentController::class, 'updateProfile'])->name('student.profile.update');
    Route::post('/student/profile/password', [StudentController::class, 'updatePassword'])->name('student.profile.password');

    Route::get('/student/progress', [StudentController::class, 'showProgress'])->name('student.progress');
    Route::get('/student/analytics', [AnalyticsController::class, 'studentDashboard'])->name('student.analytics');
    Route::get('/student/analytics/report', [AnalyticsController::class, 'downloadStudentReport'])->name('student.analytics.report');

    // Adaptive Learning Routes
    Route::get('/student/adaptive-learning', [AdaptiveLearningController::class, 'dashboard'])->name('student.adaptiveLearning');
    Route::get('/student/adaptive-learning/course/{courseId}', [AdaptiveLearningController::class, 'courseLearningPath'])->name('student.adaptiveLearning.course');
    Route::get('/student/adaptive-learning/practice/{courseId}', [AdaptiveLearningController::class, 'practiceSession'])->name('student.adaptiveLearning.practice');
    Route::post('/student/adaptive-learning/practice/submit', [AdaptiveLearningController::class, 'processPracticeAnswers'])->name('student.adaptiveLearning.practice.submit');
    Route::get('/student/adaptive-learning/question-demo', [AdaptiveLearningController::class, 'interactiveQuestionDemo'])->name('student.adaptiveLearning.questionDemo');

    Route::get('/student/quiz/{id}', [QuizController::class, 'takeQuiz'])->name('student.quiz');
    Route::get('/student/quiz/result', [StudentController::class, 'showQuizResult'])->name('student.quizResult');
    Route::post('/quiz/submit', [QuizController::class, 'submitQuiz'])->name('student.submitQuiz');

    // Secure Exam with Face Recognition
    Route::get('/student/secure-exam/{quizId}', [FaceRecognitionController::class, 'showExamVerification'])->name('student.secureExam');

    Route::get('/student/leaderboard', [StudentController::class, 'showLeaderboard'])->name('student.leaderboard');

    Route::get('/student/support', [StudentController::class, 'showSupport'])->name('student.support');
    Route::post('/student/support', [StudentController::class, 'submitSupport'])->name('student.support.submit');

    Route::get('/student/achievements', [StudentController::class, 'showAchievements'])->name('student.achievements');

    // Practice Questions Routes
    Route::prefix('student/practice')->name('student.practice.')->group(function () {
        Route::get('/course/{courseId}', [PracticeQuestionController::class, 'dashboard'])->name('dashboard');
        Route::get('/course/{courseId}/generate', [PracticeQuestionController::class, 'showGenerateForm'])->name('generate.form');
        Route::post('/course/{courseId}/generate', [PracticeQuestionController::class, 'generateQuestions'])->name('generate');
        Route::get('/course/{courseId}/session', [PracticeQuestionController::class, 'practiceSession'])->name('session');
        Route::get('/course/{courseId}/question/{questionId}', [PracticeQuestionController::class, 'showQuestion'])->name('question');
        Route::post('/course/{courseId}/question/{questionId}/answer', [PracticeQuestionController::class, 'submitAnswer'])->name('answer');
        Route::get('/course/{courseId}/results', [PracticeQuestionController::class, 'showResults'])->name('results');
        Route::delete('/course/{courseId}/reset', [PracticeQuestionController::class, 'resetQuestions'])->name('reset');

        // AJAX Routes
        Route::get('/course/{courseId}/questions', [PracticeQuestionController::class, 'getQuestions'])->name('questions.ajax');
        Route::get('/course/{courseId}/next-question', [PracticeQuestionController::class, 'getNextQuestion'])->name('next.question');
    });
});

Route::middleware(['auth','role:agent'])->group(function () {
    Route::get('/agent', [AgentController::class, 'index'])->name('agent.dashboard');
    Route::get('/agent/courses', [AgentController::class, 'showCourses'])->name('agent.courses');
    Route::get('/agent/reclamations', [AgentController::class, 'showReclamations'])->name('agent.reclamations');

    Route::get('/agent/reclamations', [AgentController::class, 'showReclamations'])->name('agent.reclamations');
    Route::get('/agent/reclamations/{id}/respond', [AgentController::class, 'respondReclamation'])->name('agent.respondReclamation');
    Route::post('/agent/reclamations/{id}/respond', [ReclamationController::class, 'submitReclamationResponse'])->name('agent.submitReclamationResponse');
});

// Teacher Routes
Route::middleware(['auth','role:teacher'])->group(function () {
    // Dashboard
    Route::get('/teacher', [TeacherController::class, 'index'])->name('teacher.dashboard');

    // Teacher Profile
    Route::get('/teacher/profile', [TeacherController::class, 'showProfile'])->name('teacher.profile');
    Route::post('/teacher/profile', [TeacherController::class, 'updateProfile'])->name('teacher.profile.update');
    Route::post('/teacher/profile/password', [TeacherController::class, 'updatePassword'])->name('teacher.profile.password');
    Route::post('/teacher/profile/image', [TeacherController::class, 'updateProfileImage'])->name('teacher.profile.image');

    // Courses (Legacy)
    Route::get('/teacher/courses', [TeacherController::class, 'showCourses'])->name('teacher.courses');
    Route::get('/teacher/courses/create', [TeacherController::class, 'createCourse'])->name('teacher.courses.create');
    Route::post('/teacher/courses', [\App\Http\Controllers\Teacher\CourseBuilderController::class, 'store'])->name('teacher.courses.store');

    // Course Builder (New Udemy-style system)
    Route::prefix('teacher/course-builder')->name('teacher.course-builder.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Teacher\CourseBuilderController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Teacher\CourseBuilderController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Teacher\CourseBuilderController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [\App\Http\Controllers\Teacher\CourseBuilderController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\Teacher\CourseBuilderController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\Teacher\CourseBuilderController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/stats', [\App\Http\Controllers\Teacher\CourseBuilderController::class, 'getStats'])->name('stats');

        // Sections
        Route::get('/{courseId}/sections/{sectionId}', [\App\Http\Controllers\Teacher\SectionController::class, 'show'])->name('sections.show');
        Route::post('/{courseId}/sections', [\App\Http\Controllers\Teacher\SectionController::class, 'store'])->name('sections.store');
        Route::put('/{courseId}/sections/{sectionId}', [\App\Http\Controllers\Teacher\SectionController::class, 'update'])->name('sections.update');
        Route::delete('/{courseId}/sections/{sectionId}', [\App\Http\Controllers\Teacher\SectionController::class, 'destroy'])->name('sections.destroy');
        Route::post('/{courseId}/sections/order', [\App\Http\Controllers\Teacher\SectionController::class, 'updateOrder'])->name('sections.order');
        Route::post('/{courseId}/sections/{sectionId}/toggle-publish', [\App\Http\Controllers\Teacher\SectionController::class, 'togglePublish'])->name('sections.toggle-publish');

        // Lessons
        Route::get('/{courseId}/sections/{sectionId}/lessons/{lessonId}', [\App\Http\Controllers\Teacher\LessonController::class, 'show'])->name('lessons.show');
        Route::post('/{courseId}/sections/{sectionId}/lessons', [\App\Http\Controllers\Teacher\LessonController::class, 'store'])->name('lessons.store');
        Route::put('/{courseId}/sections/{sectionId}/lessons/{lessonId}', [\App\Http\Controllers\Teacher\LessonController::class, 'update'])->name('lessons.update');
        Route::delete('/{courseId}/sections/{sectionId}/lessons/{lessonId}', [\App\Http\Controllers\Teacher\LessonController::class, 'destroy'])->name('lessons.destroy');
        Route::post('/{courseId}/sections/{sectionId}/lessons/order', [\App\Http\Controllers\Teacher\LessonController::class, 'updateOrder'])->name('lessons.order');
        Route::post('/{courseId}/sections/{sectionId}/lessons/{lessonId}/toggle-publish', [\App\Http\Controllers\Teacher\LessonController::class, 'togglePublish'])->name('lessons.toggle-publish');

        // Bulk publish actions
        Route::post('/{courseId}/publish-all', [\App\Http\Controllers\Teacher\CourseBuilderController::class, 'publishAll'])->name('publish-all');
    });

    // Video Upload Routes
    Route::post('/teacher/upload-video', [\App\Http\Controllers\Teacher\VideoUploadController::class, 'uploadVideo'])->name('teacher.upload-video');
    Route::delete('/teacher/delete-video', [\App\Http\Controllers\Teacher\VideoUploadController::class, 'deleteVideo'])->name('teacher.delete-video');
    Route::get('/teacher/video-info', [\App\Http\Controllers\Teacher\VideoUploadController::class, 'getVideoInfo'])->name('teacher.video-info');

    Route::get('/teacher/courses/{id}', function($id) {
        $course = \App\Models\Course::where('id', $id)
            ->where('creator_id', \Illuminate\Support\Facades\Auth::id())
            ->with('category')
            ->firstOrFail();

        $quizzes = \App\Models\Quiz::where('course_id', $id)->get();

        return view('teacher.courseDetails-updated', [
            'course' => $course,
            'quizzes' => $quizzes
        ]);
    })->name('teacher.courses.show');
    Route::get('/teacher/courses/{id}/edit', [CourseController::class, 'editCourse'])->name('teacher.courses.edit');
    Route::put('/teacher/courses/{id}', [CourseController::class, 'updateCourse'])->name('teacher.courses.update');
    Route::delete('/teacher/courses/{id}', [CourseController::class, 'deleteCourse'])->name('teacher.courses.delete');

    // Quizzes
    Route::get('/teacher/quizzes', [TeacherController::class, 'showQuizzes'])->name('teacher.quizzes');
    Route::get('/teacher/quizzes/create', [TeacherController::class, 'createQuiz'])->name('teacher.quizzes.create');
    Route::post('/teacher/quizzes', [QuizController::class, 'storeQuiz'])->name('teacher.quizzes.store');
    Route::get('/teacher/quizzes/{id}/edit', [QuizController::class, 'editQuiz'])->name('teacher.quizzes.edit');
    Route::put('/teacher/quizzes/{id}', [QuizController::class, 'updateQuiz'])->name('teacher.quizzes.update');
    Route::delete('/teacher/quizzes/{id}', [QuizController::class, 'deleteQuiz'])->name('teacher.quizzes.delete');

    // Quiz Questions
    Route::get('/teacher/quizzes/{quizId}/questions', [QuizController::class, 'showQuizQuestions'])->name('teacher.quizQuestions');
    Route::get('/teacher/quizzes/{quizId}/questions/create', [QuizController::class, 'createQuestion'])->name('teacher.createQuestion');
    Route::post('/teacher/quizzes/{quizId}/questions', [QuizController::class, 'storeQuestion'])->name('teacher.storeQuestion');
    Route::get('/teacher/questions/{id}/edit', [QuizController::class, 'editQuestion'])->name('teacher.editQuestion');
    Route::put('/teacher/questions/{id}', [QuizController::class, 'updateQuestion'])->name('teacher.updateQuestion');
    Route::delete('/teacher/questions/{id}', [QuizController::class, 'deleteQuestion'])->name('teacher.deleteQuestion');

    // AI Quiz Generation
    Route::get('/teacher/courses/{courseId}/generate-quiz', function($courseId) {
        $course = \App\Models\Course::where('id', $courseId)
            ->where('creator_id', \Illuminate\Support\Facades\Auth::id())
            ->firstOrFail();

        return view('teacher.generateAIQuiz-updated', [
            'course' => $course
        ]);
    })->name('teacher.generate-quiz');
    Route::post('/teacher/courses/{courseId}/generate-quiz', [QuizController::class, 'generateAIQuiz'])->name('teacher.generate-quiz.store');

    // Analytics
    Route::get('/teacher/analytics', [TeacherController::class, 'showAnalytics'])->name('teacher.analytics');
    Route::get('/teacher/analytics/course/{courseId}', [TeacherController::class, 'showCourseAnalytics'])->name('teacher.course-analytics');

    // Enrollment Management
    Route::prefix('teacher/enrollments')->name('teacher.enrollments.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Teacher\EnrollmentController::class, 'index'])->name('index');
        Route::post('/{courseId}/approve/{studentId}', [\App\Http\Controllers\Teacher\EnrollmentController::class, 'approve'])->name('approve');
        Route::post('/{courseId}/reject/{studentId}', [\App\Http\Controllers\Teacher\EnrollmentController::class, 'reject'])->name('reject');
        Route::get('/pending-count', [\App\Http\Controllers\Teacher\EnrollmentController::class, 'getPendingCount'])->name('pending-count');
        Route::get('/course/{courseId}/students', [\App\Http\Controllers\Teacher\EnrollmentController::class, 'showCourseStudents'])->name('course-students');
    });
});

// Temporary route to create test enrollment
Route::get('/test-enrollment', function () {
    $user = auth()->user();
    $course = \App\Models\Course::first();

    if ($user && $course) {
        // Check if already enrolled
        $existing = $user->enrolledCourses()->where('course_id', $course->id)->first();

        if (!$existing) {
            $user->enrolledCourses()->attach($course->id, [
                'progress' => 0,
                'completed' => false,
                'status' => 'pending'
            ]);
            return "Test enrollment created for course: " . $course->title;
        } else {
            return "Already enrolled in course: " . $course->title . " with status: " . $existing->pivot->status;
        }
    }

    return "No user or course found";
})->middleware('auth');