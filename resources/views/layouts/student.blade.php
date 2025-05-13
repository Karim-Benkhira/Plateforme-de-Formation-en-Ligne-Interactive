<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Student Dashboard') - BrightPath</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
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
                        }
                    },
                    fontFamily: {
                        'sans': ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #111827;
            color: #f3f4f6;
        }

        /* Dashboard Styles */
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        .dashboard-sidebar {
            width: 280px;
            background-color: #1f2937;
            border-right: 1px solid #374151;
            transition: all 0.3s ease;
        }

        .dashboard-sidebar.collapsed {
            width: 80px;
        }

        .dashboard-content {
            flex: 1;
            background-color: #111827;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: #9ca3af;
            border-radius: 0.375rem;
            margin: 0.25rem 0.75rem;
            transition: all 0.2s ease;
        }

        .sidebar-link:hover {
            background-color: #374151;
            color: #f3f4f6;
        }

        .sidebar-link.active {
            background-color: #3b82f6;
            color: #ffffff;
        }

        .sidebar-link i {
            width: 1.5rem;
            text-align: center;
            margin-right: 1rem;
            font-size: 1.25rem;
        }

        .sidebar-link span {
            transition: opacity 0.3s ease;
        }

        .dashboard-sidebar.collapsed .sidebar-link span {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .dashboard-sidebar.collapsed .sidebar-link {
            padding: 0.75rem;
            justify-content: center;
        }

        .dashboard-sidebar.collapsed .sidebar-link i {
            margin-right: 0;
        }

        .course-card {
            background-color: #1f2937;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .stats-card {
            background-color: #1f2937;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .stats-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .stats-icon.primary {
            background-color: rgba(59, 130, 246, 0.2);
            color: #3b82f6;
        }

        .stats-icon.success {
            background-color: rgba(16, 185, 129, 0.2);
            color: #10b981;
        }

        .stats-icon.warning {
            background-color: rgba(245, 158, 11, 0.2);
            color: #f59e0b;
        }

        .stats-icon.danger {
            background-color: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #f3f4f6;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #374151;
        }

        .data-card {
            background-color: #1f2937;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>
<body>
    <div class="dashboard-container" x-data="{ sidebarOpen: true }">
        <!-- Sidebar -->
        <aside class="dashboard-sidebar" :class="{ 'collapsed': !sidebarOpen }">
            <div class="p-4 flex items-center justify-between">
                <a href="{{ route('student.dashboard') }}" class="flex items-center space-x-2">
                    <img src="{{ asset('images/logo.svg') }}" alt="BrightPath Logo" class="h-8 w-8">
                    <span class="text-white font-bold text-xl" x-show="sidebarOpen">BrightPath</span>
                </a>
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-400 hover:text-white focus:outline-none">
                    <i class="fas" :class="sidebarOpen ? 'fa-chevron-left' : 'fa-chevron-right'"></i>
                </button>
            </div>

            <div class="mt-6">
                <nav>
                    <a href="{{ route('student.dashboard') }}" class="sidebar-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span x-show="sidebarOpen">Dashboard</span>
                    </a>
                    <a href="{{ route('student.courses') }}" class="sidebar-link {{ request()->routeIs('student.courses') ? 'active' : '' }}">
                        <i class="fas fa-book"></i>
                        <span x-show="sidebarOpen">All Courses</span>
                    </a>
                    <a href="{{ route('student.myCourses') }}" class="sidebar-link {{ request()->routeIs('student.myCourses') ? 'active' : '' }}">
                        <i class="fas fa-graduation-cap"></i>
                        <span x-show="sidebarOpen">My Courses</span>
                    </a>
                    <a href="{{ route('student.progress') }}" class="sidebar-link {{ request()->routeIs('student.progress') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i>
                        <span x-show="sidebarOpen">My Progress</span>
                    </a>
                    <a href="{{ route('student.achievements') }}" class="sidebar-link {{ request()->routeIs('student.achievements') ? 'active' : '' }}">
                        <i class="fas fa-trophy"></i>
                        <span x-show="sidebarOpen">Achievements</span>
                    </a>
                    <a href="{{ route('student.leaderboard') }}" class="sidebar-link {{ request()->routeIs('student.leaderboard') ? 'active' : '' }}">
                        <i class="fas fa-medal"></i>
                        <span x-show="sidebarOpen">Leaderboard</span>
                    </a>
                    <a href="{{ route('student.support') }}" class="sidebar-link {{ request()->routeIs('student.support') ? 'active' : '' }}">
                        <i class="fas fa-headset"></i>
                        <span x-show="sidebarOpen">Support</span>
                    </a>

                    <div class="border-t border-gray-700 my-4"></div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="sidebar-link w-full text-left">
                            <i class="fas fa-sign-out-alt"></i>
                            <span x-show="sidebarOpen">Logout</span>
                        </button>
                    </form>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="dashboard-content">
            <!-- Top Navigation -->
            <header class="bg-gray-800 shadow-md">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center">
                        <h1 class="text-xl font-semibold text-white">@yield('title', 'Student Dashboard')</h1>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                                <span class="inline-flex items-center justify-center h-10 w-10 rounded-full overflow-hidden border-2 border-blue-500 shadow-md">
                                    @if(Auth::user()->profile_image)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="{{ Auth::user()->username }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="h-full w-full bg-blue-600 flex items-center justify-center text-white font-bold">
                                            {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                                        </div>
                                    @endif
                                </span>
                                <span class="text-gray-300 font-medium">{{ Auth::user()->username }}</span>
                                <svg class="h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-56 bg-gray-800 rounded-lg shadow-xl py-2 border border-gray-700 z-50">
                                <div class="px-4 py-3 border-b border-gray-700">
                                    <p class="text-sm text-gray-400">Signed in as</p>
                                    <p class="text-sm font-medium text-white truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('student.profile') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors flex items-center">
                                    <i class="fas fa-user-circle mr-2 text-blue-400"></i>
                                    My Profile
                                </a>
                                <div class="border-t border-gray-700 my-1"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors flex items-center">
                                        <i class="fas fa-sign-out-alt mr-2 text-red-400"></i>
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
