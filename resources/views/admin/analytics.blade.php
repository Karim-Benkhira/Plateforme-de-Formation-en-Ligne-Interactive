@extends('layouts.admin')

@section('title', 'Platform Analytics')

@push('styles')
<style>
    :root {
        /* Admin Color Scheme - Yellow/Pink */
        --admin-primary: #f59e0b;
        --admin-primary-dark: #d97706;
        --admin-primary-light: #fbbf24;
        --admin-secondary: #ec4899;
        --admin-secondary-dark: #db2777;
        --admin-secondary-light: #f472b6;
        --admin-accent: #fbbf24;
        --admin-accent-dark: #f59e0b;
        --admin-bg-primary: #1f2937;
        --admin-bg-secondary: #111827;
        --admin-text-primary: #f9fafb;
        --admin-text-secondary: #d1d5db;
        --admin-border: #374151;
    }

    @keyframes pulse-slow {
        0%, 100% {
            opacity: 0.2;
        }
        50% {
            opacity: 0;
        }
    }

    @keyframes admin-glow {
        0%, 100% {
            box-shadow: 0 0 20px rgba(245, 158, 11, 0.3);
        }
        50% {
            box-shadow: 0 0 30px rgba(245, 158, 11, 0.5);
        }
    }

    .animate-pulse-slow {
        animation: pulse-slow 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    .admin-glow {
        animation: admin-glow 2s ease-in-out infinite;
    }

    .bg-grid-white {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23FFFFFF' fill-opacity='0.1'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .admin-gradient-bg {
        background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%);
    }

    /* Stats card hover effect */
    .stats-card {
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }

    .stats-card::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.1), transparent);
        transform: translateX(-100%);
        transition: transform 0.6s ease;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
    }

    .stats-card:hover::after {
        transform: translateX(100%);
    }

    /* Chart container styles */
    .chart-container {
        position: relative;
        transition: all 0.3s ease;
    }

    .chart-container:hover {
        transform: scale(1.02);
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="admin-gradient-bg rounded-xl shadow-2xl p-6 mb-8 border border-yellow-500/30 relative overflow-hidden admin-glow">
    <div class="absolute inset-0 bg-grid-white/[0.05] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-yellow-500/10 to-pink-500/10"></div>
    <div class="relative flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2 flex items-center">
                <i class="fas fa-chart-line mr-3 text-yellow-300"></i>
                Platform Analytics
            </h1>
            <p class="text-yellow-100 opacity-90">Comprehensive insights into platform performance and user engagement</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('admin.dashboard') }}" class="group bg-white/10 backdrop-blur-sm border border-white/20 text-white hover:bg-yellow-500/20 font-semibold py-3 px-5 rounded-lg shadow-lg transition-all duration-300 inline-flex items-center hover:shadow-yellow-500/30 hover:shadow-xl">
                <i class="fas fa-arrow-left mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                <span>Back to Dashboard</span>
            </a>
        </div>
    </div>
</div>

<!-- Overview Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Users -->
    <div class="stats-card bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-yellow-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-yellow-600/5 to-yellow-800/5"></div>
        <div class="relative flex items-center">
            <div class="w-12 h-12 rounded-lg bg-yellow-900/70 text-yellow-400 flex items-center justify-center mr-4 shadow-inner shadow-yellow-950/50">
                <i class="fas fa-users text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Total Users</p>
                <p class="text-white text-2xl font-bold">{{ $totalUsers ?? 0 }}</p>
            </div>
            <div class="ml-auto text-yellow-400">
                <i class="fas fa-arrow-up text-sm mr-1"></i>
                <span class="text-sm font-medium">12%</span>
            </div>
        </div>
    </div>

    <!-- Active Courses -->
    <div class="stats-card bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-pink-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-pink-600/5 to-pink-800/5"></div>
        <div class="relative flex items-center">
            <div class="w-12 h-12 rounded-lg bg-pink-900/70 text-pink-400 flex items-center justify-center mr-4 shadow-inner shadow-pink-950/50">
                <i class="fas fa-book text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Active Courses</p>
                <p class="text-white text-2xl font-bold">{{ $totalCourses ?? 0 }}</p>
            </div>
            <div class="ml-auto text-pink-400">
                <i class="fas fa-arrow-up text-sm mr-1"></i>
                <span class="text-sm font-medium">8%</span>
            </div>
        </div>
    </div>

    <!-- Completed Quizzes -->
    <div class="stats-card bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-orange-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-orange-600/5 to-orange-800/5"></div>
        <div class="relative flex items-center">
            <div class="w-12 h-12 rounded-lg bg-orange-900/70 text-orange-400 flex items-center justify-center mr-4 shadow-inner shadow-orange-950/50">
                <i class="fas fa-clipboard-check text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Completed Quizzes</p>
                <p class="text-white text-2xl font-bold">{{ $completedQuizzes ?? 0 }}</p>
            </div>
            <div class="ml-auto text-orange-400">
                <i class="fas fa-arrow-up text-sm mr-1"></i>
                <span class="text-sm font-medium">15%</span>
            </div>
        </div>
    </div>

    <!-- Support Tickets -->
    <div class="stats-card bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-red-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-red-600/5 to-red-800/5"></div>
        <div class="relative flex items-center">
            <div class="w-12 h-12 rounded-lg bg-red-900/70 text-red-400 flex items-center justify-center mr-4 shadow-inner shadow-red-950/50">
                <i class="fas fa-ticket-alt text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Support Tickets</p>
                <p class="text-white text-2xl font-bold">{{ $supportTickets ?? 0 }}</p>
            </div>
            <div class="ml-auto text-red-400">
                <i class="fas fa-arrow-down text-sm mr-1"></i>
                <span class="text-sm font-medium">5%</span>
            </div>
        </div>
    </div>
</div>

<!-- Main Analytics Content -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Column -->
    <div class="lg:col-span-2 space-y-8">
        <!-- User Growth Chart -->
        <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-yellow-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden">
            <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-yellow-600/5 to-yellow-800/5"></div>

            <div class="relative">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="bg-yellow-900/70 text-yellow-400 rounded-lg p-2 mr-3 shadow-inner shadow-yellow-950/50">
                            <i class="fas fa-users"></i>
                        </div>
                        <h2 class="text-xl font-bold text-white">User Growth</h2>
                    </div>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 bg-gray-800 hover:bg-gray-700 text-gray-300 rounded-lg text-sm transition-colors">Week</button>
                        <button class="px-3 py-1 bg-yellow-900/50 text-yellow-300 border border-yellow-700/50 rounded-lg text-sm">Month</button>
                        <button class="px-3 py-1 bg-gray-800 hover:bg-gray-700 text-gray-300 rounded-lg text-sm transition-colors">Year</button>
                    </div>
                </div>

                <div class="chart-container h-80">
                    <canvas id="userGrowthChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Course Engagement -->
        <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-pink-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden">
            <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-pink-600/5 to-pink-800/5"></div>

            <div class="relative">
                <div class="flex items-center mb-6">
                    <div class="bg-pink-900/70 text-pink-400 rounded-lg p-2 mr-3 shadow-inner shadow-pink-950/50">
                        <i class="fas fa-book"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Top Courses</h2>
                </div>

                <div class="space-y-4">
                    <!-- Course Item 1 -->
                    <div class="bg-gray-800/50 rounded-lg p-4 border border-gray-700/50 hover:bg-gray-800 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-yellow-500 to-pink-600 flex items-center justify-center text-white font-bold mr-3 shadow-md relative overflow-hidden">
                                    <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:8px_8px]"></div>
                                    <i class="fas fa-code relative"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-white">Web Development Fundamentals</h3>
                                    <p class="text-sm text-gray-400">125 students enrolled</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold text-white">92%</div>
                                <div class="text-sm text-purple-400">Completion Rate</div>
                            </div>
                        </div>
                        <div class="mt-3 bg-gray-900/50 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-purple-500 to-indigo-500 h-full rounded-full" style="width: 92%"></div>
                        </div>
                    </div>

                    <!-- Course Item 2 -->
                    <div class="bg-gray-800/50 rounded-lg p-4 border border-gray-700/50 hover:bg-gray-800 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-pink-500 to-orange-600 flex items-center justify-center text-white font-bold mr-3 shadow-md relative overflow-hidden">
                                    <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:8px_8px]"></div>
                                    <i class="fas fa-paint-brush relative"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-white">UI/UX Design Principles</h3>
                                    <p class="text-sm text-gray-400">98 students enrolled</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold text-white">87%</div>
                                <div class="text-sm text-blue-400">Completion Rate</div>
                            </div>
                        </div>
                        <div class="mt-3 bg-gray-900/50 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-500 to-cyan-500 h-full rounded-full" style="width: 87%"></div>
                        </div>
                    </div>

                    <!-- Course Item 3 -->
                    <div class="bg-gray-800/50 rounded-lg p-4 border border-gray-700/50 hover:bg-gray-800 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-orange-500 to-yellow-600 flex items-center justify-center text-white font-bold mr-3 shadow-md relative overflow-hidden">
                                    <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:8px_8px]"></div>
                                    <i class="fas fa-chart-pie relative"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-white">Data Science Essentials</h3>
                                    <p class="text-sm text-gray-400">76 students enrolled</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold text-white">78%</div>
                                <div class="text-sm text-green-400">Completion Rate</div>
                            </div>
                        </div>
                        <div class="mt-3 bg-gray-900/50 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-full rounded-full" style="width: 78%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="space-y-8">
        <!-- User Distribution -->
        <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-orange-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden">
            <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-orange-600/5 to-orange-800/5"></div>

            <div class="relative">
                <div class="flex items-center mb-6">
                    <div class="bg-orange-900/70 text-orange-400 rounded-lg p-2 mr-3 shadow-inner shadow-orange-950/50">
                        <i class="fas fa-user-tag"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">User Distribution</h2>
                </div>

                <div class="chart-container h-64">
                    <canvas id="userDistributionChart"></canvas>
                </div>

                <div class="grid grid-cols-3 gap-4 mt-6">
                    <div class="bg-gray-800/50 rounded-lg p-3 border border-gray-700/50 text-center">
                        <div class="text-blue-400 mb-1"><i class="fas fa-user-graduate"></i></div>
                        <div class="text-lg font-bold text-white">65%</div>
                        <div class="text-xs text-gray-400">Students</div>
                    </div>
                    <div class="bg-gray-800/50 rounded-lg p-3 border border-gray-700/50 text-center">
                        <div class="text-green-400 mb-1"><i class="fas fa-chalkboard-teacher"></i></div>
                        <div class="text-lg font-bold text-white">30%</div>
                        <div class="text-xs text-gray-400">Teachers</div>
                    </div>
                    <div class="bg-gray-800/50 rounded-lg p-3 border border-gray-700/50 text-center">
                        <div class="text-yellow-400 mb-1"><i class="fas fa-user-shield"></i></div>
                        <div class="text-lg font-bold text-white">5%</div>
                        <div class="text-xs text-gray-400">Admins</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Support Tickets -->
        <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-red-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden">
            <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-red-600/5 to-red-800/5"></div>

            <div class="relative">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="bg-red-900/70 text-red-400 rounded-lg p-2 mr-3 shadow-inner shadow-red-950/50">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <h2 class="text-xl font-bold text-white">Recent Tickets</h2>
                    </div>
                    <a href="{{ route('admin.reclamations') }}" class="text-red-400 hover:text-red-300 transition-colors text-sm flex items-center">
                        View All <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <div class="space-y-3">
                    <!-- Ticket Item 1 -->
                    <div class="bg-gray-800/50 rounded-lg p-3 border border-gray-700/50 hover:bg-gray-800 transition-colors">
                        <div class="flex items-start">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-yellow-500 to-pink-600 flex items-center justify-center text-white font-bold mr-3 shadow-md relative overflow-hidden flex-shrink-0">
                                <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:8px_8px]"></div>
                                <span class="relative">J</span>
                            </div>
                            <div class="flex-grow">
                                <h3 class="font-medium text-white text-sm">Course video not loading properly</h3>
                                <p class="text-xs text-gray-400 mt-1 line-clamp-1">I'm having trouble accessing the video content in Module 3...</p>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-900/50 text-yellow-300 border border-yellow-700/50">
                                        <i class="fas fa-clock mr-1 text-xs"></i> Pending
                                    </span>
                                    <span class="text-xs text-gray-500">2 hours ago</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ticket Item 2 -->
                    <div class="bg-gray-800/50 rounded-lg p-3 border border-gray-700/50 hover:bg-gray-800 transition-colors">
                        <div class="flex items-start">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-pink-500 to-orange-600 flex items-center justify-center text-white font-bold mr-3 shadow-md relative overflow-hidden flex-shrink-0">
                                <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:8px_8px]"></div>
                                <span class="relative">M</span>
                            </div>
                            <div class="flex-grow">
                                <h3 class="font-medium text-white text-sm">Quiz results not showing</h3>
                                <p class="text-xs text-gray-400 mt-1 line-clamp-1">I completed the quiz but can't see my results or feedback...</p>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-900/50 text-green-300 border border-green-700/50">
                                        <i class="fas fa-check-circle mr-1 text-xs"></i> Resolved
                                    </span>
                                    <span class="text-xs text-gray-500">1 day ago</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ticket Item 3 -->
                    <div class="bg-gray-800/50 rounded-lg p-3 border border-gray-700/50 hover:bg-gray-800 transition-colors">
                        <div class="flex items-start">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-orange-500 to-yellow-600 flex items-center justify-center text-white font-bold mr-3 shadow-md relative overflow-hidden flex-shrink-0">
                                <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:8px_8px]"></div>
                                <span class="relative">S</span>
                            </div>
                            <div class="flex-grow">
                                <h3 class="font-medium text-white text-sm">Payment issue with course enrollment</h3>
                                <p class="text-xs text-gray-400 mt-1 line-clamp-1">I was charged twice for the same course enrollment...</p>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-900/50 text-yellow-300 border border-yellow-700/50">
                                        <i class="fas fa-clock mr-1 text-xs"></i> Pending
                                    </span>
                                    <span class="text-xs text-gray-500">3 days ago</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Platform Health -->
        <div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-green-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden">
            <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-green-600/5 to-green-800/5"></div>

            <div class="relative">
                <div class="flex items-center mb-6">
                    <div class="bg-green-900/70 text-green-400 rounded-lg p-2 mr-3 shadow-inner shadow-green-950/50">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Platform Health</h2>
                </div>

                <div class="space-y-4">
                    <!-- Server Uptime -->
                    <div class="bg-gray-800/50 rounded-lg p-4 border border-gray-700/50">
                        <div class="flex items-center justify-between mb-2">
                            <div class="text-sm font-medium text-gray-300">Server Uptime</div>
                            <div class="text-sm font-medium text-green-400">99.9%</div>
                        </div>
                        <div class="bg-gray-900/50 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-full rounded-full" style="width: 99.9%"></div>
                        </div>
                    </div>

                    <!-- Response Time -->
                    <div class="bg-gray-800/50 rounded-lg p-4 border border-gray-700/50">
                        <div class="flex items-center justify-between mb-2">
                            <div class="text-sm font-medium text-gray-300">Avg. Response Time</div>
                            <div class="text-sm font-medium text-blue-400">245ms</div>
                        </div>
                        <div class="bg-gray-900/50 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-500 to-cyan-500 h-full rounded-full" style="width: 85%"></div>
                        </div>
                    </div>

                    <!-- Error Rate -->
                    <div class="bg-gray-800/50 rounded-lg p-4 border border-gray-700/50">
                        <div class="flex items-center justify-between mb-2">
                            <div class="text-sm font-medium text-gray-300">Error Rate</div>
                            <div class="text-sm font-medium text-red-400">0.2%</div>
                        </div>
                        <div class="bg-gray-900/50 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-red-500 to-pink-500 h-full rounded-full" style="width: 0.2%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set global Chart.js options for dark theme
        Chart.defaults.color = '#94a3b8'; // text color
        Chart.defaults.borderColor = '#334155'; // border color

        // User Growth Chart
        const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
        new Chart(userGrowthCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Students',
                    data: [120, 150, 180, 220, 270, 310, 350, 390, 420, 450, 480, 520],
                    borderColor: 'rgb(245, 158, 11)', // yellow-500
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Teachers',
                    data: [20, 25, 30, 35, 45, 55, 65, 75, 85, 95, 105, 115],
                    borderColor: 'rgb(236, 72, 153)', // pink-500
                    backgroundColor: 'rgba(236, 72, 153, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(17, 24, 39, 0.9)',
                        titleFont: {
                            size: 14
                        },
                        bodyFont: {
                            size: 13
                        },
                        padding: 12,
                        borderColor: 'rgba(75, 85, 99, 0.3)',
                        borderWidth: 1
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(75, 85, 99, 0.2)'
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });

        // User Distribution Chart
        const userDistributionCtx = document.getElementById('userDistributionChart').getContext('2d');
        new Chart(userDistributionCtx, {
            type: 'doughnut',
            data: {
                labels: ['Students', 'Teachers', 'Admins'],
                datasets: [{
                    data: [65, 30, 5],
                    backgroundColor: [
                        'rgba(56, 189, 248, 0.7)', // blue-400 (students)
                        'rgba(34, 197, 94, 0.7)', // green-500 (teachers)
                        'rgba(245, 158, 11, 0.7)' // yellow-500 (admins)
                    ],
                    borderColor: [
                        'rgb(56, 189, 248)', // blue-400 (students)
                        'rgb(34, 197, 94)', // green-500 (teachers)
                        'rgb(245, 158, 11)' // yellow-500 (admins)
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(17, 24, 39, 0.9)',
                        titleFont: {
                            size: 14
                        },
                        bodyFont: {
                            size: 13
                        },
                        padding: 12,
                        borderColor: 'rgba(75, 85, 99, 0.3)',
                        borderWidth: 1
                    }
                },
                cutout: '70%'
            }
        });
    });
</script>
@endpush