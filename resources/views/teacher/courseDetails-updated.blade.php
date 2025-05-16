@extends('layouts.teacher')

@push('styles')
<style>
    /* Fix for aspect ratio containers */
    .aspect-w-16 {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
        height: 0;
        width: 100%;
    }

    .aspect-w-16 iframe,
    .aspect-w-16 video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        min-height: 315px;
    }

    /* Improved video container */
    .video-container {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border-radius: 0.5rem;
        overflow: hidden;
    }

    /* Button animations */
    .btn-animated {
        transition: all 0.3s ease;
    }

    .btn-animated:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
</style>
@endpush

@section('title', $course->title)

@section('content')
<!-- Page Header -->
<div class="flex items-center mb-8">
    <a href="{{ route('teacher.courses') }}" class="mr-4 text-blue-400 hover:text-blue-300 transition-colors duration-200 flex items-center">
        <i class="fas fa-arrow-left mr-2"></i>
        <span>Back to Courses</span>
    </a>
</div>

<div class="bg-gradient-to-r from-primary-600 to-secondary-600 rounded-xl p-6 mb-8 shadow-lg">
    <h1 class="text-3xl font-bold text-white mb-2">{{ $course->title }}</h1>
    <div class="flex items-center text-blue-100">
        <i class="fas fa-graduation-cap mr-2"></i>
        <span>{{ $course->category ? $course->category->name : 'Uncategorized' }}</span>
        <span class="mx-2">•</span>
        <i class="fas fa-signal mr-2"></i>
        <span>{{ ucfirst($course->level ?? 'Beginner') }}</span>
        <span class="mx-2">•</span>
        <i class="fas fa-calendar-alt mr-2"></i>
        <span>Created {{ $course->created_at->format('M d, Y') }}</span>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Course Information -->
    <div class="lg:col-span-2">
        <div class="bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="relative">
                @if($course->image)
                    <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="w-full h-64 object-cover">
                @else
                    <div class="w-full h-64 bg-gray-700 flex items-center justify-center">
                        <i class="fas fa-book text-gray-500 text-5xl"></i>
                    </div>
                @endif
                <div class="absolute top-4 right-4 flex space-x-2">
                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $course->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $course->is_published ? 'Published' : 'Draft' }}
                    </span>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                        {{ ucfirst($course->level ?? 'Beginner') }}
                    </span>
                </div>
            </div>
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <span class="text-sm text-gray-400">Category: {{ $course->category ? $course->category->name : 'Uncategorized' }}</span>
                        <p class="text-sm text-gray-400 mt-1">Created: {{ $course->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('teacher.courses.edit', $course->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg inline-flex items-center text-sm transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-1">
                            <i class="fas fa-edit mr-2"></i> Edit Course
                        </a>
                        <a href="{{ route('teacher.generate-quiz', $course->id) }}" class="bg-gradient-to-r from-purple-600 to-purple-500 hover:from-purple-700 hover:to-purple-600 text-white font-bold py-2 px-4 rounded-lg inline-flex items-center text-sm transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-1">
                            <i class="fas fa-magic mr-2"></i> Generate Quiz
                        </a>
                    </div>
                </div>

                <h2 class="text-xl font-bold text-white mb-2">Description</h2>
                <p class="text-gray-300 mb-6">{{ $course->description }}</p>

                <h2 class="text-xl font-bold text-white mb-4">Course Content</h2>
                <div class="prose prose-invert max-w-none">
                    @if($course->contents && $course->contents->count() > 0)
                        @foreach($course->contents as $content)
                            @if($content->type == 'text')
                                <div class="bg-gray-700 p-6 rounded-xl mb-4 shadow-sm">
                                    <div class="flex items-center mb-3">
                                        <div class="w-10 h-10 rounded-full bg-blue-900 flex items-center justify-center mr-3">
                                            <i class="fas fa-file-alt text-blue-500"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-white">Text Content</h3>
                                    </div>
                                    <div class="pl-13">
                                        {{ $content->content }}
                                    </div>
                                </div>
                            @elseif($content->type == 'pdf')
                                <div class="bg-gray-700 p-6 rounded-xl mb-4 shadow-sm">
                                    <div class="flex items-center mb-3">
                                        <div class="w-10 h-10 rounded-full bg-red-900 flex items-center justify-center mr-3">
                                            <i class="fas fa-file-pdf text-red-500"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-white">PDF Document</h3>
                                    </div>
                                    <div class="mt-3">
                                        <a href="{{ asset('storage/' . $content->file) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200">
                                            <i class="fas fa-file-pdf mr-2"></i> View PDF Document
                                        </a>
                                        <p class="text-sm text-gray-400 mt-2">Click the button above to open the PDF document in a new tab.</p>
                                    </div>
                                </div>
                            @elseif($content->type == 'video')
                                <div class="bg-gray-700 p-6 rounded-xl mb-4 shadow-sm">
                                    <div class="flex items-center mb-3">
                                        <div class="w-10 h-10 rounded-full bg-purple-900 flex items-center justify-center mr-3">
                                            <i class="fas fa-video text-purple-500"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-white">Video Content</h3>
                                    </div>
                                    <div class="mt-3">
                                        <div class="aspect-w-16 aspect-h-9 bg-black rounded-lg overflow-hidden video-container">
                                            <video controls class="w-full h-full object-contain" preload="metadata">
                                                <source src="{{ asset('storage/' . $content->file) }}" type="video/mp4">
                                                <source src="{{ asset('storage/' . $content->file) }}" type="video/webm">
                                                <source src="{{ asset('storage/' . $content->file) }}" type="video/ogg">
                                                <p class="text-white text-center p-4">Your browser does not support the video tag.</p>
                                            </video>
                                        </div>
                                    </div>
                                </div>
                            @elseif($content->type == 'youtube')
                                <div class="bg-gray-700 p-6 rounded-xl mb-4 shadow-sm">
                                    <div class="flex items-center mb-3">
                                        <div class="w-10 h-10 rounded-full bg-red-900 flex items-center justify-center mr-3">
                                            <i class="fab fa-youtube text-red-500"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-white">YouTube Video</h3>
                                    </div>
                                    <div class="mt-3">
                                        <div class="aspect-w-16 aspect-h-9 bg-black rounded-lg overflow-hidden video-container">
                                            @php
                                                $youtubeId = null;
                                                $url = $content->file;

                                                // Extract YouTube video ID from different URL formats
                                                if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $matches)) {
                                                    $youtubeId = $matches[1];
                                                } elseif (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $matches)) {
                                                    $youtubeId = $matches[1];
                                                } elseif (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $url, $matches)) {
                                                    $youtubeId = $matches[1];
                                                } elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $matches)) {
                                                    $youtubeId = $matches[1];
                                                }

                                                $embedUrl = $youtubeId ? "https://www.youtube.com/embed/{$youtubeId}" : "";
                                            @endphp

                                            @if($youtubeId)
                                                <iframe
                                                    src="{{ $embedUrl }}"
                                                    frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                    allowfullscreen
                                                    class="w-full h-full"
                                                    style="min-height: 315px;">
                                                </iframe>
                                            @else
                                                <div class="flex items-center justify-center h-full bg-gray-800 text-white p-4 text-center">
                                                    <div>
                                                        <i class="fas fa-exclamation-triangle text-yellow-500 text-3xl mb-2"></i>
                                                        <p>Unable to embed this YouTube video. Please check the URL format.</p>
                                                        <p class="text-sm text-gray-400 mt-2">Original URL: {{ $url }}</p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="bg-gray-700 p-8 rounded-xl text-center">
                            <div class="w-16 h-16 mx-auto bg-blue-900 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-book-open text-blue-500 text-2xl"></i>
                            </div>
                            <p class="text-gray-400 mb-4">No content available for this course yet.</p>
                            <a href="{{ route('teacher.courses.edit', $course->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-plus mr-2"></i> Add Course Content
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div>
        <!-- Course Stats -->
        <div class="bg-gray-800 rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-bold text-white mb-4">Course Stats</h2>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-blue-900/20 p-4 rounded-lg">
                    <p class="text-sm text-blue-400">Quizzes</p>
                    <p class="text-2xl font-bold text-white">{{ $quizzes->count() }}</p>
                </div>
                <div class="bg-green-900/20 p-4 rounded-lg">
                    <p class="text-sm text-green-400">Students</p>
                    <p class="text-2xl font-bold text-white">{{ $course->students_count ?? 0 }}</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('teacher.course-analytics', $course->id) }}" class="text-blue-400 hover:text-blue-300 inline-flex items-center">
                    <i class="fas fa-chart-bar mr-2"></i> View Detailed Analytics
                </a>
            </div>
        </div>

        <!-- Course Quizzes -->
        <div class="bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-white">Quizzes</h2>
                <a href="{{ route('teacher.quizzes.create') }}" class="text-blue-400 hover:text-blue-300">
                    <i class="fas fa-plus"></i>
                </a>
            </div>

            @if($quizzes->count() > 0)
                <div class="space-y-4">
                    @foreach($quizzes as $quiz)
                        <div class="border border-gray-700 rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-medium text-white">{{ $quiz->name }}</h3>
                                    <p class="text-sm text-gray-400">{{ $quiz->questions->count() }} questions</p>
                                </div>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $quiz->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $quiz->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </div>
                            <div class="mt-3 flex space-x-2">
                                <a href="{{ route('teacher.quizQuestions', $quiz->id) }}" class="text-sm text-blue-400 hover:text-blue-300">
                                    <i class="fas fa-list-ul mr-1"></i> Questions
                                </a>
                                <a href="{{ route('teacher.quizzes.edit', $quiz->id) }}" class="text-sm text-green-400 hover:text-green-300">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6">
                    <p class="text-gray-400 mb-4">No quizzes created for this course yet.</p>
                    <div class="flex justify-center space-x-3">
                        <a href="{{ route('teacher.quizzes.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                            <i class="fas fa-plus mr-2"></i> Create Quiz
                        </a>
                        <a href="{{ route('teacher.generate-quiz', $course->id) }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 active:bg-purple-800 focus:outline-none focus:border-purple-800 focus:ring focus:ring-purple-200 disabled:opacity-25 transition">
                            <i class="fas fa-magic mr-2"></i> AI Generate
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
