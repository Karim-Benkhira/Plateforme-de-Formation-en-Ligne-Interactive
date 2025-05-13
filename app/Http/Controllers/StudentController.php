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
        $results = QuizResult::with(['quiz.course.creator', 'quiz.course.category'])
            ->where('user_id', $userId)
            ->get();

        $courses = $results
            ->groupBy(function($result) {
                return $result->quiz->course->id;
            })
            ->map(function($courseResults) {
                return $courseResults->sortByDesc('created_at')->first();
            });

        return view('student.MyCourses', ['courses' => $courses]);
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

        return view('student.achievements', compact('achievements', 'totalScore', 'quizzesTaken'));
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

        return view('student.progress', compact(
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

    public function showCourse($id) {
        $course = Course::with(['contents', 'quizzes'])->findOrFail($id);
        $isEnrolled = false;

        if (auth()->check()) {
            $user = auth()->user();
            $isEnrolled = $user->enrolledCourses()->where('course_id', $id)->exists();
        }

        return view('student.courseDetails-new', compact('course', 'isEnrolled'));
    }

    public function enrollCourse($id) {
        $course = Course::findOrFail($id);
        $user = auth()->user();

        // Check if already enrolled
        if (!$user->enrolledCourses()->where('course_id', $id)->exists()) {
            $user->enrolledCourses()->attach($id, [
                'progress' => 0,
                'completed' => false
            ]);

            // Log activity if the model exists
            if (class_exists('App\\Models\\ActivityLog')) {
                \App\Models\ActivityLog::create([
                    'user_id' => $user->id,
                    'type' => 'course',
                    'description' => "Enrolled in course: {$course->title}",
                ]);
            }

            return redirect()->route('student.showCourse', $id)->with('success', 'You have successfully enrolled in this course!');
        }

        return redirect()->route('student.showCourse', $id)->with('info', 'You are already enrolled in this course.');
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
}
