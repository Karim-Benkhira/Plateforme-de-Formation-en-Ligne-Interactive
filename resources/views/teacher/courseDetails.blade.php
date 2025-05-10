@extends('layouts.app')

@section('title', $course->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-6">
        <a href="{{ route('teacher.courses') }}" class="mr-4 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $course->title }}</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Course Information -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="relative">
                    @if($course->image)
                        <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="w-full h-64 object-cover">
                    @else
                        <div class="w-full h-64 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                            <i class="fas fa-book text-gray-400 dark:text-gray-500 text-5xl"></i>
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
                            <span class="text-sm text-gray-500 dark:text-gray-400">Category: {{ $course->category ? $course->category->name : 'Uncategorized' }}</span>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Created: {{ $course->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('teacher.courses.edit', $course->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center text-sm">
                                <i class="fas fa-edit mr-2"></i> Edit Course
                            </a>
                            <a href="{{ route('teacher.generate-quiz', $course->id) }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded inline-flex items-center text-sm">
                                <i class="fas fa-magic mr-2"></i> Generate Quiz
                            </a>
                        </div>
                    </div>
                    
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Description</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-6">{{ $course->description }}</p>
                    
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Course Content</h2>
                    <div class="prose dark:prose-invert max-w-none">
                        @if($course->contents && $course->contents->count() > 0)
                            @foreach($course->contents as $content)
                                @if($content->type == 'text')
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        {{ $content->content }}
                                    </div>
                                @elseif($content->type == 'pdf')
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <a href="{{ asset('storage/' . $content->file) }}" target="_blank" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 inline-flex items-center">
                                            <i class="fas fa-file-pdf mr-2"></i> View PDF
                                        </a>
                                    </div>
                                @elseif($content->type == 'youtube')
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <div class="aspect-w-16 aspect-h-9">
                                            <iframe src="{{ $content->file }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="rounded-lg"></iframe>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <p class="text-gray-500 dark:text-gray-400 italic">No content available for this course.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div>
            <!-- Course Stats -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Course Stats</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                        <p class="text-sm text-blue-600 dark:text-blue-400">Quizzes</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $quizzes->count() }}</p>
                    </div>
                    <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                        <p class="text-sm text-green-600 dark:text-green-400">Students</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $course->students_count ?? 0 }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('teacher.course-analytics', $course->id) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 inline-flex items-center">
                        <i class="fas fa-chart-bar mr-2"></i> View Detailed Analytics
                    </a>
                </div>
            </div>
            
            <!-- Course Quizzes -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">Quizzes</h2>
                    <a href="{{ route('teacher.quizzes.create') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
                
                @if($quizzes->count() > 0)
                    <div class="space-y-4">
                        @foreach($quizzes as $quiz)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-medium text-gray-800 dark:text-white">{{ $quiz->name }}</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $quiz->questions->count() }} questions</p>
                                    </div>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $quiz->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $quiz->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                </div>
                                <div class="mt-3 flex space-x-2">
                                    <a href="{{ route('teacher.quizQuestions', $quiz->id) }}" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i class="fas fa-list-ul mr-1"></i> Questions
                                    </a>
                                    <a href="{{ route('teacher.quizzes.edit', $quiz->id) }}" class="text-sm text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6">
                        <p class="text-gray-500 dark:text-gray-400 mb-4">No quizzes created for this course yet.</p>
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
</div>
@endsection
