@extends('layouts.admin')

@section('title', 'Activity Logs')

@section('content')
<div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl shadow-lg p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Activity Logs</h1>
            <p class="text-blue-100">View and manage system activity logs.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <button type="button" id="filterButton" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-200 inline-flex items-center">
                <i class="fas fa-filter mr-2"></i> Filter
            </button>

            <form action="{{ route('admin.activity-logs.clear') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear all activity logs? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-200 inline-flex items-center">
                    <i class="fas fa-trash-alt mr-2"></i> Clear All
                </button>
            </form>
        </div>
    </div>
</div>

    @if (session('success'))
        <div class="mb-6 bg-green-900 border border-green-800 text-green-300 px-4 py-3 rounded-lg flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-2 text-xl"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Filter Panel -->
    <div id="filterPanel" class="data-card p-6 mb-6 hidden">
        <h2 class="section-title flex items-center mb-6">
            <i class="fas fa-filter text-blue-500 mr-2"></i>
            Filter Activity Logs
        </h2>

        <form action="{{ route('admin.activity-logs.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <label for="user_id" class="block text-gray-300 font-medium mb-2">User</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-500"></i>
                        </div>
                        <select id="user_id" name="user_id"
                            class="w-full pl-10 p-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none">
                            <option value="">All Users</option>
                            @foreach(\App\Models\User::all() as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->username }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-500"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="action" class="block text-gray-300 font-medium mb-2">Action</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-tag text-gray-500"></i>
                        </div>
                        <select id="action" name="action"
                            class="w-full pl-10 p-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none">
                            <option value="">All Actions</option>
                            @foreach($actions as $action)
                                <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                    {{ $action }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-500"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="date_from" class="block text-gray-300 font-medium mb-2">Date From</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-calendar-alt text-gray-500"></i>
                        </div>
                        <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}"
                            class="w-full pl-10 p-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                    </div>
                </div>

                <div>
                    <label for="date_to" class="block text-gray-300 font-medium mb-2">Date To</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-calendar-alt text-gray-500"></i>
                        </div>
                        <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}"
                            class="w-full pl-10 p-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4 pt-6">
                <a href="{{ route('admin.activity-logs.index') }}" class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition duration-200">
                    <i class="fas fa-undo mr-2"></i> Reset
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200 flex items-center">
                    <i class="fas fa-search mr-2"></i> Apply Filters
                </button>
            </div>
        </form>
    </div>

    <div class="data-card p-0 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            User
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Action
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            IP Address
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Date & Time
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse ($activityLogs as $log)
                        <tr class="hover:bg-gray-700 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($log->user)
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-blue-900 rounded-full flex items-center justify-center">
                                            <span class="text-blue-300 font-medium text-lg">{{ substr($log->user->username, 0, 1) }}</span>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-white">
                                                {{ $log->user->username }}
                                            </div>
                                            <div class="text-xs text-gray-400">
                                                {{ $log->user->email }}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gray-800 rounded-full flex items-center justify-center">
                                            <i class="fas fa-cogs text-gray-400"></i>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-white">System</div>
                                            <div class="text-xs text-gray-400">Automated action</div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-white">{{ $log->action }}</div>
                                @if ($log->description)
                                    <div class="text-xs text-gray-400 mt-1">{{ Str::limit($log->description, 50) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                <div class="flex items-center">
                                    <i class="fas fa-network-wired text-gray-500 mr-2"></i>
                                    {{ $log->ip_address }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                <div class="flex items-center">
                                    <i class="far fa-clock text-gray-500 mr-2"></i>
                                    {{ $log->created_at->format('M d, Y H:i:s') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.activity-logs.show', $log->id) }}" class="text-blue-400 hover:text-blue-300 flex items-center">
                                    <i class="fas fa-eye mr-1"></i> View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <i class="fas fa-search text-4xl mb-3"></i>
                                    <p class="text-lg">No activity logs found</p>
                                    <p class="text-sm mt-1">Try adjusting your filters or check back later</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-700">
            {{ $activityLogs->withQueryString()->links() }}
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButton = document.getElementById('filterButton');
        const filterPanel = document.getElementById('filterPanel');

        filterButton.addEventListener('click', function() {
            filterPanel.classList.toggle('hidden');
        });

        // Show filter panel if any filter is applied
        if (
            '{{ request('user_id') }}' ||
            '{{ request('action') }}' ||
            '{{ request('date_from') }}' ||
            '{{ request('date_to') }}'
        ) {
            filterPanel.classList.remove('hidden');
        }
    });
</script>
@endsection
