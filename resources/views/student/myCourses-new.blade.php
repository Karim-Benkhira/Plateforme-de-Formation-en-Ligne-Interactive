@extends('layouts.student')

@section('title', 'My Courses')

@section('content')
<!-- Page Header -->
<div class="welcome-banner bg-gradient-to-r from-primary-600 to-secondary-600 rounded-xl shadow-lg p-6 mb-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">My Learning Journey</h1>
            <p class="text-blue-100">Track your progress and continue learning where you left off.</p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <input type="text" id="courseSearch" placeholder="Search my courses..."
                    class="bg-gray-700 border border-gray-600 text-white rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200">
                <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Course Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="stats-card bg-gradient-to-br from-primary-900 to-primary-800 transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
        <div class="stats-icon primary">
            <i class="fas fa-book"></i>
        </div>
        <div>
            <div class="stats-label">Total Courses</div>
            <div class="stats-value">{{ count($courses) }}</div>
        </div>
    </div>

    <div class="stats-card bg-gradient-to-br from-green-900 to-green-800 transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
        <div class="stats-icon success">
            <i class="fas fa-check-circle"></i>
        </div>
        <div>
            <div class="stats-label">Approved</div>
            <div class="stats-value">{{ $courses->where('enrollment_status', 'approved')->count() }}</div>
        </div>
    </div>

    <div class="stats-card bg-gradient-to-br from-yellow-900 to-yellow-800 transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
        <div class="stats-icon warning">
            <i class="fas fa-clock"></i>
        </div>
        <div>
            <div class="stats-label">Pending</div>
            <div class="stats-value">{{ $courses->where('enrollment_status', 'pending')->count() }}</div>
        </div>
    </div>

    <div class="stats-card bg-gradient-to-br from-amber-900 to-amber-800 transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
        <div class="stats-icon warning">
            <i class="fas fa-chart-line"></i>
        </div>
        <div>
            <div class="stats-label">Average Score</div>
            <div class="stats-value">
                @php
                    $approvedCourses = $courses->where('enrollment_status', 'approved');
                @endphp
                @if($approvedCourses->count() > 0)
                    {{ round($approvedCourses->avg('score'), 1) }}
                @else
                    0
                @endif
            </div>
        </div>
    </div>
</div>

<!-- My Courses -->
<div class="section-card mb-8">
    <div class="section-header flex justify-between items-center">
        <div class="flex items-center">
            <i class="fas fa-graduation-cap mr-2"></i> My Courses
        </div>
        <div class="flex space-x-2">
            <button id="grid-view" class="bg-gray-700 hover:bg-gray-600 text-white p-2 rounded-lg transition-colors active">
                <i class="fas fa-th-large"></i>
            </button>
            <button id="list-view" class="bg-gray-700 hover:bg-gray-600 text-white p-2 rounded-lg transition-colors">
                <i class="fas fa-list"></i>
            </button>
        </div>
    </div>
    <div class="section-content">
        @if(count($courses) > 0)
            <!-- Grid View (default) -->
            <div id="grid-view-container" class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                @foreach($courses as $result)
                    <div class="course-card overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-lg" 
                         data-course-name="{{ strtolower($result->quiz->course->title ?? $result->quiz->course->name) }}">
                        <div class="relative">
                            @if(isset($result->quiz->course->image) && $result->quiz->course->image)
                                <img src="{{ asset('storage/' . $result->quiz->course->image) }}" alt="{{ $result->quiz->course->title ?? $result->quiz->course->name }}" class="w-full h-40 object-cover">
                            @else
                                <div class="w-full h-40 bg-gradient-to-r from-blue-900 to-purple-900 flex items-center justify-center">
                                    <i class="fas fa-book text-4xl text-white opacity-50"></i>
                                </div>
                            @endif
                            <div class="absolute top-3 right-3 flex flex-col space-y-1">
                                <div class="bg-primary-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                                    {{ $result->quiz->course->category->name ?? 'General' }}
                                </div>
                                @if(isset($result->enrollment_status))
                                    @if($result->enrollment_status === 'pending')
                                        <div class="bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                            <i class="fas fa-clock mr-1"></i>Pending
                                        </div>
                                    @elseif($result->enrollment_status === 'approved')
                                        <div class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                            <i class="fas fa-check mr-1"></i>Approved
                                        </div>
                                    @elseif($result->enrollment_status === 'rejected')
                                        <div class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                            <i class="fas fa-times mr-1"></i>Rejected
                                        </div>
                                    @endif
                                @endif
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-gray-900 to-transparent p-4">
                                <div class="flex items-center mb-2">
                                    <div class="w-8 h-8 rounded-full bg-primary-700 flex items-center justify-center mr-2">
                                        <i class="fas fa-user-tie text-primary-300 text-sm"></i>
                                    </div>
                                    <span class="text-white text-sm">{{ $result->quiz->course->creator->username ?? 'Unknown Teacher' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-bold text-white mb-2 line-clamp-1">{{ $result->quiz->course->title ?? $result->quiz->course->name }}</h3>
                            <div class="flex items-center mb-3">
                                <div class="flex items-center mr-4">
                                    <i class="fas fa-trophy text-yellow-500 mr-1"></i>
                                    <span class="text-gray-300 text-sm">Score: {{ $result->score }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt text-blue-400 mr-1"></i>
                                    <span class="text-gray-300 text-sm">{{ $result->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                            
                            <!-- Progress Bar -->
                            <div class="mb-3">
                                <div class="flex justify-between text-xs text-gray-400 mb-1">
                                    <span>Progress</span>
                                    <span>{{ $result->correct_answers }}/{{ $result->answers_count }}</span>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-2.5">
                                    <div class="bg-primary-600 h-2.5 rounded-full" style="width: {{ ($result->correct_answers / $result->answers_count) * 100 }}%"></div>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="space-y-2">
                                <!-- AI Quiz Button -->
                                <div class="flex justify-center">
                                    <a href="{{ route('student.ai.quiz', $result->quiz->course->id) }}"
                                       class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 inline-flex items-center text-sm w-full justify-center">
                                        <i class="fas fa-brain mr-2"></i> AI Quiz
                                    </a>
                                </div>

                                <!-- Main Action Buttons -->
                                <div class="flex justify-between items-center">
                                    @if(isset($result->enrollment_status) && $result->enrollment_status === 'approved')
                                        @if($result->quiz->id)
                                            <a href="{{ route('student.quiz', $result->quiz->id) }}" class="text-primary-400 hover:text-primary-300 text-sm flex items-center transition-colors">
                                                <i class="fas fa-redo-alt mr-1"></i> Retake Quiz
                                            </a>
                                        @else
                                            <span class="text-gray-400 text-sm flex items-center">
                                                <i class="fas fa-info-circle mr-1"></i> No quiz available
                                            </span>
                                        @endif
                                        <a href="{{ route('student.showCourse', $result->quiz->course->id) }}"
                                            class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 inline-flex items-center">
                                            <i class="fas fa-book-open mr-2"></i> Continue
                                        </a>
                                    @elseif(isset($result->enrollment_status) && $result->enrollment_status === 'pending')
                                        <span class="text-yellow-400 text-sm flex items-center">
                                            <i class="fas fa-clock mr-1"></i> Waiting for approval
                                        </span>
                                        <a href="{{ route('student.showCourse', $result->quiz->course->id) }}"
                                            class="bg-gray-600 text-white font-medium py-2 px-4 rounded-lg inline-flex items-center cursor-not-allowed opacity-50">
                                            <i class="fas fa-lock mr-2"></i> Locked
                                        </a>
                                    @elseif(isset($result->enrollment_status) && $result->enrollment_status === 'rejected')
                                        <span class="text-red-400 text-sm flex items-center">
                                            <i class="fas fa-times mr-1"></i> Request rejected
                                        </span>
                                        <a href="{{ route('student.showCourse', $result->quiz->course->id) }}"
                                            class="bg-gray-600 text-white font-medium py-2 px-4 rounded-lg inline-flex items-center cursor-not-allowed opacity-50">
                                            <i class="fas fa-ban mr-2"></i> Rejected
                                        </a>
                                    @else
                                        @if($result->quiz->id)
                                            <a href="{{ route('student.quiz', $result->quiz->id) }}" class="text-primary-400 hover:text-primary-300 text-sm flex items-center transition-colors">
                                                <i class="fas fa-redo-alt mr-1"></i> Retake Quiz
                                            </a>
                                        @else
                                            <span class="text-gray-400 text-sm flex items-center">
                                                <i class="fas fa-info-circle mr-1"></i> No quiz available
                                            </span>
                                        @endif
                                        <a href="{{ route('student.showCourse', $result->quiz->course->id) }}"
                                            class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 inline-flex items-center">
                                            <i class="fas fa-book-open mr-2"></i> Continue
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- List View (hidden by default) -->
            <div id="list-view-container" class="hidden space-y-4 mt-6">
                @foreach($courses as $result)
                    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300"
                         data-course-name="{{ strtolower($result->quiz->course->title ?? $result->quiz->course->name) }}">
                        <div class="flex flex-col md:flex-row">
                            <div class="md:w-1/4 relative">
                                @if(isset($result->quiz->course->image) && $result->quiz->course->image)
                                    <img src="{{ asset('storage/' . $result->quiz->course->image) }}" alt="{{ $result->quiz->course->title ?? $result->quiz->course->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full min-h-[120px] bg-gradient-to-r from-blue-900 to-purple-900 flex items-center justify-center">
                                        <i class="fas fa-book text-4xl text-white opacity-50"></i>
                                    </div>
                                @endif
                                <div class="absolute top-3 right-3 flex flex-col space-y-1">
                                    <div class="bg-primary-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                                        {{ $result->quiz->course->category->name ?? 'General' }}
                                    </div>
                                    @if(isset($result->enrollment_status))
                                        @if($result->enrollment_status === 'pending')
                                            <div class="bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                                <i class="fas fa-clock mr-1"></i>Pending
                                            </div>
                                        @elseif($result->enrollment_status === 'approved')
                                            <div class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                                <i class="fas fa-check mr-1"></i>Approved
                                            </div>
                                        @elseif($result->enrollment_status === 'rejected')
                                            <div class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                                <i class="fas fa-times mr-1"></i>Rejected
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="md:w-3/4 p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-lg font-bold text-white">{{ $result->quiz->course->title ?? $result->quiz->course->name }}</h3>
                                    <span class="text-gray-300 text-sm">{{ $result->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="flex items-center mb-3">
                                    <div class="w-6 h-6 rounded-full bg-primary-700 flex items-center justify-center mr-2">
                                        <i class="fas fa-user-tie text-primary-300 text-xs"></i>
                                    </div>
                                    <span class="text-gray-300 text-sm">{{ $result->quiz->course->creator->username ?? 'Unknown Teacher' }}</span>
                                </div>
                                
                                <!-- Progress Bar -->
                                <div class="mb-3">
                                    <div class="flex justify-between text-xs text-gray-400 mb-1">
                                        <span>Progress</span>
                                        <span>{{ $result->correct_answers }}/{{ $result->answers_count }} (Score: {{ $result->score }})</span>
                                    </div>
                                    <div class="w-full bg-gray-700 rounded-full h-2.5">
                                        <div class="bg-primary-600 h-2.5 rounded-full" style="width: {{ ($result->correct_answers / $result->answers_count) * 100 }}%"></div>
                                    </div>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="space-y-3">
                                    <!-- AI Quiz Button -->
                                    <div class="flex justify-center">
                                        <a href="{{ route('student.ai.quiz', $result->quiz->course->id) }}"
                                           class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 inline-flex items-center text-sm">
                                            <i class="fas fa-brain mr-2"></i> AI Quiz
                                        </a>
                                    </div>

                                    <!-- Main Action Buttons -->
                                    <div class="flex justify-end items-center space-x-3">
                                        @if(isset($result->enrollment_status) && $result->enrollment_status === 'approved')
                                            @if($result->quiz->id)
                                                <a href="{{ route('student.quiz', $result->quiz->id) }}" class="text-primary-400 hover:text-primary-300 text-sm flex items-center transition-colors">
                                                    <i class="fas fa-redo-alt mr-1"></i> Retake Quiz
                                                </a>
                                            @else
                                                <span class="text-gray-400 text-sm flex items-center">
                                                    <i class="fas fa-info-circle mr-1"></i> No quiz available
                                                </span>
                                            @endif
                                            <a href="{{ route('student.showCourse', $result->quiz->course->id) }}"
                                                class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 inline-flex items-center">
                                                <i class="fas fa-book-open mr-2"></i> Continue
                                            </a>
                                        @elseif(isset($result->enrollment_status) && $result->enrollment_status === 'pending')
                                            <span class="text-yellow-400 text-sm flex items-center">
                                                <i class="fas fa-clock mr-1"></i> Waiting for approval
                                            </span>
                                            <a href="{{ route('student.showCourse', $result->quiz->course->id) }}"
                                                class="bg-gray-600 text-white font-medium py-2 px-4 rounded-lg inline-flex items-center cursor-not-allowed opacity-50">
                                                <i class="fas fa-lock mr-2"></i> Locked
                                            </a>
                                        @elseif(isset($result->enrollment_status) && $result->enrollment_status === 'rejected')
                                            <span class="text-red-400 text-sm flex items-center">
                                                <i class="fas fa-times mr-1"></i> Request rejected
                                            </span>
                                            <a href="{{ route('student.showCourse', $result->quiz->course->id) }}"
                                                class="bg-gray-600 text-white font-medium py-2 px-4 rounded-lg inline-flex items-center cursor-not-allowed opacity-50">
                                                <i class="fas fa-ban mr-2"></i> Rejected
                                            </a>
                                        @else
                                            @if($result->quiz->id)
                                                <a href="{{ route('student.quiz', $result->quiz->id) }}" class="text-primary-400 hover:text-primary-300 text-sm flex items-center transition-colors">
                                                    <i class="fas fa-redo-alt mr-1"></i> Retake Quiz
                                                </a>
                                            @else
                                                <span class="text-gray-400 text-sm flex items-center">
                                                    <i class="fas fa-info-circle mr-1"></i> No quiz available
                                                </span>
                                            @endif
                                            <a href="{{ route('student.showCourse', $result->quiz->course->id) }}"
                                                class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 inline-flex items-center">
                                                <i class="fas fa-book-open mr-2"></i> Continue
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-8 text-center">
                <div class="flex flex-col items-center">
                    <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-book-open text-gray-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">No Courses Yet</h3>
                    <p class="text-gray-400 mb-6">You haven't completed any quizzes yet. Start exploring courses to begin your learning journey.</p>
                    <a href="{{ route('student.courses') }}" class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-3 px-6 rounded-lg transition-all duration-200 inline-flex items-center transform hover:scale-105">
                        <i class="fas fa-search mr-2"></i> Explore Courses
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Recommended Courses -->
@if(count($courses) > 0)
<div class="section-card">
    <div class="section-header">
        <i class="fas fa-star mr-2"></i> Recommended For You
    </div>
    <div class="section-content">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            <!-- This would be populated with actual recommended courses in a real implementation -->
            <div class="bg-gray-800 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                <div class="relative">
                    <div class="w-full h-40 bg-gradient-to-r from-purple-900 to-indigo-900 flex items-center justify-center">
                        <i class="fas fa-code text-4xl text-white opacity-50"></i>
                    </div>
                    <div class="absolute top-3 right-3 bg-purple-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                        Programming
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-bold text-white mb-2">Advanced Web Development</h3>
                    <p class="text-gray-400 text-sm mb-4 line-clamp-2">Learn advanced techniques in modern web development including React, Node.js and more.</p>
                    <a href="{{ route('student.courses') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 inline-flex items-center w-full justify-center">
                        <i class="fas fa-info-circle mr-2"></i> View Details
                    </a>
                </div>
            </div>
            
            <div class="bg-gray-800 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                <div class="relative">
                    <div class="w-full h-40 bg-gradient-to-r from-green-900 to-teal-900 flex items-center justify-center">
                        <i class="fas fa-brain text-4xl text-white opacity-50"></i>
                    </div>
                    <div class="absolute top-3 right-3 bg-green-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                        AI
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-bold text-white mb-2">Introduction to Machine Learning</h3>
                    <p class="text-gray-400 text-sm mb-4 line-clamp-2">Discover the fundamentals of machine learning and AI with practical examples.</p>
                    <a href="{{ route('student.courses') }}" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 inline-flex items-center w-full justify-center">
                        <i class="fas fa-info-circle mr-2"></i> View Details
                    </a>
                </div>
            </div>
            
            <div class="bg-gray-800 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                <div class="relative">
                    <div class="w-full h-40 bg-gradient-to-r from-red-900 to-orange-900 flex items-center justify-center">
                        <i class="fas fa-shield-alt text-4xl text-white opacity-50"></i>
                    </div>
                    <div class="absolute top-3 right-3 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                        Security
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-bold text-white mb-2">Cybersecurity Fundamentals</h3>
                    <p class="text-gray-400 text-sm mb-4 line-clamp-2">Learn essential cybersecurity concepts and protect yourself online.</p>
                    <a href="{{ route('student.courses') }}" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 inline-flex items-center w-full justify-center">
                        <i class="fas fa-info-circle mr-2"></i> View Details
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Course search functionality
        const searchInput = document.getElementById('courseSearch');
        const courseCards = document.querySelectorAll('[data-course-name]');

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            courseCards.forEach(card => {
                const courseName = card.getAttribute('data-course-name');

                if (courseName.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
        
        // View toggle functionality
        const gridViewBtn = document.getElementById('grid-view');
        const listViewBtn = document.getElementById('list-view');
        const gridViewContainer = document.getElementById('grid-view-container');
        const listViewContainer = document.getElementById('list-view-container');
        
        gridViewBtn.addEventListener('click', function() {
            gridViewContainer.classList.remove('hidden');
            listViewContainer.classList.add('hidden');
            gridViewBtn.classList.add('active', 'bg-primary-600');
            gridViewBtn.classList.remove('bg-gray-700');
            listViewBtn.classList.remove('active', 'bg-primary-600');
            listViewBtn.classList.add('bg-gray-700');
        });
        
        listViewBtn.addEventListener('click', function() {
            gridViewContainer.classList.add('hidden');
            listViewContainer.classList.remove('hidden');
            listViewBtn.classList.add('active', 'bg-primary-600');
            listViewBtn.classList.remove('bg-gray-700');
            gridViewBtn.classList.remove('active', 'bg-primary-600');
            gridViewBtn.classList.add('bg-gray-700');
        });
    });
</script>
@endpush
