@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.activity-logs.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Back to Activity Logs
        </a>
    </div>
    
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Activity Log Details</h2>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Basic Information</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Action</h4>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $activityLog->action }}</p>
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">User</h4>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                @if ($activityLog->user)
                                    {{ $activityLog->user->username }} ({{ $activityLog->user->email }})
                                @else
                                    System
                                @endif
                            </p>
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Date & Time</h4>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $activityLog->created_at->format('F d, Y H:i:s') }}</p>
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">IP Address</h4>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $activityLog->ip_address ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Additional Details</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">User Agent</h4>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white break-words">{{ $activityLog->user_agent ?? 'N/A' }}</p>
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</h4>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $activityLog->description ?? 'N/A' }}</p>
                        </div>
                        
                        @if ($activityLog->properties)
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Properties</h4>
                                <div class="mt-1 bg-gray-50 dark:bg-gray-700 p-3 rounded-md">
                                    <pre class="text-xs text-gray-900 dark:text-white overflow-auto">{{ json_encode($activityLog->properties, JSON_PRETTY_PRINT) }}</pre>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
