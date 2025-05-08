@php
    use Illuminate\Support\Facades\Auth;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BrightPath - Interactive Learning Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body>
    <header x-data="{ mobileMenuOpen: false }" class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                        </svg>
                        <span class="text-blue-600 text-2xl font-bold">BrightPath</span>
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600" aria-label="Toggle menu">
                        <svg viewBox="0 0 24 24" class="h-6 w-6 fill-current">
                            <path x-show="!mobileMenuOpen" d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"></path>
                            <path x-show="mobileMenuOpen" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-1">
                    @if(Auth::check())
                        @if(Auth::user()->role === 'admin')
                            <a class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition duration-150" href="{{ route('admin.dashboard') }}">Dashboard</a>
                            <a class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition duration-150" href="{{ route('admin.users') }}">Users</a>
                            <a class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition duration-150" href="{{ route('admin.courses') }}">Courses</a>
                            <a class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition duration-150" href="{{ route('admin.categories') }}">Categories</a>
                            <a class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition duration-150" href="{{ route('admin.reclamations') }}">Reports</a>
                            <a class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition duration-150" href="{{ route('admin.quizzes') }}">Quizzes</a>
                        @elseif(Auth::user()->role === 'agent')
                            <a class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition duration-150" href="{{ route('agent.dashboard') }}">Dashboard</a>
                            <a class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition duration-150" href="{{ route('agent.reclamations') }}">Reclamations</a>
                        @elseif(Auth::user()->role === 'user')
                            <a class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition duration-150" href="{{ route('student.dashboard') }}">Dashboard</a>
                            <a class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition duration-150" href="{{ route('student.courses') }}">Courses</a>
                            <a class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition duration-150" href="{{ route('student.myCourses') }}">My Courses</a>
                            <a class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition duration-150" href="{{ route('student.leaderboard') }}">Leaderboard</a>
                            <a class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition duration-150" href="{{ route('student.achievements') }}">Achievements</a>
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition duration-150">
                                    <span>Account</span>
                                    <svg class="ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                                    <a href="{{ route('student.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">Profile</a>
                                    <a href="{{ route('student.support') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">Support</a>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">Logout</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if(Auth::user()->role !== 'user')
                            <form action="{{ route('logout') }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition duration-150">Logout</button>
                            </form>
                        @endif
                    @else
                        <a class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition duration-150" href="/">Home</a>
                        <a class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition duration-150" href="/about">About</a>
                        <a class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition duration-150" href="/courses">Courses</a>
                        <a class="px-4 py-2 rounded-md text-sm font-medium text-blue-600 border border-blue-500 hover:bg-blue-50 transition duration-150 ml-2" href="{{ route('login') }}">Login</a>
                        <a class="px-4 py-2 rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition duration-150" href="{{ route('register') }}">Register</a>
                    @endif
                </nav>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                @if(Auth::check())
                    @if(Auth::user()->role === 'admin')
                        <a class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <a class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50" href="{{ route('admin.users') }}">Users</a>
                        <a class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50" href="{{ route('admin.courses') }}">Courses</a>
                        <a class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50" href="{{ route('admin.categories') }}">Categories</a>
                        <a class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50" href="{{ route('admin.reclamations') }}">Reports</a>
                        <a class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50" href="{{ route('admin.quizzes') }}">Quizzes</a>
                    @elseif(Auth::user()->role === 'agent')
                        <a class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50" href="{{ route('agent.dashboard') }}">Dashboard</a>
                        <a class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50" href="{{ route('agent.reclamations') }}">Reclamations</a>
                    @elseif(Auth::user()->role === 'user')
                        <a class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50" href="{{ route('student.dashboard') }}">Dashboard</a>
                        <a class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50" href="{{ route('student.courses') }}">Courses</a>
                        <a class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50" href="{{ route('student.myCourses') }}">My Courses</a>
                        <a class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50" href="{{ route('student.leaderboard') }}">Leaderboard</a>
                        <a class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50" href="{{ route('student.achievements') }}">Achievements</a>
                        <a class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50" href="{{ route('student.profile') }}">Profile</a>
                        <a class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50" href="{{ route('student.support') }}">Support</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50">Logout</button>
                    </form>
                @else
                    <a class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50" href="/">Home</a>
                    <a class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50" href="/about">About</a>
                    <a class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50" href="/courses">Courses</a>
                    <a class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50" href="{{ route('login') }}">Login</a>
                    <a class="block px-3 py-2 rounded-md text-base font-medium text-white bg-blue-600 hover:bg-blue-700" href="{{ route('register') }}">Register</a>
                @endif
            </div>
        </div>
    </header>