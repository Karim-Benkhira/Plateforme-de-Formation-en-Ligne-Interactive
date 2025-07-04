@extends('layouts.student')

@section('title', 'My Courses')

@section('content')
<div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl shadow-lg p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">My Courses</h1>
            <p class="text-blue-100">Track your progress and continue learning where you left off.</p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <input type="text" id="courseSearch" placeholder="Search my courses..."
                    class="bg-gray-700 border border-gray-600 text-white rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Course Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="stats-card">
        <div class="stats-icon primary">
            <i class="fas fa-book"></i>
        </div>
        <div>
            <div class="stats-label">Enrolled Courses</div>
            <div class="stats-value">{{ count($courses) }}</div>
        </div>
    </div>

    <div class="stats-card">
        <div class="stats-icon success">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <div>
            <div class="stats-label">Completed Quizzes</div>
            <div class="stats-value">{{ count($courses) }}</div>
        </div>
    </div>

    <div class="stats-card">
        <div class="stats-icon warning">
            <i class="fas fa-chart-line"></i>
        </div>
        <div>
            <div class="stats-label">Average Score</div>
            <div class="stats-value">
                @if(count($courses) > 0)
                    {{ round($courses->avg('score'), 1) }}
                @else
                    0
                @endif
            </div>
        </div>
    </div>
</div>

<!-- My Courses -->
<div class="data-card p-6 mb-8">
    <h2 class="section-title flex items-center">
        <i class="fas fa-graduation-cap text-blue-500 mr-2"></i>
        My Learning Journey
    </h2>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6" id="coursesGrid">
        @if(count($courses) > 0)
            @foreach($courses as $result)
                <div class="course-card overflow-hidden" data-course-name="{{ strtolower($result->quiz->course->title ?? $result->quiz->course->name) }}">
                    <div class="relative">
                        @if(isset($result->quiz->course->image) && $result->quiz->course->image)
                            <img src="{{ asset('storage/' . $result->quiz->course->image) }}" alt="{{ $result->quiz->course->title ?? $result->quiz->course->name }}" class="w-full h-40 object-cover">
                        @else
                            <div class="w-full h-40 bg-gradient-to-r from-blue-900 to-purple-900 flex items-center justify-center">
                                <i class="fas fa-book text-4xl text-white opacity-50"></i>
                            </div>
                        @endif
                        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-t from-gray-900 to-transparent opacity-70"></div>
                        <div class="absolute bottom-3 left-3">
                            <div class="bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                                Last Quiz: {{ $result->created_at->format('M d, Y') }}
                            </div>
                        </div>
                        <div class="absolute top-3 right-3">
                            <div class="bg-yellow-600 text-white text-xs font-bold px-2 py-1 rounded-full flex items-center">
                                <i class="fas fa-star mr-1"></i> {{ $result->score }}
                            </div>
                        </div>
                    </div>

                    <div class="p-5">
                        <h3 class="text-xl font-bold text-white mb-2 line-clamp-1">
                            {{ $result->quiz->course->title ?? $result->quiz->course->name }}
                        </h3>

                        <div class="flex justify-between items-center mb-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-blue-900 flex items-center justify-center mr-2">
                                    <span class="text-blue-300 font-bold text-xs">
                                        {{ substr($result->quiz->course->creator->username ?? 'T', 0, 1) }}
                                    </span>
                                </div>
                                <span class="text-gray-400 text-sm">{{ $result->quiz->course->creator->username ?? 'Teacher' }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-clock text-gray-500 mr-1"></i>
                                <span class="text-gray-400 text-sm">{{ $result->quiz->time_limit ?? '30' }} min</span>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mb-4">
                            <div class="flex justify-between text-xs text-gray-400 mb-1">
                                <span>Progress</span>
                                <span>{{ rand(10, 100) }}%</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ rand(10, 100) }}%"></div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <a href="{{ route('student.quiz', $result->quiz->id) }}" class="text-blue-400 hover:text-blue-300 text-sm flex items-center">
                                <i class="fas fa-redo-alt mr-1"></i> Retake Quiz
                            </a>
                            <a href="{{ route('student.showCourse', $result->quiz->course->id) }}"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 inline-flex items-center">
                                <i class="fas fa-book-open mr-2"></i> Continue
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-span-3 p-8 text-center">
                <div class="flex flex-col items-center">
                    <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-book-open text-gray-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">No Courses Yet</h3>
                    <p class="text-gray-400 mb-6">You haven't completed any quizzes yet. Start exploring courses to begin your learning journey.</p>
                    <a href="{{ route('student.courses') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200 inline-flex items-center">
                        <i class="fas fa-search mr-2"></i> Explore Courses
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Course search functionality
        const searchInput = document.getElementById('courseSearch');
        const courseCards = document.querySelectorAll('.course-card');

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
    });
</script>
@endpush

<style>
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection
