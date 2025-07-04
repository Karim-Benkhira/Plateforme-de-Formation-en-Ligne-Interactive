<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    /**
     * Get course performance data
     *
     * @param array $courseIds
     * @return array
     */
    public function getCoursePerformanceData(array $courseIds): array
    {
        try {
            $coursePerformance = DB::table('quiz_results')
                ->join('quizzes', 'quiz_results.quiz_id', '=', 'quizzes.id')
                ->whereIn('quizzes.course_id', $courseIds)
                ->select(
                    'quizzes.course_id',
                    DB::raw('COUNT(DISTINCT quiz_results.user_id) as student_count'),
                    DB::raw('COUNT(DISTINCT quiz_results.quiz_id) as quiz_count'),
                    DB::raw('AVG(quiz_results.score) as average_score')
                )
                ->groupBy('quizzes.course_id')
                ->get();

            // Get course names
            $courses = Course::whereIn('id', $courseIds)->pluck('title', 'id')->toArray();

            $result = [];
            foreach ($coursePerformance as $item) {
                $result[] = [
                    'course_id' => $item->course_id,
                    'course_name' => $courses[$item->course_id] ?? 'Unknown Course',
                    'student_count' => $item->student_count,
                    'quiz_count' => $item->quiz_count,
                    'average_score' => round($item->average_score, 2),
                ];
            }

            // Add courses with no data
            foreach ($courseIds as $courseId) {
                $exists = false;
                foreach ($result as $item) {
                    if ($item['course_id'] == $courseId) {
                        $exists = true;
                        break;
                    }
                }

                if (!$exists) {
                    $result[] = [
                        'course_id' => $courseId,
                        'course_name' => $courses[$courseId] ?? 'Unknown Course',
                        'student_count' => 0,
                        'quiz_count' => 0,
                        'average_score' => 0,
                    ];
                }
            }

            return $result;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error getting course performance data: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get student progress data
     *
     * @param array $courseIds
     * @return array
     */
    public function getStudentProgressData(array $courseIds): array
    {
        try {
            $studentProgress = DB::table('quiz_results')
                ->join('quizzes', 'quiz_results.quiz_id', '=', 'quizzes.id')
                ->join('users', 'quiz_results.user_id', '=', 'users.id')
                ->whereIn('quizzes.course_id', $courseIds)
                ->select(
                    'quiz_results.user_id',
                    'users.username',
                    DB::raw('COUNT(DISTINCT quiz_results.quiz_id) as completed_quizzes'),
                    DB::raw('AVG(quiz_results.score) as average_score')
                )
                ->groupBy('quiz_results.user_id', 'users.username')
                ->orderByDesc('average_score')
                ->limit(10)
                ->get();

            $result = [];
            foreach ($studentProgress as $item) {
                $result[] = [
                    'user_id' => $item->user_id,
                    'username' => $item->username,
                    'completed_quizzes' => $item->completed_quizzes,
                    'average_score' => round($item->average_score, 2),
                ];
            }

            return $result;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error getting student progress data: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get quiz performance data
     *
     * @param array $quizIds
     * @return array
     */
    public function getQuizPerformanceData(array $quizIds): array
    {
        try {
            $quizPerformance = DB::table('quiz_results')
                ->whereIn('quiz_id', $quizIds)
                ->select(
                    'quiz_id',
                    DB::raw('COUNT(DISTINCT user_id) as attempt_count'),
                    DB::raw('AVG(score) as average_score'),
                    DB::raw('MIN(score) as min_score'),
                    DB::raw('MAX(score) as max_score')
                )
                ->groupBy('quiz_id')
                ->get();

            // Get quiz names
            $quizzes = Quiz::whereIn('id', $quizIds)->pluck('name', 'id')->toArray();

            $result = [];
            foreach ($quizPerformance as $item) {
                // Calculate pass rate (percentage of scores >= 60)
                $passRate = 0;
                if ($item->attempt_count > 0) {
                    $passCount = DB::table('quiz_results')
                        ->where('quiz_id', $item->quiz_id)
                        ->where('score', '>=', 60)
                        ->count();
                    $passRate = ($passCount / $item->attempt_count) * 100;
                }

                $result[] = [
                    'quiz_id' => $item->quiz_id,
                    'quiz_name' => $quizzes[$item->quiz_id] ?? 'Unknown Quiz',
                    'attempt_count' => $item->attempt_count,
                    'average_score' => round($item->average_score, 2),
                    'min_score' => round($item->min_score, 2),
                    'max_score' => round($item->max_score, 2),
                    'pass_rate' => round($passRate, 2),
                ];
            }

            // Add quizzes with no data
            foreach ($quizIds as $quizId) {
                $exists = false;
                foreach ($result as $item) {
                    if ($item['quiz_id'] == $quizId) {
                        $exists = true;
                        break;
                    }
                }

                if (!$exists) {
                    $result[] = [
                        'quiz_id' => $quizId,
                        'quiz_name' => $quizzes[$quizId] ?? 'Unknown Quiz',
                        'attempt_count' => 0,
                        'average_score' => 0,
                        'min_score' => 0,
                        'max_score' => 0,
                        'pass_rate' => 0,
                    ];
                }
            }

            return $result;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error getting quiz performance data: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get student performance analytics
     *
     * @param User $student
     * @return array
     */
    public function getStudentPerformance(User $student)
    {
        // Get all quiz results for the student
        $quizResults = QuizResult::with(['quiz.course'])
            ->where('user_id', $student->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate overall statistics
        $totalQuizzes = $quizResults->count();
        $averageScore = $quizResults->avg('score') ?? 0;
        $highestScore = $quizResults->max('score') ?? 0;
        $lowestScore = $quizResults->min('score') ?? 0;

        // Calculate progress over time
        $progressData = $this->calculateProgressOverTime($quizResults);

        // Calculate performance by course
        $coursePerformance = $this->calculateCoursePerformance($quizResults);

        // Calculate strengths and weaknesses
        $strengthsWeaknesses = $this->calculateStrengthsWeaknesses($student);

        // Calculate recent activity
        $recentActivity = $this->getRecentActivity($student);

        return [
            'overall' => [
                'total_quizzes' => $totalQuizzes,
                'average_score' => round($averageScore, 2),
                'highest_score' => round($highestScore, 2),
                'lowest_score' => round($lowestScore, 2),
            ],
            'progress_data' => $progressData,
            'course_performance' => $coursePerformance,
            'strengths_weaknesses' => $strengthsWeaknesses,
            'recent_activity' => $recentActivity,
        ];
    }

    /**
     * Calculate progress over time
     *
     * @param Collection $quizResults
     * @return array
     */
    private function calculateProgressOverTime(Collection $quizResults)
    {
        $progressByWeek = $quizResults
            ->groupBy(function ($result) {
                return Carbon::parse($result->created_at)->startOfWeek()->format('Y-m-d');
            })
            ->map(function ($weekResults) {
                return [
                    'average_score' => round($weekResults->avg('score'), 2),
                    'count' => $weekResults->count(),
                ];
            });

        $labels = $progressByWeek->keys()->toArray();
        $data = $progressByWeek->values()->pluck('average_score')->toArray();
        $counts = $progressByWeek->values()->pluck('count')->toArray();

        return [
            'labels' => $labels,
            'data' => $data,
            'counts' => $counts,
        ];
    }

    /**
     * Calculate performance by course
     *
     * @param Collection $quizResults
     * @return array
     */
    private function calculateCoursePerformance(Collection $quizResults)
    {
        $coursePerformance = $quizResults
            ->groupBy('quiz.course.id')
            ->map(function ($courseResults, $courseId) {
                $course = $courseResults->first()->quiz->course;

                return [
                    'course_id' => $courseId,
                    'course_name' => $course->title,
                    'average_score' => round($courseResults->avg('score'), 2),
                    'highest_score' => round($courseResults->max('score'), 2),
                    'quiz_count' => $courseResults->count(),
                ];
            })
            ->sortByDesc('average_score')
            ->values()
            ->toArray();

        return $coursePerformance;
    }

    /**
     * Calculate strengths and weaknesses
     *
     * @param User $student
     * @return array
     */
    private function calculateStrengthsWeaknesses(User $student)
    {
        // This would typically involve analyzing question-level performance
        // For this implementation, we'll use course categories as a proxy

        $categoryPerformance = DB::table('quiz_results')
            ->join('quizzes', 'quiz_results.quiz_id', '=', 'quizzes.id')
            ->join('courses', 'quizzes.course_id', '=', 'courses.id')
            ->join('categories', 'courses.category_id', '=', 'categories.id')
            ->where('quiz_results.user_id', $student->id)
            ->select(
                'categories.id',
                'categories.name',
                DB::raw('AVG(quiz_results.score) as average_score'),
                DB::raw('COUNT(quiz_results.id) as attempt_count')
            )
            ->groupBy('categories.id', 'categories.name')
            ->having('attempt_count', '>=', 1)
            ->orderByDesc('average_score')
            ->get();

        $strengths = $categoryPerformance
            ->where('average_score', '>=', 70)
            ->take(3)
            ->map(function ($category) {
                return [
                    'category_id' => $category->id,
                    'category_name' => $category->name,
                    'average_score' => round($category->average_score, 2),
                ];
            })
            ->toArray();

        $weaknesses = $categoryPerformance
            ->where('average_score', '<', 70)
            ->sortBy('average_score')
            ->take(3)
            ->map(function ($category) {
                return [
                    'category_id' => $category->id,
                    'category_name' => $category->name,
                    'average_score' => round($category->average_score, 2),
                ];
            })
            ->toArray();

        return [
            'strengths' => $strengths,
            'weaknesses' => $weaknesses,
        ];
    }

    /**
     * Get recent activity
     *
     * @param User $student
     * @return array
     */
    private function getRecentActivity(User $student)
    {
        $recentResults = QuizResult::with(['quiz.course'])
            ->where('user_id', $student->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($result) {
                return [
                    'id' => $result->id,
                    'quiz_id' => $result->quiz_id,
                    'quiz_name' => $result->quiz->name,
                    'course_name' => $result->quiz->course->title,
                    'score' => round($result->score, 2),
                    'correct_answers' => $result->correct_answers,
                    'total_questions' => $result->answers_count,
                    'date' => $result->created_at->format('Y-m-d H:i'),
                ];
            })
            ->toArray();

        return $recentResults;
    }

    /**
     * Get instructor analytics
     *
     * @param User $instructor
     * @return array
     */
    public function getInstructorAnalytics(User $instructor)
    {
        // For this implementation, we'll assume the instructor has access to all courses
        // In a real application, you would filter by courses created by the instructor

        // Get all courses
        $courses = Course::withCount(['quizzes', 'contents'])->get();

        // Get all quiz results
        $quizResults = QuizResult::with(['quiz.course', 'user'])
            ->whereHas('quiz.course')
            ->get();

        // Calculate overall statistics
        $totalStudents = User::where('role', 'user')->count();
        $totalCourses = $courses->count();
        $totalQuizzes = $courses->sum('quizzes_count');
        $averageScore = $quizResults->avg('score') ?? 0;

        // Calculate course engagement
        $courseEngagement = $this->calculateCourseEngagement($courses, $quizResults);

        // Calculate student performance distribution
        $performanceDistribution = $this->calculatePerformanceDistribution($quizResults);

        // Calculate quiz difficulty
        $quizDifficulty = $this->calculateQuizDifficulty($quizResults);

        return [
            'overall' => [
                'total_students' => $totalStudents,
                'total_courses' => $totalCourses,
                'total_quizzes' => $totalQuizzes,
                'average_score' => round($averageScore, 2),
            ],
            'course_engagement' => $courseEngagement,
            'performance_distribution' => $performanceDistribution,
            'quiz_difficulty' => $quizDifficulty,
        ];
    }

    /**
     * Calculate course engagement
     *
     * @param Collection $courses
     * @param Collection $quizResults
     * @return array
     */
    private function calculateCourseEngagement(Collection $courses, Collection $quizResults)
    {
        $courseEngagement = $courses->map(function ($course) use ($quizResults) {
            $courseResults = $quizResults->filter(function ($result) use ($course) {
                return $result->quiz->course_id === $course->id;
            });

            $uniqueStudents = $courseResults->pluck('user_id')->unique()->count();
            $attemptCount = $courseResults->count();
            $completionRate = $course->quizzes_count > 0
                ? ($attemptCount / ($course->quizzes_count * $uniqueStudents)) * 100
                : 0;

            return [
                'course_id' => $course->id,
                'course_name' => $course->title,
                'student_count' => $uniqueStudents,
                'attempt_count' => $attemptCount,
                'completion_rate' => round($completionRate, 2),
                'content_count' => $course->contents_count,
            ];
        })
        ->sortByDesc('student_count')
        ->values()
        ->toArray();

        return $courseEngagement;
    }

    /**
     * Calculate performance distribution
     *
     * @param Collection $quizResults
     * @return array
     */
    private function calculatePerformanceDistribution(Collection $quizResults)
    {
        $ranges = [
            '0-20' => 0,
            '21-40' => 0,
            '41-60' => 0,
            '61-80' => 0,
            '81-100' => 0,
        ];

        foreach ($quizResults as $result) {
            $score = $result->score;

            if ($score <= 20) {
                $ranges['0-20']++;
            } elseif ($score <= 40) {
                $ranges['21-40']++;
            } elseif ($score <= 60) {
                $ranges['41-60']++;
            } elseif ($score <= 80) {
                $ranges['61-80']++;
            } else {
                $ranges['81-100']++;
            }
        }

        return [
            'labels' => array_keys($ranges),
            'data' => array_values($ranges),
        ];
    }

    /**
     * Calculate quiz difficulty
     *
     * @param Collection $quizResults
     * @return array
     */
    private function calculateQuizDifficulty(Collection $quizResults)
    {
        $quizDifficulty = $quizResults
            ->groupBy('quiz_id')
            ->map(function ($results, $quizId) {
                $quiz = $results->first()->quiz;
                $averageScore = $results->avg('score');
                $attemptCount = $results->count();

                // Calculate difficulty rating (inverse of average score)
                $difficultyRating = 100 - $averageScore;

                return [
                    'quiz_id' => $quizId,
                    'quiz_name' => $quiz->name,
                    'course_name' => $quiz->course->title,
                    'average_score' => round($averageScore, 2),
                    'difficulty_rating' => round($difficultyRating, 2),
                    'attempt_count' => $attemptCount,
                ];
            })
            ->sortByDesc('difficulty_rating')
            ->values()
            ->toArray();

        return $quizDifficulty;
    }
}
