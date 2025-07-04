<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\QuizResult;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Reclamation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StudentController extends UserController
{
    public function index(){
        return view('student.dashboard-new');
    }

    public function showCourses(){
        $courses = Course::with(['category', 'teacher'])->get();

        // Get categories if the table exists
        $categories = [];
        if (class_exists('App\\Models\\Category')) {
            $categories = \App\Models\Category::all();
        }

        return view('student.courses-new', compact('courses', 'categories'));
    }

    public function showMyCourses(){
        $userId = auth()->id();
        $user = auth()->user();

        // Get all enrolled courses for the user (regardless of approval status)
        $enrolledCourses = $user->enrolledCourses()
            ->with(['category', 'creator', 'quizzes'])
            ->get();

        $courses = collect();

        foreach ($enrolledCourses as $course) {
            // Get the latest quiz result for this course if any
            $latestQuizResult = QuizResult::where('user_id', $userId)
                ->whereHas('quiz', function($query) use ($course) {
                    $query->where('course_id', $course->id);
                })
                ->with('quiz')
                ->latest()
                ->first();

            if ($latestQuizResult) {
                // If there's a quiz result, use it and add enrollment status
                $latestQuizResult->enrollment_status = $course->pivot->status;
                $latestQuizResult->enrollment_date = $course->pivot->created_at;
                $courses->push($latestQuizResult);
            } else {
                // Create a mock result for display (even if no quiz exists)
                $firstQuiz = $course->quizzes->first();

                $mockResult = new \stdClass();
                $mockResult->id = null;
                $mockResult->score = 0;
                $mockResult->correct_answers = 0;
                $mockResult->answers_count = 1;
                $mockResult->created_at = $course->pivot->created_at;
                $mockResult->enrollment_status = $course->pivot->status;
                $mockResult->enrollment_date = $course->pivot->created_at;

                if ($firstQuiz) {
                    $mockResult->quiz = (object) [
                        'id' => $firstQuiz->id,
                        'course' => $course
                    ];
                } else {
                    // Create a mock quiz object if no quiz exists
                    $mockResult->quiz = (object) [
                        'id' => null,
                        'course' => $course
                    ];
                }

                $courses->push($mockResult);
            }
        }

        return view('student.myCourses-new', ['courses' => $courses]);
    }

    public function showProfile(){
        $user = auth()->user();
        return view('student.profile-new', compact('user'));
    }

    public function showLeaderboard(){
        $leaders = User::select('users.id', 'users.username')
            ->leftJoin('quiz_results', 'users.id', '=', 'quiz_results.user_id')
            ->selectRaw('COALESCE(SUM(quiz_results.score),0) as total_score')
            ->selectRaw('COUNT(quiz_results.id) as quizzes_count')
            ->groupBy('users.id', 'users.username')
            ->orderByDesc('total_score')
            ->limit(10)
            ->get();

        return view('student.leaderboard', compact('leaders'));
    }

    public function showSupport()
    {
        $user = auth()->user();
        $reclamations = Reclamation::where('user_id', $user->id)->orderByDesc('created_at')->get();
        return view('student.support', compact('reclamations'));
    }

    public function submitSupport(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);
        $user = auth()->user();
        Reclamation::create([
            'user_id' => $user->id,
            'message' => $request->message,
            'status' => 'pending',
        ]);
        return back()->with('success', 'Your request has been submitted!');
    }

    public function showQuiz(){
        return view('student.quiz');
    }

    public function showQuizResult(){
        return view('student.QuizResults');
    }

    public function showCourseContent(){
        return view('student.courseContent');
    }

    public function showAchievements()
    {
        $user = auth()->user();

        $bestResults = QuizResult::where('user_id', $user->id)
            ->select('quiz_id', \DB::raw('MAX(score) as max_score'))
            ->groupBy('quiz_id')
            ->get();

        $totalScore = $bestResults->sum('max_score');
        $quizzesTaken = $bestResults->count();

        $achievements = [
            [
                'title' => 'Getting Started',
                'desc' => 'Score at least 50 points in total.',
                'unlocked' => $totalScore >= 50,
                'tier' => 'bronze',
                'icon' => '🥉',
            ],
            [
                'title' => 'First Steps',
                'desc' => 'Complete your first quiz.',
                'unlocked' => $quizzesTaken >= 1,
                'tier' => 'bronze',
                'icon' => '🥉',
            ],
            [
                'title' => 'Scorer',
                'desc' => 'Score at least 200 points in total.',
                'unlocked' => $totalScore >= 200,
                'tier' => 'silver',
                'icon' => '🥈',
            ],
            [
                'title' => 'Quiz Explorer',
                'desc' => 'Complete 5 different quizzes.',
                'unlocked' => $quizzesTaken >= 5,
                'tier' => 'silver',
                'icon' => '🥈',
            ],
            [
                'title' => 'Gold Scorer',
                'desc' => 'Score at least 500 points in total.',
                'unlocked' => $totalScore >= 500,
                'tier' => 'gold',
                'icon' => '🥇',
            ],
            [
                'title' => 'Quiz Veteran',
                'desc' => 'Complete 10 different quizzes.',
                'unlocked' => $quizzesTaken >= 10,
                'tier' => 'gold',
                'icon' => '🥇',
            ],
            [
                'title' => 'Diamond Legend',
                'desc' => 'Score 1000+ points and complete 20 quizzes.',
                'unlocked' => $totalScore >= 1000 && $quizzesTaken >= 20,
                'tier' => 'diamond',
                'icon' => '💎',
            ],
        ];

        return view('student.achievements-new', compact('achievements', 'totalScore', 'quizzesTaken'));
    }

    public function showProgress(){
        $user = auth()->user();

        // Get enrolled courses count
        $enrolledCount = 0;
        if (method_exists($user, 'enrolledCourses')) {
            $enrolledCount = $user->enrolledCourses()->count();
        } else {
            // Fallback: Get courses from quiz results
            $enrolledCount = QuizResult::where('user_id', $user->id)
                ->select('quiz_id')
                ->join('quizzes', 'quiz_results.quiz_id', '=', 'quizzes.id')
                ->select('course_id')
                ->distinct()
                ->count();
        }

        // Get completed courses count
        $completedCount = 0;
        if (method_exists($user, 'completedCourses')) {
            $completedCount = $user->completedCourses()->count();
        } else {
            // For demo purposes, assume 30% of enrolled courses are completed
            $completedCount = max(0, round($enrolledCount * 0.3));
        }

        // Calculate overall progress
        $overallProgress = $enrolledCount > 0 ? round(($completedCount / $enrolledCount) * 100) : 0;

        // Get course progress data
        $courseProgress = [];

        // Check if we have the course_user table with progress
        if (Schema::hasTable('course_user')) {
            $userCourses = DB::table('course_user')
                ->where('user_id', $user->id)
                ->join('courses', 'course_user.course_id', '=', 'courses.id')
                ->leftJoin('categories', 'courses.category_id', '=', 'categories.id')
                ->select('courses.id', 'courses.title', 'categories.name as category', 'course_user.progress')
                ->get();

            foreach ($userCourses as $course) {
                $courseProgress[] = [
                    'id' => $course->id,
                    'title' => $course->title,
                    'category' => $course->category ?? 'General',
                    'progress' => $course->progress,
                    'time_spent' => rand(1, 20), // Random time spent for demo
                    'score' => rand(60, 100) // Random score for demo
                ];
            }
        } else {
            // Demo data if no real data exists
            $courses = Course::take(3)->get();

            foreach ($courses as $course) {
                $courseProgress[] = [
                    'id' => $course->id,
                    'title' => $course->title ?? $course->name,
                    'category' => $course->category->name ?? 'General',
                    'progress' => rand(10, 100),
                    'time_spent' => rand(1, 20),
                    'score' => rand(60, 100)
                ];
            }
        }

        // Activity data for chart (last 7 days)
        $activityData = [
            'labels' => [],
            'values' => []
        ];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('M d');
            $activityData['labels'][] = $date;
            $activityData['values'][] = rand(0, 5); // Random hours spent for demo
        }

        // Quiz performance data for chart
        $quizData = [
            rand(1, 5),  // Excellent
            rand(3, 8),  // Good
            rand(2, 6),  // Average
            rand(0, 3)   // Needs Improvement
        ];

        // Skills acquired
        $skills = [
            [
                'name' => 'Programming',
                'level' => 'Advanced',
                'icon' => 'code',
                'color' => 'blue'
            ],
            [
                'name' => 'Data Analysis',
                'level' => 'Intermediate',
                'icon' => 'chart-bar',
                'color' => 'green'
            ],
            [
                'name' => 'Web Design',
                'level' => 'Beginner',
                'icon' => 'palette',
                'color' => 'purple'
            ],
            [
                'name' => 'Mathematics',
                'level' => 'Advanced',
                'icon' => 'calculator',
                'color' => 'yellow'
            ],
            [
                'name' => 'Machine Learning',
                'level' => 'Intermediate',
                'icon' => 'brain',
                'color' => 'red'
            ]
        ];

        return view('student.progress-new', compact(
            'enrolledCount',
            'completedCount',
            'overallProgress',
            'courseProgress',
            'activityData',
            'quizData',
            'skills'
        ));
    }

    public function showQuizRules(){
        return view('student.quizRules');
    }

    /**
     * Show secure exam page - redirects to face verification if needed
     */
    public function showSecureExam($id)
    {
        $quiz = \App\Models\Quiz::with(['course', 'questions'])->findOrFail($id);

        // Check if user is enrolled in the course
        $user = auth()->user();
        $isEnrolled = $quiz->course->users()
            ->where('user_id', $user->id)
            ->where('status', 'approved')
            ->exists();

        if (!$isEnrolled) {
            return redirect()->route('student.courses')
                ->with('error', 'You must be enrolled in this course to take the exam.');
        }

        // If quiz requires face verification, redirect to verification page
        if ($quiz->requires_face_verification) {
            // Check if user has uploaded a photo
            if (!$user->hasStudentPhoto()) {
                return redirect()->route('face-verification.photo-upload')
                    ->with('error', 'You need to upload a photo before taking this secure exam.');
            }

            // Redirect to face verification page
            return redirect()->route('face-verification.exam', $quiz->id)
                ->with('info', 'Face verification is required for this secure exam.');
        }

        // If no face verification required, show the secure exam page
        return view('student.secure-exam', compact('quiz'));
    }

    public function showCourse($id) {
        $course = Course::with([
            'contents',
            'quizzes',
            'sections' => function($query) {
                $query->where('is_published', true)->orderBy('order_index');
            },
            'sections.lessons' => function($query) {
                $query->where('is_published', true)->orderBy('order_index');
            },
            'category',
            'teacher'
        ])->findOrFail($id);

        $isEnrolled = false;
        $enrollmentStatus = null;
        $userProgress = [];
        $courseProgress = 0;
        $totalLessons = 0;
        $completedLessons = 0;
        $canTakeQuiz = false;

        if (auth()->check()) {
            $user = auth()->user();
            $enrollment = $user->enrolledCourses()->where('course_id', $id)->first();

            if ($enrollment) {
                $enrollmentStatus = $enrollment->pivot->status;
                $isEnrolled = ($enrollmentStatus === 'approved');
            }

            if ($isEnrolled) {
                // Get user progress for all lessons (new system)
                $lessonIds = [];
                foreach ($course->sections as $section) {
                    foreach ($section->lessons as $lesson) {
                        $lessonIds[] = $lesson->id;
                        $totalLessons++;
                    }
                }

                // Also count old system contents as lessons
                $contentIds = [];
                foreach ($course->contents as $content) {
                    $contentIds[] = 'content_' . $content->id; // Prefix to distinguish from lessons
                    $totalLessons++;
                }

                // Get progress for new system lessons
                if (!empty($lessonIds)) {
                    $progressRecords = \App\Models\LessonProgress::where('user_id', $user->id)
                        ->whereIn('lesson_id', $lessonIds)
                        ->get()
                        ->keyBy('lesson_id');

                    foreach ($lessonIds as $lessonId) {
                        $progress = $progressRecords->get($lessonId);
                        $userProgress[$lessonId] = [
                            'is_completed' => $progress ? $progress->is_completed : false,
                            'progress_percentage' => $progress ? $progress->progress_percentage : 0,
                            'last_position' => $progress ? $progress->last_position : 0,
                        ];

                        if ($progress && $progress->is_completed) {
                            $completedLessons++;
                        }
                    }
                }

                // For old system contents, we'll simulate progress (since there's no lesson_progress table for contents)
                // We'll use a simple session-based tracking for now
                foreach ($course->contents as $content) {
                    $contentKey = 'content_' . $content->id;
                    $isContentCompleted = session()->get("content_completed_{$user->id}_{$content->id}", false);

                    $userProgress[$contentKey] = [
                        'is_completed' => $isContentCompleted,
                        'progress_percentage' => $isContentCompleted ? 100 : 0,
                        'last_position' => 0,
                    ];

                    if ($isContentCompleted) {
                        $completedLessons++;
                    }
                }

                // Calculate course progress
                $courseProgress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;

                // Check if user can take quiz (must complete all lessons)
                $canTakeQuiz = $courseProgress >= 100;

                // Debug information
                \Log::info('Course Progress Debug DETAILED', [
                    'course_id' => $id,
                    'user_id' => $user->id,
                    'total_lessons' => $totalLessons,
                    'completed_lessons' => $completedLessons,
                    'course_progress' => $courseProgress,
                    'lesson_ids' => $lessonIds ?? [],
                    'content_ids' => $contentIds ?? [],
                    'user_progress_keys' => array_keys($userProgress),
                    'user_progress_details' => $userProgress,
                    'sections_count' => $course->sections->count(),
                    'contents_count' => $course->contents->count(),
                    'calculation' => "($completedLessons / $totalLessons) * 100 = $courseProgress"
                ]);
            }
        }

        return view('student.courseDetails-new', compact(
            'course',
            'isEnrolled',
            'enrollmentStatus',
            'userProgress',
            'courseProgress',
            'totalLessons',
            'completedLessons',
            'canTakeQuiz'
        ));
    }

    public function enrollCourse($id) {
        $course = Course::findOrFail($id);
        $user = auth()->user();

        // Check if already has any enrollment record (pending, approved, or rejected)
        $existingEnrollment = $user->enrolledCourses()->where('course_id', $id)->first();

        if ($existingEnrollment) {
            $status = $existingEnrollment->pivot->status;

            if ($status === 'pending') {
                return redirect()->route('student.showCourse', $id)->with('info', 'Your enrollment request is pending teacher approval.');
            } elseif ($status === 'approved') {
                return redirect()->route('student.showCourse', $id)->with('info', 'You are already enrolled in this course.');
            } elseif ($status === 'rejected') {
                return redirect()->route('student.showCourse', $id)->with('error', 'Your enrollment request was rejected by the teacher.');
            }
        }

        // Create new enrollment request with pending status
        $user->enrolledCourses()->attach($id, [
            'progress' => 0,
            'completed' => false,
            'status' => 'pending'
        ]);

        // Log activity if the model exists
        if (class_exists('App\\Models\\ActivityLog')) {
            \App\Models\ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'course.enroll.request',
                'description' => "Requested enrollment in course: {$course->title}",
            ]);
        }

        return redirect()->route('student.showCourse', $id)->with('success', 'Enrollment request sent! Please wait for teacher approval.');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->username = $request->username;
        $user->email = $request->email;

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image && file_exists(storage_path('app/public/' . $user->profile_image))) {
                unlink(storage_path('app/public/' . $user->profile_image));
            }

            // Store new image
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $imagePath;
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Old password is incorrect.'])->withInput();
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('password_success', 'Password updated successfully!');
    }

    /**
     * Mark lesson as completed
     */
    public function markLessonCompleted(Request $request, $courseId, $lessonId)
    {
        $user = auth()->user();
        $course = \App\Models\Course::findOrFail($courseId);

        // Check if user is enrolled and approved
        $enrollment = $user->enrolledCourses()->where('course_id', $courseId)->first();
        if (!$enrollment || $enrollment->pivot->status !== 'approved') {
            return response()->json(['error' => 'Not enrolled or not approved for this course'], 403);
        }

        // Update or create lesson progress
        $progress = \App\Models\LessonProgress::updateOrCreate([
            'user_id' => $user->id,
            'lesson_id' => $lessonId,
        ], [
            'is_completed' => true,
            'progress_percentage' => 100,
            'completed_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lesson completed successfully!',
            'progress' => $progress
        ]);
    }

    /**
     * Update lesson progress
     */
    public function updateLessonProgress(Request $request, $courseId, $lessonId)
    {
        $user = auth()->user();
        $course = \App\Models\Course::findOrFail($courseId);

        // Check if user is enrolled and approved
        $enrollment = $user->enrolledCourses()->where('course_id', $courseId)->first();
        if (!$enrollment || $enrollment->pivot->status !== 'approved') {
            return response()->json(['error' => 'Not enrolled or not approved for this course'], 403);
        }

        $progress = \App\Models\LessonProgress::updateOrCreate([
            'user_id' => $user->id,
            'lesson_id' => $lessonId,
        ], [
            'progress_percentage' => $request->input('progress', 0),
            'last_position' => $request->input('position', 0),
            'is_completed' => $request->input('progress', 0) >= 100,
            'completed_at' => $request->input('progress', 0) >= 100 ? now() : null,
        ]);

        return response()->json([
            'success' => true,
            'progress' => $progress
        ]);
    }

    /**
     * Mark content (old system) as completed
     */
    public function markContentCompleted(Request $request, $courseId, $contentId)
    {
        $user = auth()->user();
        $course = \App\Models\Course::findOrFail($courseId);

        // Check if user is enrolled and approved
        $enrollment = $user->enrolledCourses()->where('course_id', $courseId)->first();
        if (!$enrollment || $enrollment->pivot->status !== 'approved') {
            return response()->json(['error' => 'Not enrolled or not approved for this course'], 403);
        }

        // Mark content as completed in session
        session()->put("content_completed_{$user->id}_{$contentId}", true);

        return response()->json([
            'success' => true,
            'message' => 'Content completed successfully!'
        ]);
    }
}
