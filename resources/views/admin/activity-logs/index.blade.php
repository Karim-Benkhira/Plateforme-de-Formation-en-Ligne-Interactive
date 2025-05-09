@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Activity Logs</h1>
        
        <div class="flex space-x-2">
            <button type="button" id="filterButton" class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                </svg>
                Filter
            </button>
            
            <form action="{{ route('admin.activity-logs.clear') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear all activity logs? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium rounded-md px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    Clear All
                </button>
            </form>
        </div>
    </div>
    
    @if (session('success'))
        <div class="bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif
    
    <!-- Filter Panel -->
    <div id="filterPanel" class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 mb-6 hidden">
        <form action="{{ route('admin.activity-logs.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">User</label>
                    <select id="user_id" name="user_id" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                        <option value="">All Users</option>
                        @foreach(\App\Models\User::all() as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->username }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="action" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Action</label>
                    <select id="action" name="action" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                        <option value="">All Actions</option>
                        @foreach($actions as $action)
                            <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                {{ $action }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date From</label>
                    <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                </div>
                
                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date To</label>
                    <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                </div>
            </div>
            
            <div class="mt-4 flex justify-end space-x-3">
                <a href="{{ route('admin.activity-logs.index') }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Reset
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>
    
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            User
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Action
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            IP Address
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Date & Time
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($activityLogs as $log)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($log->user)
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                            <span class="text-blue-600 dark:text-blue-300 font-medium">{{ substr($log->user->username, 0, 1) }}</span>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $log->user->username }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $log->user->email }}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-gray-500 dark:text-gray-400">System</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $log->action }}</div>
                                @if ($log->description)
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ Str::limit($log->description, 50) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $log->ip_address }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $log->created_at->format('M d, Y H:i:s') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.activity-logs.show', $log->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                No activity logs found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
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
