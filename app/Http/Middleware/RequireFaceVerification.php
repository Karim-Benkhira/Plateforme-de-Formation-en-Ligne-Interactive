<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Quiz;

class RequireFaceVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Only apply to students
        if (!$user || !$user->hasRole('user')) {
            return $next($request);
        }

        // Get quiz ID from route parameter
        $quizId = $request->route('id') ?? $request->route('quizId');

        if (!$quizId) {
            return $next($request);
        }

        $quiz = Quiz::find($quizId);

        // If quiz doesn't exist or doesn't require face verification, continue
        if (!$quiz || !$quiz->requires_face_verification) {
            return $next($request);
        }

        // Check if user has uploaded a photo
        if (!$user->hasStudentPhoto()) {
            return redirect()->route('face-verification.photo-upload')
                ->with('error', 'You need to upload a photo before taking this secure exam.');
        }

        // Check if user has been verified for this exam in the current session
        $sessionKey = 'exam_verified_' . $quiz->id;
        $timeKey = 'exam_verified_at_' . $quiz->id;

        if (!session($sessionKey) || !session($timeKey)) {
            return redirect()->route('face-verification.exam', $quiz->id)
                ->with('info', 'Face verification is required before taking this exam.');
        }
        
        // Check if verification is still valid (within 5 minutes)
        $verifiedAt = session($timeKey);
        if (now()->diffInMinutes($verifiedAt) > 5) {
            // Clear expired verification
            session()->forget([$sessionKey, $timeKey]);
            
            return redirect()->route('face-verification.exam', $quiz->id)
                ->with('info', 'Face verification has expired. Please verify again.');
        }
        
        return $next($request);
    }
}
