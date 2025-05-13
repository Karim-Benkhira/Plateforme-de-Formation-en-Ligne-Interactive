@extends('layouts.student')

@section('title', $course->title ?? $course->name)

@section('content')
<!-- Course Header -->
<div class="welcome-banner bg-gradient-to-r from-primary-600 to-secondary-600 rounded-xl shadow-lg p-6 mb-8">
    <div class="flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold mb-2 text-white">{{ $course->title ?? $course->name }}</h1>
            <p class="text-blue-100">{{ Str::limit($course->description, 100) }}</p>
        </div>
        <div class="mt-4 md:mt-0">
            @if($isEnrolled)
                <span class="bg-green-600 text-white px-4 py-2 rounded-lg inline-flex items-center">
                    <i class="fas fa-check-circle mr-2"></i> Enrolled
                </span>
            @else
                <form action="{{ route('student.enrollCourse', $course->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-white">
                        <i class="fas fa-graduation-cap mr-2"></i> Enroll Now
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-md">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-green-500"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        </div>
    </div>
@endif

@if(session('info'))
    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6 rounded shadow-md">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-500"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm">{{ session('info') }}</p>
            </div>
        </div>
    </div>
@endif

<!-- Course Details -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Column - Course Content -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Course Information -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-info-circle mr-2"></i> Course Information
            </div>
            <div class="section-content">
                <div class="prose prose-dark max-w-none">
                    <p class="text-gray-300">{{ $course->description }}</p>
                </div>
            </div>
        </div>

        <!-- Course Content -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-book-open mr-2"></i> Course Content
            </div>
            <div class="section-content">
                @if(count($course->contents) > 0)
                    <div class="space-y-4">
                        @foreach($course->contents as $index => $content)
                            <div class="bg-gray-800 rounded-lg overflow-hidden">
                                <div class="bg-gray-700 px-4 py-3 flex justify-between items-center">
                                    <h3 class="text-white font-medium">
                                        <span class="text-primary-400 mr-2">{{ $index + 1 }}.</span>
                                        {{ $content->title ?? ($content->type === 'pdf' ? 'PDF Document' : ($content->type === 'youtube' ? 'Video Lesson' : 'Lesson Content')) }}
                                    </h3>
                                    <span class="text-xs px-2 py-1 rounded-full {{ $content->type === 'pdf' ? 'bg-red-900 text-red-300' : 'bg-blue-900 text-blue-300' }}">
                                        {{ ucfirst($content->type) }}
                                    </span>
                                </div>
                                <div class="p-4">
                                    @if($content->type === 'pdf')
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <i class="fas fa-file-pdf text-red-500 text-2xl mr-3"></i>
                                                <div>
                                                    <p class="text-white">PDF Document</p>
                                                    <p class="text-gray-400 text-sm">View or download the PDF material</p>
                                                </div>
                                            </div>
                                            <a href="{{ asset('storage/' . $content->file) }}" target="_blank" class="bg-gray-700 hover:bg-gray-600 text-white px-3 py-1 rounded-lg text-sm inline-flex items-center">
                                                <i class="fas fa-external-link-alt mr-1"></i> Open
                                            </a>
                                        </div>
                                    @elseif($content->type === 'youtube')
                                        <div class="aspect-w-16 aspect-h-9 bg-gray-900 rounded">
                                            <iframe
                                                src="{{ getYoutubeEmbedUrl($content->file) }}"
                                                class="w-full h-[400px] rounded"
                                                frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen>
                                            </iframe>
                                        </div>
                                    @elseif($content->type === 'text')
                                        <div class="prose prose-dark max-w-none">
                                            {!! $content->content !!}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-900 mb-4">
                            <i class="fas fa-book text-primary-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-400">No content available for this course yet.</p>
                        @if(!$isEnrolled)
                            <p class="text-gray-500 text-sm mt-2">Enroll to be notified when content is added.</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Column - Course Details and Actions -->
    <div class="space-y-8">
        <!-- Course Stats -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-chart-bar mr-2"></i> Course Details
            </div>
            <div class="section-content">
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-primary-900 flex items-center justify-center mr-3">
                            <i class="fas fa-user-tie text-primary-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Instructor</p>
                            <p class="text-white">{{ $course->teacher->username ?? 'Unknown Teacher' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-primary-900 flex items-center justify-center mr-3">
                            <i class="fas fa-layer-group text-primary-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Category</p>
                            <p class="text-white">{{ $course->category->name ?? 'Uncategorized' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-primary-900 flex items-center justify-center mr-3">
                            <i class="fas fa-users text-primary-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Students Enrolled</p>
                            <p class="text-white">{{ $course->users()->count() ?? 0 }}</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-primary-900 flex items-center justify-center mr-3">
                            <i class="fas fa-star text-primary-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Rating</p>
                            <div class="flex items-center">
                                <div class="flex text-yellow-500">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= ($course->score ?? 4))
                                            <i class="fas fa-star"></i>
                                        @elseif($i - 0.5 <= ($course->score ?? 4))
                                            <i class="fas fa-star-half-alt"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="ml-2 text-white">{{ $course->score ?? 4 }}/5</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course Actions -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-tasks mr-2"></i> Actions
            </div>
            <div class="section-content">
                <div class="space-y-3">
                    <a href="{{ route('student.courses') }}" class="action-button secondary w-full">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Courses
                    </a>

                    @if($isEnrolled)
                        @if($course->quizzes->isNotEmpty())
                            <a href="{{ route('student.quiz', $course->quizzes[0]->id) }}" class="action-button primary w-full">
                                <i class="fas fa-question-circle mr-2"></i> Take Quiz
                            </a>

                            <a href="{{ route('student.secureExam', $course->quizzes[0]->id) }}" class="action-button secondary w-full">
                                <i class="fas fa-lock mr-2"></i> Take Secure Exam
                            </a>
                        @else
                            <button disabled class="action-button disabled w-full">
                                <i class="fas fa-question-circle mr-2"></i> No Quiz Available
                            </button>
                        @endif
                    @else
                        <form action="{{ route('student.enrollCourse', $course->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="action-button primary w-full">
                                <i class="fas fa-graduation-cap mr-2"></i> Enroll in This Course
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
