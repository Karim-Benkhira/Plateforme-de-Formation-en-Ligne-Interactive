@extends('layouts.teacher')

@section('title', 'My Quizzes')

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
            <h1 class="text-4xl font-bold mb-2 text-white text-shadow">📝 My Quizzes</h1>
            <p class="text-pink-100 text-lg">Create and manage quizzes for your courses</p>
        </div>
        <div class="mt-6 md:mt-0">
            <a href="{{ route('teacher.quizzes.create') }}"
               class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-8 py-4 rounded-xl transition-all flex items-center font-medium shadow-lg hover:shadow-xl transform hover:scale-105">
                <i class="fas fa-plus mr-3 text-lg"></i> Create Quiz
            </a>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="bg-primary-900/20 border-l-4 border-primary-500 text-primary-300 p-4 mb-6 rounded-md shadow-sm" role="alert">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-primary-400 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        </div>
    </div>
@endif

@if($quizzes->count() > 0)
    <!-- Quizzes Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-white flex items-center">
                <i class="fas fa-clipboard-list mr-3 text-pink-400"></i> Your Quizzes
            </h2>
        </div>

        <!-- Quizzes Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($quizzes as $quiz)
                <div class="bg-gray-900/50 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-pink-500/20 hover:border-pink-400/50 transition-all card-hover">
                    <!-- Quiz Header -->
                    <div class="p-6 border-b border-gray-700/50">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-white mb-2">{{ $quiz->name }}</h3>
                                <p class="text-gray-400 text-sm">{{ $quiz->course->title }}</p>
                            </div>
                            <div class="ml-3">
                                @if($quiz->is_published)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-500/90 text-white">
                                        <i class="fas fa-check-circle mr-1"></i> Published
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-500/90 text-white">
                                        <i class="fas fa-clock mr-1"></i> Draft
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Quiz Features -->
                        <div class="flex flex-wrap gap-2 mb-3">
                            @if($quiz->requires_face_verification)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-500/20 text-purple-300 border border-purple-500/30">
                                    <i class="fas fa-user-shield mr-1"></i> Secure Exam
                                </span>
                            @endif
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-500/20 text-blue-300 border border-blue-500/30">
                                <i class="fas fa-question-circle mr-1"></i> {{ $quiz->questions->count() }} Questions
                            </span>
                        </div>
                    </div>

                    <!-- Quiz Actions -->
                    <div class="p-6">
                        <div class="grid grid-cols-3 gap-2">
                            <a href="{{ route('teacher.quizQuestions', $quiz->id) }}"
                               class="bg-gradient-to-r from-blue-500 to-cyan-600 hover:from-blue-600 hover:to-cyan-700 text-white py-2 px-3 rounded-lg text-center transition-all text-sm font-medium shadow-lg">
                                <i class="fas fa-list-ul mb-1 block"></i>
                                Questions
                            </a>
                            <a href="{{ route('teacher.quizzes.edit', $quiz->id) }}"
                               class="gradient-pink-blue hover:opacity-90 text-white py-2 px-3 rounded-lg text-center transition-all text-sm font-medium shadow-lg">
                                <i class="fas fa-edit mb-1 block"></i>
                                Edit
                            </a>
                            <form action="{{ route('teacher.quizzes.delete', $quiz->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this quiz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white py-2 px-3 rounded-lg transition-all text-sm font-medium shadow-lg">
                                    <i class="fas fa-trash mb-1 block"></i>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-8">
            {{ $quizzes->links() }}
        </div>
    </div>
@else
    <!-- Empty State -->
    <div class="text-center py-20 bg-gray-900/30 rounded-2xl border border-pink-500/20 mb-8">
        <div class="w-32 h-32 mx-auto gradient-pink-purple rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-clipboard-list text-6xl text-white"></i>
        </div>
        <h3 class="text-2xl font-bold text-white mb-4">📝 No Quizzes Yet</h3>
        <p class="text-gray-400 mb-8 max-w-md mx-auto text-lg">
            You haven't created any quizzes yet. Get started by creating your first quiz to assess your students' knowledge.
        </p>
        <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
            <a href="{{ route('teacher.quizzes.create') }}"
               class="gradient-pink-blue hover:opacity-90 text-white px-10 py-4 rounded-xl transition-all inline-flex items-center font-medium shadow-xl transform hover:scale-105">
                <i class="fas fa-plus mr-3 text-lg"></i>
                Create Your First Quiz
            </a>
            <a href="{{ route('teacher.courses') }}"
               class="bg-gray-700 hover:bg-gray-600 text-white px-10 py-4 rounded-xl transition-all inline-flex items-center font-medium shadow-lg">
                <i class="fas fa-book mr-3 text-lg"></i>
                View My Courses
            </a>
        </div>
    </div>
@endif

<!-- Quick Actions -->
<div class="mb-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-white flex items-center">
            <i class="fas fa-bolt mr-3 text-purple-400"></i> Quick Actions
        </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- AI Quiz Generation removed - now only available in student practice section -->
        <a href="{{ route('teacher.analytics') }}" class="bg-gray-900/30 rounded-2xl p-6 border border-blue-500/20 hover:border-blue-400/50 transition-all card-hover">
            <div class="flex items-center">
                <div class="p-4 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-600 mr-4 shadow-lg">
                    <i class="fas fa-chart-line text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white mb-1">Track Performance</h3>
                    <p class="text-gray-400 text-sm">Monitor student progress and results</p>
                </div>
            </div>
        </a>
        <a href="{{ route('teacher.quizzes.create') }}" class="bg-gray-900/30 rounded-2xl p-6 border border-purple-500/20 hover:border-purple-400/50 transition-all card-hover">
            <div class="flex items-center">
                <div class="p-4 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-600 mr-4 shadow-lg">
                    <i class="fas fa-user-shield text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white mb-1">Secure Exams</h3>
                    <p class="text-gray-400 text-sm">Create exams with face verification</p>
                </div>
            </div>
        </a>
    </div>
</div>

@endsection
