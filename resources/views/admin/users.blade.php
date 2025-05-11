@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
<div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl shadow-lg p-6 mb-8">
    <div class="flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">User Management</h1>
            <p class="text-blue-100">Manage user accounts, roles, and permissions.</p>
        </div>
    </div>
</div>

<div class="data-card">
    <div class="flex justify-between items-center mb-6">
        <h2 class="section-title flex items-center m-0">
            <i class="fas fa-users text-blue-500 mr-2"></i>
            All Users
        </h2>

        <div class="flex space-x-2">
            <div class="relative">
                <input type="text" id="search-users" placeholder="Search users..." class="bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-200 w-64">
                <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
            </div>

            <select id="role-filter" class="bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-200">
                <option value="">All Roles</option>
                <option value="user">Students</option>
                <option value="teacher">Teachers</option>
                <option value="agent">Agents</option>
                <option value="admin">Admins</option>
            </select>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="w-16">ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th class="w-1/4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td class="font-medium">{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role === 'admin')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                <i class="fas fa-user-shield mr-1"></i> Admin
                            </span>
                        @elseif($user->role === 'teacher')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                <i class="fas fa-chalkboard-teacher mr-1"></i> Teacher
                            </span>
                        @elseif($user->role === 'agent')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                <i class="fas fa-headset mr-1"></i> Agent
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                <i class="fas fa-user-graduate mr-1"></i> Student
                            </span>
                        @endif
                    </td>
                    <td>
                        @if($user->is_banned)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                <i class="fas fa-ban mr-1"></i> Banned
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                <i class="fas fa-check-circle mr-1"></i> Active
                            </span>
                        @endif
                    </td>
                    <td>
                        <div class="flex items-center space-x-2">
                            @if($user->id == 1)
                                <span class="text-xs text-yellow-500 font-medium px-2 py-1 rounded border border-yellow-500">
                                    <i class="fas fa-lock mr-1"></i> Owner Account
                                </span>
                            @else
                                <form action="{{ route('admin.updateRole', $user->id) }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="role" class="bg-gray-700 border border-gray-600 rounded px-2 py-1 text-sm text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Student</option>
                                        <option value="teacher" {{ $user->role === 'teacher' ? 'selected' : '' }}>Teacher</option>
                                        <option value="agent" {{ $user->role === 'agent' ? 'selected' : '' }}>Agent</option>
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-user-tag mr-1"></i> Update
                                    </button>
                                </form>

                                @if($user->role !== 'admin')
                                    @if($user->is_banned)
                                        <form action="{{ route('admin.unbanUser', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fas fa-user-check mr-1"></i> Unban
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.banUser', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-user-slash mr-1"></i> Ban
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

@push('scripts')
<script>
    // Simple client-side filtering for users table
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-users');
        const roleFilter = document.getElementById('role-filter');
        const tableRows = document.querySelectorAll('.data-table tbody tr');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const roleValue = roleFilter.value.toLowerCase();

            tableRows.forEach(row => {
                const username = row.cells[1].textContent.toLowerCase();
                const email = row.cells[2].textContent.toLowerCase();
                const role = row.cells[3].textContent.toLowerCase();

                const matchesSearch = username.includes(searchTerm) || email.includes(searchTerm);
                const matchesRole = roleValue === '' || role.includes(roleValue);

                row.style.display = matchesSearch && matchesRole ? '' : 'none';
            });
        }

        if (searchInput && roleFilter) {
            searchInput.addEventListener('input', filterTable);
            roleFilter.addEventListener('change', filterTable);
        }
    });
</script>
@endpush
@endsection