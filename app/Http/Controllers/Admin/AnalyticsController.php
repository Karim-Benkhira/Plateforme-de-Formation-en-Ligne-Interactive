<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\Reclamation;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Get total users count
        $totalUsers = User::count();
        
        // Get total courses count
        $totalCourses = Course::count();
        
        // Get completed quizzes count
        $completedQuizzes = QuizResult::count();
        
        // Get support tickets count
        $supportTickets = Reclamation::count();
        
        return view('admin.analytics', compact(
            'totalUsers',
            'totalCourses',
            'completedQuizzes',
            'supportTickets'
        ));
    }
}
