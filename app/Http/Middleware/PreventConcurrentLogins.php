<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class PreventConcurrentLogins
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip this middleware for logout route
        if ($request->is('logout') || $request->is('*/logout')) {
            return $next($request);
        }

        // Check if user is authenticated
        if (Auth::check()) {
            try {
                $user = Auth::user();
                $currentSessionId = Session::getId();

                // Log the current session for debugging
                Log::info('Current session: ' . $currentSessionId . ' for user: ' . $user->id);

                // Check if sessions table exists and has the expected structure
                if ($this->canManageSessions()) {
                    // Get all sessions for this user
                    $sessions = DB::table('sessions')
                        ->where('user_id', $user->id)
                        ->where('id', '!=', $currentSessionId)
                        ->get();

                    Log::info('Found ' . $sessions->count() . ' other sessions for user: ' . $user->id);

                    // If there are other active sessions, log them out
                    if ($sessions->count() > 0) {
                        // Delete all other sessions
                        DB::table('sessions')
                            ->where('user_id', $user->id)
                            ->where('id', '!=', $currentSessionId)
                            ->delete();

                        // Log the activity
                        $this->logActivity('session.concurrent_login', 'Logged out from other devices due to concurrent login policy');
                    }
                }
            } catch (\Exception $e) {
                // Log the error but don't interrupt the user experience
                Log::error('Session management error: ' . $e->getMessage());
            }
        }

        return $next($request);
    }

    /**
     * Check if we can manage sessions
     *
     * @return bool
     */
    private function canManageSessions(): bool
    {
        try {
            return Schema::hasTable('sessions') &&
                   Schema::hasColumn('sessions', 'user_id') &&
                   Schema::hasColumn('sessions', 'id');
        } catch (\Exception $e) {
            Log::error('Error checking sessions table: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Log an activity
     *
     * @param string $type
     * @param string $description
     * @return void
     */
    private function logActivity(string $type, string $description): void
    {
        try {
            if (class_exists('\App\Models\ActivityLog')) {
                \App\Models\ActivityLog::log($type, $description);
            }
        } catch (\Exception $e) {
            // Silently fail if activity logging fails
            Log::warning('Failed to log activity: ' . $e->getMessage());
        }
    }
}
