<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\Validator;

class UserController extends Controller
{
    public function showRegister(){
        return view('public.Auth.signup_enhanced');
    }

    public function showLogIn(){
        return view('public.Auth.login_enhanced');
    }

    public function showAbout(){
        if (auth()->check()) {
            $user = auth()->user();
            if ($user->role === 'teacher') {
                return view('about');
            }
        }
        return view('public.about-new');
    }

    public function showCourses(){
        // If user is logged in, redirect to their dashboard courses page
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.courses');
            } elseif ($user->role === 'teacher') {
                return redirect()->route('teacher.courses');
            } elseif ($user->role === 'user') {
                return redirect()->route('student.courses');
            }
        }

        // For guests, show the public courses page
        $courses = \App\Models\Course::with(['category', 'teacher'])
            ->where('is_published', true)
            ->get();

        // Get categories if the table exists
        $categories = [];
        if (class_exists('App\\Models\\Category')) {
            $categories = \App\Models\Category::all();
        }

        return view('public.courses', compact('courses', 'categories'));
    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:user,teacher',
        ]);

        if (!Validator::validateEmail($request->email)) {
            return redirect()->back()->with('error', 'Email already exists');
        }
        if (!Validator::validateUsername($request->name)) {
            return redirect()->back()->with('error', 'Username already exists');
        }
        if (!Validator::validatepassword($request->password)) {
            return redirect()->back()->with('error', 'Password must be at least 8 characters');
        }

        try {
            $user = new User();
            $user->username = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);

            // Check if there are any admin users in the database
            $adminCount = User::where('role', 'admin')->count();

            // Use the selected role (user or teacher)
            // Note: 'user' is the database value for students
            $user->role = $request->role === 'teacher' ? 'teacher' : 'user';

            // Log the registration
            $roleLabel = $request->role === 'teacher' ? 'teacher' : 'student';
            \Illuminate\Support\Facades\Log::info('User registered as ' . $roleLabel . ': ' . $request->email);

            $user->save();

            // For students, redirect to photo upload after login
            if ($user->role === 'user') {
                return redirect()->route('login')->with('success', 'Registration successful! After logging in, you\'ll need to upload a photo for exam verification.');
            }

            return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
        } catch (\Exception $e) {
            // Log the error
            \Illuminate\Support\Facades\Log::error('Registration error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred during registration. Please try again.');
        }
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check for too many login attempts
        $throttlingController = new \App\Http\Controllers\Auth\LoginThrottlingController();
        $throttlingController->checkLoginThrottling($request);

        $user = User::where('email', $request->email)->first();
        if(!$user){
            // Increment login attempts
            $throttlingController->incrementLoginAttempts($request);

            // Log failed login
            \App\Models\ActivityLog::log('auth.failed', 'Failed login attempt - Invalid email', [
                'email' => $request->email,
            ]);

            return redirect()->back()->with('error', 'The email or password you entered is incorrect. Please try again.');
        }

        if(!Hash::check($request->password, $user->password)){
            // Increment login attempts
            $throttlingController->incrementLoginAttempts($request);

            // Log failed login
            \App\Models\ActivityLog::log('auth.failed', 'Failed login attempt - Invalid password', [
                'email' => $request->email,
            ]);

            return redirect()->back()->with('error', 'The email or password you entered is incorrect. Please try again.');
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Clear login attempts
            $throttlingController->clearLoginAttempts($request);

            $user = Auth::user();

            if ($user->is_banned) {
                // Log banned user attempt
                \App\Models\ActivityLog::log('auth.banned', 'Banned user attempted to login', [
                    'user_id' => $user->id,
                ]);

                Auth::logout();
                return redirect()->route('login')->with('error', 'Your account is banned.');
            }

            // Log successful login
            \App\Models\ActivityLog::log('auth.login', 'Successful login');

            // Regenerate session
            $request->session()->regenerate();

            // Handle concurrent logins (previously in middleware)
            try {
                $currentSessionId = $request->session()->getId();

                if (\Illuminate\Support\Facades\Schema::hasTable('sessions') &&
                    \Illuminate\Support\Facades\Schema::hasColumn('sessions', 'user_id') &&
                    \Illuminate\Support\Facades\Schema::hasColumn('sessions', 'id')) {

                    // Get all sessions for this user
                    $sessions = \Illuminate\Support\Facades\DB::table('sessions')
                        ->where('user_id', $user->id)
                        ->where('id', '!=', $currentSessionId)
                        ->get();

                    // If there are other active sessions, log them out
                    if ($sessions->count() > 0) {
                        // Delete all other sessions
                        \Illuminate\Support\Facades\DB::table('sessions')
                            ->where('user_id', $user->id)
                            ->where('id', '!=', $currentSessionId)
                            ->delete();

                        // Log the activity
                        try {
                            \App\Models\ActivityLog::log('session.concurrent_login', 'Logged out from other devices due to concurrent login policy');
                        } catch (\Exception $e) {
                            // Silently fail if activity logging fails
                            \Illuminate\Support\Facades\Log::warning('Failed to log activity: ' . $e->getMessage());
                        }
                    }
                }
            } catch (\Exception $e) {
                // Log the error but don't interrupt the user experience
                \Illuminate\Support\Facades\Log::error('Session management error: ' . $e->getMessage());
            }

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'agent') {
                return redirect()->route('agent.dashboard');
            } elseif ($user->role === 'teacher') {
                return redirect()->route('teacher.dashboard');
            } else {
                // For students, check if they need to upload a photo
                if (!$user->hasStudentPhoto()) {
                    return redirect()->route('face-verification.photo-upload')
                        ->with('info', 'Please upload a photo to enable face verification for secure exams.');
                }
                return redirect()->route('student.dashboard');
            }
        }
    }

    /**
     * Handle GET requests to logout URL
     * This provides a user-friendly way to handle direct logout URL access
     *
     * Two approaches available:
     * 1. Confirmation page (more secure) - prevents accidental logouts
     * 2. Direct logout (more convenient) - immediately logs out user
     */
    public function handleGetLogout(Request $request)
    {
        // OPTION 1: Show confirmation page (more secure)
        // Uncomment the line below and comment out the return statement at the bottom
        // return view('auth.logout-confirm');

        // OPTION 2: Direct logout (more convenient) - CURRENTLY ACTIVE
        // This directly logs out the user when they access /logout via GET
        // This is safe because it requires authentication middleware
        return $this->LogOut($request);
    }

    public function LogOut(Request $request){
        try {
            // Get the user ID before logging out
            $userId = null;
            if (Auth::check()) {
                $userId = Auth::id();

                // Try to log the activity before logging out
                try {
                    \App\Models\ActivityLog::log('auth.logout', 'User logged out');
                } catch (\Exception $e) {
                    // Silently fail if activity logging fails
                    \Illuminate\Support\Facades\Log::warning('Failed to log logout activity: ' . $e->getMessage());
                }
            }

            // Logout the user
            Auth::logout();

            // Invalidate the session
            $request->session()->invalidate();

            // Regenerate the CSRF token
            $request->session()->regenerateToken();

            // Clean up any remaining sessions for this user
            if ($userId && \Illuminate\Support\Facades\Schema::hasTable('sessions')) {
                try {
                    \Illuminate\Support\Facades\DB::table('sessions')
                        ->where('user_id', $userId)
                        ->delete();
                } catch (\Exception $e) {
                    // Log but continue if session cleanup fails
                    \Illuminate\Support\Facades\Log::warning('Failed to clean up sessions: ' . $e->getMessage());
                }
            }

            return redirect()->route('login')->with('logout_success', 'You have been successfully logged out.');
        } catch (\Exception $e) {
            // Log the error
            \Illuminate\Support\Facades\Log::error('Logout error: ' . $e->getMessage());

            // Force logout even if there was an error
            Auth::logout();

            // Try to invalidate the session even if there was an error
            try {
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            } catch (\Exception $sessionError) {
                \Illuminate\Support\Facades\Log::error('Session invalidation error: ' . $sessionError->getMessage());
            }

            return redirect()->route('login')->with('logout_success', 'You have been logged out.');
        }
    }

    /**
     * Update the user's profile information.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string|max:500',
        ]);

        $user->username = $request->username;
        $user->email = $request->email;

        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image && file_exists(public_path('storage/profile_images/' . $user->profile_image))) {
                unlink(public_path('storage/profile_images/' . $user->profile_image));
            }

            // Store new image
            $imageName = time() . '.' . $request->profile_image->extension();
            $request->profile_image->storeAs('public/profile_images', $imageName);
            $user->profile_image = $imageName;
        }

        if ($request->has('bio')) {
            $user->bio = $request->bio;
        }

        $user->save();

        // Log the activity
        \App\Models\ActivityLog::log('profile.update', 'Updated profile information');

        return redirect()->route('profile.edit')->with('status', 'Profile updated successfully.');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Check if the current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The provided password does not match your current password.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Log the activity
        \App\Models\ActivityLog::log('password.update', 'Updated password');

        return redirect()->route('profile.edit')->with('status', 'Password updated successfully.');
    }
}
