@extends('layouts.teacher')

@section('title', 'Face Verification Status')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-purple-900 to-violet-900">
    <!-- Header -->
    <div class="bg-gradient-to-r from-red-600 via-pink-600 to-purple-600 p-8 mb-8">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h1 class="text-4xl font-bold mb-2 text-white">🔐 Face Verification Status</h1>
                <p class="text-pink-100 text-lg">Monitor student face verification status for secure exams</p>
            </div>
            <div class="mt-6 md:mt-0">
                <a href="{{ route('teacher.dashboard') }}"
                   class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-6 py-3 rounded-xl transition-all flex items-center font-medium">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-6 pb-8">
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            @php
                $totalStudents = count($studentsData);
                $verifiedStudents = collect($studentsData)->where('has_photo', true)->count();
                $unverifiedStudents = $totalStudents - $verifiedStudents;
                $verificationRate = $totalStudents > 0 ? round(($verifiedStudents / $totalStudents) * 100) : 0;
            @endphp

            <div class="bg-gray-800/50 rounded-xl p-6 border border-gray-700/50">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-gradient-to-r from-blue-500 to-cyan-600 mr-4">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Total Students</p>
                        <p class="text-2xl font-bold text-white">{{ $totalStudents }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-800/50 rounded-xl p-6 border border-gray-700/50">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 mr-4">
                        <i class="fas fa-check-circle text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Verified</p>
                        <p class="text-2xl font-bold text-white">{{ $verifiedStudents }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-800/50 rounded-xl p-6 border border-gray-700/50">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-gradient-to-r from-red-500 to-pink-600 mr-4">
                        <i class="fas fa-exclamation-circle text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Unverified</p>
                        <p class="text-2xl font-bold text-white">{{ $unverifiedStudents }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-800/50 rounded-xl p-6 border border-gray-700/50">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-gradient-to-r from-purple-500 to-violet-600 mr-4">
                        <i class="fas fa-percentage text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Verification Rate</p>
                        <p class="text-2xl font-bold text-white">{{ $verificationRate }}%</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Students Table -->
        <div class="bg-gray-800/50 rounded-xl border border-gray-700/50 overflow-hidden">
            <div class="p-6 border-b border-gray-700/50">
                <h2 class="text-xl font-bold text-white mb-2">Student Verification Status</h2>
                <p class="text-gray-400">Monitor which students have completed face verification for secure exams</p>
            </div>

            @if(count($studentsData) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-900/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Student</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Course</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Uploaded</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700/50">
                            @foreach($studentsData as $data)
                                <tr class="hover:bg-gray-700/30 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center">
                                                    <span class="text-white font-medium">{{ substr($data['student']->username, 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-white">{{ $data['student']->username }}</div>
                                                <div class="text-sm text-gray-400">{{ $data['student']->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-white">{{ $data['course']->title }}</div>
                                        <div class="text-sm text-gray-400">{{ $data['course']->level }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($data['has_photo'])
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Verified
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                Not Verified
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                        @if($data['photo_uploaded_at'])
                                            {{ $data['photo_uploaded_at']->format('M d, Y') }}
                                            <br>
                                            <span class="text-xs">{{ $data['photo_uploaded_at']->format('H:i') }}</span>
                                        @else
                                            <span class="text-gray-500">Not uploaded</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if(!$data['has_photo'])
                                            <span class="text-gray-500">
                                                <i class="fas fa-info-circle mr-1"></i>
                                                Pending upload
                                            </span>
                                        @else
                                            <span class="text-green-400">
                                                <i class="fas fa-shield-alt mr-1"></i>
                                                Ready for exams
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="mx-auto h-24 w-24 text-gray-400 mb-4">
                        <i class="fas fa-users text-6xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-white mb-2">No Students Found</h3>
                    <p class="text-gray-400">No students are enrolled in your courses yet.</p>
                </div>
            @endif
        </div>

        <!-- Information Panel -->
        <div class="mt-8 bg-blue-900/20 border border-blue-500/30 rounded-xl p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-blue-100 mb-2">About Face Verification</h3>
                    <div class="text-blue-200 text-sm space-y-2">
                        <p>• Students must upload a photo during registration to access secure exams</p>
                        <p>• Face verification is required before taking any quiz marked as "secure"</p>
                        <p>• Verification expires after 5 minutes for security</p>
                        <p>• Students without photos will be redirected to upload one before exam access</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
