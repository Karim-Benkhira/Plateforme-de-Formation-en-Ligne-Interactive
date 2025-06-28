<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RequireStudentPhoto
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        // Only apply to students (users with role 'user')
        if (!$user || !$user->hasRole('user')) {
            return $next($request);
        }
        
        // Allow access to photo upload routes and logout
        $allowedRoutes = [
            'face-verification.photo-upload',
            'face-verification.photo-upload.store',
            'face-verification.photo.delete',
            'logout',
            'profile.update',
            'profile.password',
            'profile.image'
        ];
        
        $currentRoute = $request->route()->getName();
        
        // Allow access to allowed routes
        if (in_array($currentRoute, $allowedRoutes)) {
            return $next($request);
        }
        
        // Allow AJAX requests for photo upload functionality
        if ($request->ajax() && str_contains($request->path(), 'face-verification')) {
            return $next($request);
        }
        
        // Check if student has uploaded a photo
        if (!$user->hasStudentPhoto()) {
            // If it's an AJAX request, return JSON response
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'error' => 'Photo upload required',
                    'message' => 'You must upload a photo before accessing the platform.',
                    'redirect' => route('face-verification.photo-upload')
                ], 403);
            }
            
            // For regular requests, redirect to photo upload
            return redirect()->route('face-verification.photo-upload')
                ->with('warning', 'You must upload a photo before accessing any part of the platform. This is required for secure exam verification.');
        }
        
        return $next($request);
    }
}
