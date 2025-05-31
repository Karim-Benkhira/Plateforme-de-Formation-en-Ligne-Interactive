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
                        <!-- AI Practice Questions Button -->
                        <a href="{{ route('student.practice.dashboard', $course->id) }}" class="ai-practice-btn w-full block">
                            <div class="ai-practice-content">
                                <!-- Header Section -->
                                <div class="flex items-center justify-between mb-4">
                                    <div class="relative">
                                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                                            <i class="fas fa-robot text-2xl ai-robot-icon"></i>
                                        </div>
                                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-400 rounded-full ai-status-dot flex items-center justify-center">
                                            <div class="w-2 h-2 bg-white rounded-full"></div>
                                        </div>
                                    </div>
                                    <div class="text-center flex-1 mx-4">
                                        <div class="text-xl font-bold tracking-wide mb-1 flex items-center justify-center">
                                            <span class="mr-2">🤖</span>
                                            <span>AI Practice Questions</span>
                                            <span class="ml-2">🧠</span>
                                        </div>
                                        <div class="text-sm opacity-90 font-medium flex items-center justify-center bg-white/10 rounded-full px-3 py-1">
                                            <i class="fab fa-google mr-2 text-blue-300"></i>
                                            <span>Powered by Gemini AI</span>
                                            <i class="fas fa-star ml-2 text-yellow-300 ai-sparkle"></i>
                                        </div>
                                    </div>
                                    <div class="relative">
                                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                                            <i class="fas fa-brain text-2xl ai-brain-icon"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Features Section -->
                                <div class="bg-white/15 rounded-xl p-4 mb-4 border border-white/20">
                                    <div class="grid grid-cols-2 gap-3 text-sm">
                                        <div class="flex items-center bg-white/10 rounded-lg p-2">
                                            <i class="fas fa-magic text-yellow-300 mr-2 ai-sparkle text-lg"></i>
                                            <span class="font-medium">Smart Generation</span>
                                        </div>
                                        <div class="flex items-center bg-white/10 rounded-lg p-2">
                                            <i class="fas fa-language text-blue-300 mr-2 text-lg"></i>
                                            <span class="font-medium">Multi-Language</span>
                                        </div>
                                        <div class="flex items-center bg-white/10 rounded-lg p-2">
                                            <i class="fas fa-chart-line text-green-300 mr-2 text-lg"></i>
                                            <span class="font-medium">Progress Tracking</span>
                                        </div>
                                        <div class="flex items-center bg-white/10 rounded-lg p-2">
                                            <i class="fas fa-gift text-purple-300 mr-2 text-lg"></i>
                                            <span class="font-medium">100% Free</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Call to Action -->
                                <div class="text-center">
                                    <div class="inline-flex items-center space-x-3 bg-gradient-to-r from-yellow-400 via-orange-400 to-red-400 text-gray-900 rounded-full px-6 py-3 font-bold text-base shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                                        <i class="fas fa-rocket text-lg"></i>
                                        <span class="tracking-wide">Start Smart Practice Now</span>
                                        <div class="flex items-center">
                                            <i class="fas fa-arrow-right text-lg animate-bounce"></i>
                                        </div>
                                    </div>
                                    <div class="mt-2 text-xs opacity-75">
                                        <i class="fas fa-clock mr-1"></i>
                                        Ready in seconds • No setup required
                                    </div>
                                </div>
                            </div>
                        </a>

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

<style>
/* AI Practice Questions Button Custom Styles */
.ai-practice-btn {
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
    border-radius: 20px;
    padding: 3px;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    box-shadow:
        0 10px 40px rgba(102, 126, 234, 0.4),
        0 0 0 1px rgba(255, 255, 255, 0.1),
        inset 0 1px 0 rgba(255, 255, 255, 0.2);
    animation: glow-pulse 3s ease-in-out infinite;
}

.ai-practice-btn:hover {
    transform: translateY(-4px) scale(1.03);
    box-shadow:
        0 20px 60px rgba(102, 126, 234, 0.6),
        0 0 0 1px rgba(255, 255, 255, 0.2),
        inset 0 1px 0 rgba(255, 255, 255, 0.3);
}

@keyframes glow-pulse {
    0%, 100% {
        box-shadow:
            0 10px 40px rgba(102, 126, 234, 0.4),
            0 0 0 1px rgba(255, 255, 255, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }
    50% {
        box-shadow:
            0 15px 50px rgba(102, 126, 234, 0.6),
            0 0 0 1px rgba(255, 255, 255, 0.15),
            inset 0 1px 0 rgba(255, 255, 255, 0.25);
    }
}

.ai-practice-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.ai-practice-btn:hover::before {
    left: 100%;
}

.ai-practice-content {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
    border-radius: 17px;
    padding: 24px;
    color: white;
    position: relative;
    z-index: 1;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.ai-robot-icon {
    animation: float 3s ease-in-out infinite;
}

.ai-brain-icon {
    animation: pulse-glow 2s ease-in-out infinite alternate;
}

.ai-status-dot {
    animation: ping 1s cubic-bezier(0, 0, 0.2, 1) infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-5px); }
}

@keyframes pulse-glow {
    0% {
        opacity: 0.7;
        transform: scale(1);
    }
    100% {
        opacity: 1;
        transform: scale(1.1);
    }
}

@keyframes ping {
    75%, 100% {
        transform: scale(2);
        opacity: 0;
    }
}

.ai-sparkle {
    animation: sparkle 1.5s ease-in-out infinite;
}

@keyframes sparkle {
    0%, 100% {
        opacity: 1;
        transform: scale(1) rotate(0deg);
        color: #fbbf24;
    }
    50% {
        opacity: 0.7;
        transform: scale(1.3) rotate(180deg);
        color: #f59e0b;
    }
}

/* Additional enhancements */
.ai-practice-btn .bg-gradient-to-r {
    transition: all 0.3s ease;
}

.ai-practice-btn:hover .bg-gradient-to-r {
    background: linear-gradient(to right, #fbbf24, #f59e0b);
    transform: scale(1.05);
}

.ai-practice-content:hover .ai-robot-icon {
    animation-duration: 1s;
}

.ai-practice-content:hover .ai-brain-icon {
    animation-duration: 1s;
}

/* Glowing text effect */
.ai-practice-content .text-xl {
    text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
}

/* Feature icons glow */
.ai-practice-content .text-yellow-300,
.ai-practice-content .text-blue-300,
.ai-practice-content .text-green-300,
.ai-practice-content .text-purple-300 {
    filter: drop-shadow(0 0 3px currentColor);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .ai-practice-btn {
        padding: 2px;
        border-radius: 16px;
    }

    .ai-practice-content {
        padding: 20px;
        border-radius: 14px;
    }

    .ai-practice-content .text-xl {
        font-size: 1.1rem;
    }

    .ai-practice-content .text-2xl {
        font-size: 1.5rem;
    }

    .ai-practice-content .grid-cols-2 {
        grid-template-columns: 1fr;
        gap: 2px;
    }

    .ai-practice-content .text-base {
        font-size: 0.9rem;
    }

    .ai-practice-content .px-6 {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}

/* Hover effects for desktop */
@media (min-width: 769px) {
    .ai-practice-btn:hover .ai-robot-icon {
        transform: rotate(10deg) scale(1.1);
    }

    .ai-practice-btn:hover .ai-brain-icon {
        transform: rotate(-10deg) scale(1.1);
    }

    .ai-practice-btn:hover .ai-sparkle {
        animation-duration: 0.5s;
    }
}
</style>
