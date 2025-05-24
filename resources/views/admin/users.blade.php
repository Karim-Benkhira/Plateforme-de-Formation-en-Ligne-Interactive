@extends('layouts.admin')

@section('title', 'Manage Users')

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

    .admin-card-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(245, 158, 11, 0.15);
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
                <i class="fas fa-users-cog mr-3 text-yellow-300"></i>
                User Management
            </h1>
            <p class="text-yellow-100 opacity-90">Manage user accounts, roles, and permissions.</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-3">
            <div class="bg-white/10 backdrop-blur-sm border border-white/20 text-white px-4 py-2 rounded-lg shadow-lg flex items-center">
                <i class="fas fa-user-plus mr-2 text-yellow-300"></i>
                <span class="text-sm font-medium">Total Users: {{ count($users) }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Users Table Card -->
<div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-yellow-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden admin-card-hover">
    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-yellow-600/5 to-pink-600/5"></div>

    <div class="relative">
        <!-- Table Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <h2 class="text-xl font-bold text-white flex items-center">
                <div class="bg-yellow-900/70 text-yellow-400 rounded-lg p-2 mr-3 shadow-inner shadow-yellow-950/50">
                    <i class="fas fa-users"></i>
                </div>
                <span>All Users</span>
            </h2>

            <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-r from-yellow-600/20 to-pink-600/20 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-200"></div>
                    <div class="relative bg-gray-900 border border-gray-700 rounded-lg flex items-center overflow-hidden">
                        <input type="text" id="search-users" placeholder="Search users..."
                            class="bg-transparent border-0 px-4 py-2.5 focus:outline-none text-gray-200 w-full placeholder-gray-500">
                        <div class="px-3 text-yellow-400">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                </div>

                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-r from-yellow-600/20 to-pink-600/20 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-200"></div>
                    <div class="relative">
                        <select id="role-filter"
                            class="bg-gray-900 border border-gray-700 rounded-lg px-4 py-2.5 focus:outline-none text-gray-200 appearance-none pr-10 w-full">
                            <option value="">All Roles</option>
                            <option value="user">Students</option>
                            <option value="teacher">Teachers</option>
                            <option value="agent">Agents</option>
                            <option value="admin">Admins</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-yellow-400">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-xl border border-gray-700/50 shadow-inner bg-gray-900/50">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-800/80">
                        <th class="px-4 py-3 text-gray-400 font-medium text-left border-b border-gray-700/50 w-16">ID</th>
                        <th class="px-4 py-3 text-gray-400 font-medium text-left border-b border-gray-700/50">Username</th>
                        <th class="px-4 py-3 text-gray-400 font-medium text-left border-b border-gray-700/50">Email</th>
                        <th class="px-4 py-3 text-gray-400 font-medium text-left border-b border-gray-700/50">Role</th>
                        <th class="px-4 py-3 text-gray-400 font-medium text-left border-b border-gray-700/50">Status</th>
                        <th class="px-4 py-3 text-gray-400 font-medium text-left border-b border-gray-700/50 w-1/4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr class="border-b border-gray-800/80 hover:bg-gray-800/50 transition-all duration-200">
                        <td class="px-4 py-4 text-gray-300">{{ $user->id }}</td>
                        <td class="px-4 py-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center mr-3 text-gray-300">
                                    <i class="fas fa-user text-sm"></i>
                                </div>
                                <span class="font-medium text-white">{{ $user->username }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-gray-300">{{ $user->email }}</td>
                        <td class="px-4 py-4">
                            @if($user->role === 'admin')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-900/50 text-yellow-300 border border-yellow-700/50">
                                    <i class="fas fa-crown mr-1.5"></i> Admin
                                </span>
                            @elseif($user->role === 'teacher')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-900/50 text-blue-300 border border-blue-700/50">
                                    <i class="fas fa-chalkboard-teacher mr-1.5"></i> Teacher
                                </span>
                            @elseif($user->role === 'agent')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-900/50 text-orange-300 border border-orange-700/50">
                                    <i class="fas fa-headset mr-1.5"></i> Agent
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-900/50 text-purple-300 border border-purple-700/50">
                                    <i class="fas fa-user-graduate mr-1.5"></i> Student
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            @if($user->is_banned)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-900/50 text-red-300 border border-red-700/50">
                                    <i class="fas fa-ban mr-1.5"></i> Banned
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-900/50 text-green-300 border border-green-700/50">
                                    <i class="fas fa-check-circle mr-1.5"></i> Active
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2 flex-wrap">
                                @if($user->id == 1)
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-yellow-900/30 text-yellow-300 border border-yellow-700/50">
                                        <i class="fas fa-lock mr-1.5"></i> Owner Account
                                    </span>
                                @else
                                    <form action="{{ route('admin.updateRole', $user->id) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PUT')
                                        <div class="relative">
                                            <select name="role" class="bg-gray-800 border border-gray-700 rounded-lg px-3 py-1.5 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none pr-8">
                                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Student</option>
                                                <option value="teacher" {{ $user->role === 'teacher' ? 'selected' : '' }}>Teacher</option>
                                                <option value="agent" {{ $user->role === 'agent' ? 'selected' : '' }}>Agent</option>
                                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                            </select>
                                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-400">
                                                <i class="fas fa-chevron-down text-xs"></i>
                                            </div>
                                        </div>
                                        <button type="submit" class="bg-yellow-900/50 hover:bg-yellow-800 text-yellow-300 border border-yellow-700/50 rounded-lg px-3 py-1.5 text-sm font-medium transition-colors duration-200 flex items-center">
                                            <i class="fas fa-user-tag mr-1.5"></i> Update
                                        </button>
                                    </form>

                                    @if($user->role !== 'admin')
                                        @if($user->is_banned)
                                            <form action="{{ route('admin.unbanUser', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="bg-green-900/50 hover:bg-green-800 text-green-300 border border-green-700/50 rounded-lg px-3 py-1.5 text-sm font-medium transition-colors duration-200 flex items-center">
                                                    <i class="fas fa-user-check mr-1.5"></i> Unban
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.banUser', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="bg-red-900/50 hover:bg-red-800 text-red-300 border border-red-700/50 rounded-lg px-3 py-1.5 text-sm font-medium transition-colors duration-200 flex items-center">
                                                    <i class="fas fa-user-slash mr-1.5"></i> Ban
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Enhanced client-side filtering for users table
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-users');
        const roleFilter = document.getElementById('role-filter');
        const tableRows = document.querySelectorAll('table tbody tr');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const roleValue = roleFilter.value.toLowerCase();

            let visibleCount = 0;

            tableRows.forEach(row => {
                // Get text content from the username cell (including the username text, not the icon)
                const usernameCell = row.querySelector('td:nth-child(2)');
                const username = usernameCell.textContent.trim().toLowerCase();

                // Get email from the third cell
                const email = row.querySelector('td:nth-child(3)').textContent.trim().toLowerCase();

                // Get role from the fourth cell
                const roleCell = row.querySelector('td:nth-child(4)');
                const role = roleCell.textContent.trim().toLowerCase();

                const matchesSearch = username.includes(searchTerm) || email.includes(searchTerm);
                const matchesRole = roleValue === '' || role.includes(roleValue);

                if (matchesSearch && matchesRole) {
                    row.style.display = '';
                    visibleCount++;

                    // Add a subtle highlight effect for matching search terms
                    if (searchTerm !== '') {
                        // Reset any previous highlights
                        row.classList.add('bg-yellow-900/10');
                        setTimeout(() => {
                            row.classList.remove('bg-yellow-900/10');
                        }, 300);
                    }
                } else {
                    row.style.display = 'none';
                }
            });
        }

        if (searchInput && roleFilter) {
            // Add input event for real-time filtering as user types
            searchInput.addEventListener('input', filterTable);

            // Add focus effect
            searchInput.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-yellow-500/50');
            });

            searchInput.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-yellow-500/50');
            });

            // Filter when role selection changes
            roleFilter.addEventListener('change', filterTable);

            // Add focus effect for role filter
            roleFilter.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-yellow-500/50');
            });

            roleFilter.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-yellow-500/50');
            });
        }
    });
</script>
@endpush
@endsection