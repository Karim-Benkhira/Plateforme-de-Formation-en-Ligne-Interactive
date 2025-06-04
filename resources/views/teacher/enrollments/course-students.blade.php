@extends('layouts.teacher')

@section('title', 'Course Students - ' . $course->title)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-blue-900 to-purple-900 p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center mb-2">
                        <a href="{{ route('teacher.enrollments.index') }}" 
                           class="text-gray-400 hover:text-white mr-4">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h1 class="text-3xl font-bold text-white">Course Students</h1>
                    </div>
                    <p class="text-gray-300">{{ $course->title }}</p>
                    <p class="text-sm text-gray-400">{{ $course->category->name ?? 'No Category' }}</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">{{ $course->approvedEnrollments->count() }}</div>
                        <div class="text-sm text-gray-300">Enrolled Students</div>
                    </div>
                </div>
            </div>
        </div>

        @if($course->approvedEnrollments->count() > 0)
            <!-- Students List -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 overflow-hidden">
                <div class="p-6 border-b border-white/10">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <i class="fas fa-users mr-3 text-blue-400"></i>
                        Enrolled Students
                    </h2>
                </div>

                <div class="divide-y divide-white/10">
                    @foreach($course->approvedEnrollments as $student)
                        <div class="p-6 hover:bg-white/5 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <!-- Student Avatar -->
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                                        @if($student->profile_image)
                                            <img src="{{ asset('storage/' . $student->profile_image) }}" 
                                                 alt="{{ $student->username }}" 
                                                 class="w-12 h-12 rounded-full object-cover">
                                        @else
                                            <span class="text-white font-medium text-lg">
                                                {{ strtoupper(substr($student->username, 0, 1)) }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Student Info -->
                                    <div>
                                        <h3 class="text-white font-medium">{{ $student->username }}</h3>
                                        <p class="text-gray-400 text-sm">{{ $student->email }}</p>
                                        <div class="flex items-center space-x-4 mt-1">
                                            <p class="text-gray-500 text-xs">
                                                Enrolled {{ $student->pivot->approved_at ? $student->pivot->approved_at->diffForHumans() : 'N/A' }}
                                            </p>
                                            @if($student->pivot->progress > 0)
                                                <span class="text-xs px-2 py-1 bg-blue-500/20 text-blue-300 rounded-full">
                                                    {{ $student->pivot->progress }}% Progress
                                                </span>
                                            @endif
                                            @if($student->pivot->completed)
                                                <span class="text-xs px-2 py-1 bg-emerald-500/20 text-emerald-300 rounded-full">
                                                    <i class="fas fa-check mr-1"></i>Completed
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Student Stats -->
                                <div class="text-right">
                                    <div class="bg-gray-800/50 rounded-lg p-3">
                                        <div class="text-white font-medium text-sm">Progress</div>
                                        <div class="text-2xl font-bold text-blue-400">{{ $student->pivot->progress }}%</div>
                                        <div class="w-20 bg-gray-700 rounded-full h-2 mt-2">
                                            <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $student->pivot->progress }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Course Statistics -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Completion Rate -->
                <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-white">Completion Rate</h3>
                        <i class="fas fa-chart-pie text-emerald-400 text-xl"></i>
                    </div>
                    @php
                        $completedCount = $course->approvedEnrollments->where('pivot.completed', true)->count();
                        $totalCount = $course->approvedEnrollments->count();
                        $completionRate = $totalCount > 0 ? round(($completedCount / $totalCount) * 100) : 0;
                    @endphp
                    <div class="text-3xl font-bold text-emerald-400 mb-2">{{ $completionRate }}%</div>
                    <p class="text-gray-400 text-sm">{{ $completedCount }} of {{ $totalCount }} students completed</p>
                </div>

                <!-- Average Progress -->
                <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-white">Average Progress</h3>
                        <i class="fas fa-chart-line text-blue-400 text-xl"></i>
                    </div>
                    @php
                        $avgProgress = $course->approvedEnrollments->avg('pivot.progress') ?? 0;
                    @endphp
                    <div class="text-3xl font-bold text-blue-400 mb-2">{{ round($avgProgress) }}%</div>
                    <p class="text-gray-400 text-sm">Across all enrolled students</p>
                </div>

                <!-- Total Enrollments -->
                <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-white">Total Enrollments</h3>
                        <i class="fas fa-users text-purple-400 text-xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-purple-400 mb-2">{{ $totalCount }}</div>
                    <p class="text-gray-400 text-sm">Active students</p>
                </div>
            </div>
        @else
            <!-- No Students -->
            <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 p-12 text-center">
                <div class="w-20 h-20 mx-auto bg-gray-700/50 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-user-graduate text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">No Students Enrolled</h3>
                <p class="text-gray-400 mb-6">This course doesn't have any approved students yet.</p>
                <a href="{{ route('teacher.enrollments.index') }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition-colors inline-flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Enrollment Requests
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
