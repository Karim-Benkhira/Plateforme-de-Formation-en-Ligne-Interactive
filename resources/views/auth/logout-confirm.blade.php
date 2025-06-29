<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Logout Confirmation</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <a href="{{ route('login') }}">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <!-- Logout Confirmation -->
            <div class="text-center">
                <div class="mb-4">
                    <svg class="mx-auto h-12 w-12 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>

                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                    Confirm Logout
                </h2>

                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                    Are you sure you want to log out of your account?
                </p>

                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <!-- Logout Form -->
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Yes, Logout
                        </button>
                    </form>

                    <!-- Cancel Button -->
                    <button onclick="history.back()" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 active:bg-gray-500 dark:active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancel
                    </button>
                </div>

                <!-- Alternative: Go to Dashboard -->
                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                        Or return to your dashboard:
                    </p>
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-500 text-sm font-medium">
                                Go to Admin Dashboard
                            </a>
                        @elseif(Auth::user()->role === 'teacher')
                            <a href="{{ route('teacher.dashboard') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-500 text-sm font-medium">
                                Go to Teacher Dashboard
                            </a>
                        @else
                            <a href="{{ route('student.dashboard') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-500 text-sm font-medium">
                                Go to Student Dashboard
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-6 text-center">
            <p class="text-xs text-gray-500 dark:text-gray-400">
                {{ config('app.name') }} &copy; {{ date('Y') }}
            </p>
        </div>
    </div>

    <script>
        // Auto-focus on the logout button for keyboard navigation
        document.addEventListener('DOMContentLoaded', function() {
            const logoutButton = document.querySelector('button[type="submit"]');
            if (logoutButton) {
                logoutButton.focus();
            }
        });

        // Handle escape key to cancel
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                history.back();
            }
        });
    </script>
</body>
</html>
