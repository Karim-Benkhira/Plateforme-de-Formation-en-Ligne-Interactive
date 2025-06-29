@extends('layouts.teacher')

@section('title', 'Manage Courses')

@push('styles')
<style>
    .gradient-pink-purple {
        background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 50%, #06b6d4 100%);
    }
    .gradient-pink-blue {
        background: linear-gradient(135deg, #f472b6 0%, #a855f7 50%, #3b82f6 100%);
    }
    .card-hover {
        transition: all 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(236, 72, 153, 0.3);
    }

    /* Clean layout styles */
    .section-spacing {
        margin-bottom: 2rem;
    }

    /* Responsive grid improvements */
    @media (max-width: 768px) {
        .grid {
            gap: 1rem;
        }
    }

    /* Better text readability */
    .text-shadow {
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="gradient-pink-purple rounded-2xl shadow-2xl p-8 mb-8 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-32 h-32 bg-white rounded-full -translate-x-16 -translate-y-16"></div>
        <div class="absolute bottom-0 right-0 w-24 h-24 bg-white rounded-full translate-x-12 translate-y-12"></div>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-center relative z-10">
        <div>
            <h1 class="text-4xl font-bold mb-2 text-white text-shadow">📚 Manage Courses</h1>
            <p class="text-pink-100 text-lg">Create and manage your educational courses</p>
        </div>
        <div class="mt-6 md:mt-0">
            <a href="{{ route('teacher.courses.create') }}"
               class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-8 py-4 rounded-xl transition-all flex items-center font-medium shadow-lg hover:shadow-xl transform hover:scale-105">
                <i class="fas fa-plus mr-3 text-lg"></i> Create New Course
            </a>
        </div>
    </div>
</div>

<!-- Courses Section -->
<div class="mb-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-white flex items-center">
            <i class="fas fa-sparkles mr-3 text-pink-400"></i> Your Courses
        </h2>
    </div>

    @if(count($courses) > 0)
        <!-- Courses Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($courses as $course)
                <div class="bg-gray-900/50 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-pink-500/20 hover:border-pink-400/50 transition-all card-hover">
                    <!-- Course Image -->
                    <div class="aspect-video bg-gradient-to-br from-pink-500/20 to-purple-600/20 relative">
                        @if($course->image)
                            <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center gradient-pink-blue">
                                <i class="fas fa-graduation-cap text-4xl text-white"></i>
                            </div>
                        @endif

                        <!-- Status Badge -->
                        <div class="absolute top-4 right-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium backdrop-blur-sm {{ $course->is_published ? 'bg-emerald-500/90 text-white' : 'bg-amber-500/90 text-white' }}">
                                {{ $course->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </div>
                    </div>

                    <!-- Course Info -->
                    <div class="p-6">
                        <div class="mb-4">
                            <h3 class="text-lg font-semibold text-white mb-2">{{ $course->title }}</h3>
                            <p class="text-gray-400 text-sm">{{ Str::limit($course->description, 100) }}</p>
                        </div>

                        <!-- Course Meta -->
                        <div class="grid grid-cols-2 gap-4 mb-4 text-center">
                            <div>
                                <p class="text-sm text-gray-400">Category</p>
                                <p class="text-white font-medium">{{ $course->category ? $course->category->name : 'Uncategorized' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-400">Created</p>
                                <p class="text-white font-medium">{{ $course->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-2">
                            <a href="{{ route('teacher.courses.show', $course->id) }}"
                               class="flex-1 gradient-pink-blue hover:opacity-90 text-white py-3 px-4 rounded-xl text-center transition-all font-medium shadow-lg">
                                <i class="fas fa-eye mr-2"></i>
                                View
                            </a>
                            <!-- AI Quiz Generation removed - now only available in student practice section -->
                            <a href="{{ route('teacher.course-analytics', $course->id) }}"
                               class="bg-gradient-to-r from-blue-500 to-cyan-600 hover:from-blue-600 hover:to-cyan-700 text-white py-3 px-4 rounded-xl transition-all shadow-lg">
                                <i class="fas fa-chart-bar"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-8">
            {{ $courses->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-20 bg-gray-900/30 rounded-2xl border border-pink-500/20">
            <div class="w-32 h-32 mx-auto gradient-pink-purple rounded-full flex items-center justify-center mb-6">
                <i class="fas fa-graduation-cap text-6xl text-white"></i>
            </div>
            <h3 class="text-2xl font-bold text-white mb-4">📚 No Courses Yet</h3>
            <p class="text-gray-400 mb-8 max-w-md mx-auto text-lg">
                Start creating amazing educational courses and share your knowledge with students worldwide.
            </p>
            <a href="{{ route('teacher.courses.create') }}"
               class="gradient-pink-blue hover:opacity-90 text-white px-10 py-4 rounded-xl transition-all inline-flex items-center font-medium shadow-xl transform hover:scale-105">
                <i class="fas fa-plus mr-3 text-lg"></i>
                Create Your First Course
            </a>
        </div>
    @endif
</div>

<!-- Quick Actions -->
<div class="mb-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-white flex items-center">
            <i class="fas fa-bolt mr-3 text-purple-400"></i> Quick Actions
        </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('teacher.courses.create') }}" class="bg-gray-900/30 rounded-2xl p-6 border border-pink-500/20 hover:border-pink-400/50 transition-all card-hover">
            <div class="flex items-center">
                <div class="p-4 rounded-2xl gradient-pink-blue mr-4 shadow-lg">
                    <i class="fas fa-plus text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white mb-1">Create New Course</h3>
                    <p class="text-gray-400 text-sm">Add a new course to your catalog</p>
                </div>
            </div>
        </a>
        <a href="{{ route('teacher.quizzes') }}" class="bg-gray-900/30 rounded-2xl p-6 border border-purple-500/20 hover:border-purple-400/50 transition-all card-hover">
            <div class="flex items-center">
                <div class="p-4 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-600 mr-4 shadow-lg">
                    <i class="fas fa-question-circle text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white mb-1">Manage Quizzes</h3>
                    <p class="text-gray-400 text-sm">View and edit your quizzes</p>
                </div>
            </div>
        </a>
        <a href="{{ route('teacher.analytics') }}" class="bg-gray-900/30 rounded-2xl p-6 border border-blue-500/20 hover:border-blue-400/50 transition-all card-hover">
            <div class="flex items-center">
                <div class="p-4 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-600 mr-4 shadow-lg">
                    <i class="fas fa-chart-line text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white mb-1">View Analytics</h3>
                    <p class="text-gray-400 text-sm">Track student performance</p>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection
