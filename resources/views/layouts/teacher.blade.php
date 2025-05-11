<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Teacher Dashboard - Bright Path')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/theme-colors.css') }}" rel="stylesheet">
    <link href="{{ asset('css/teacher-dashboard.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        secondary: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            200: '#ddd6fe',
                            300: '#c4b5fd',
                            400: '#a78bfa',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                            800: '#5b21b6',
                            900: '#4c1d95',
                        },
                    }
                }
            }
        }
    </script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    @stack('styles')
</head>
<body class="bg-gray-900 font-sans antialiased">
    <div class="teacher-dashboard min-h-screen">
        <!-- Header -->
        <header class="dashboard-header bg-gray-800 rounded-lg shadow-lg mb-6">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center py-3">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="{{ route('teacher.dashboard') }}" class="dashboard-logo text-primary-400 text-2xl font-bold">
                            Bright Path
                        </a>
                    </div>

                    <!-- Navigation -->
                    <nav class="dashboard-nav hidden md:flex items-center space-x-6">
                        <a href="{{ route('teacher.dashboard') }}" class="dashboard-nav-link {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">Dashboard</a>
                        <a href="{{ route('teacher.courses') }}" class="dashboard-nav-link {{ request()->routeIs('teacher.courses*') ? 'active' : '' }}">Courses</a>
                        <a href="{{ route('teacher.quizzes') }}" class="dashboard-nav-link {{ request()->routeIs('teacher.quizzes*') ? 'active' : '' }}">Quizzes</a>
                        <a href="{{ route('teacher.analytics') }}" class="dashboard-nav-link {{ request()->routeIs('teacher.analytics*') ? 'active' : '' }}">Analytics</a>
                        <a href="{{ route('teacher.profile') }}" class="dashboard-nav-link {{ request()->routeIs('teacher.profile') ? 'active' : '' }}">Profile</a>
                        <a href="{{ url('/about') }}" class="dashboard-nav-link">About</a>
                    </nav>

                    <!-- User Menu -->
                    <div class="flex items-center">
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                                <span class="inline-flex items-center justify-center h-10 w-10 rounded-full overflow-hidden border-2 border-blue-500 shadow-md">
                                    @if(Auth::user()->profile_image)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="{{ Auth::user()->username }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="h-full w-full bg-primary-600 flex items-center justify-center text-white font-bold">
                                            {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                                        </div>
                                    @endif
                                </span>
                                <span class="text-gray-300 hidden md:inline-block font-medium">{{ Auth::user()->username }}</span>
                                <svg class="h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-56 bg-gray-800 rounded-lg shadow-xl py-2 border border-gray-700 z-50">
                                <div class="px-4 py-3 border-b border-gray-700">
                                    <p class="text-sm text-gray-400">Signed in as</p>
                                    <p class="text-sm font-medium text-white truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('teacher.profile') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    My Profile
                                </a>
                                <a href="{{ route('teacher.profile') }}#password" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                    </svg>
                                    Change Password
                                </a>
                                <div class="border-t border-gray-700 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="md:hidden">
                        <button type="button" class="text-gray-400 hover:text-white focus:outline-none" id="mobile-menu-button">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="md:hidden hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="{{ route('teacher.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">Dashboard</a>
                    <a href="{{ route('teacher.courses') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">Courses</a>
                    <a href="{{ route('teacher.quizzes') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">Quizzes</a>
                    <a href="{{ route('teacher.analytics') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">Analytics</a>
                    <a href="{{ route('teacher.profile') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">Profile</a>
                    <a href="{{ url('/about') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">About</a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-4">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="mt-12 py-6 text-center text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} Bright Path Learning Platform. All rights reserved.</p>
        </footer>
    </div>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }
    </script>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

    @stack('scripts')
</body>
</html>
