@extends('layouts.student')

@section('title', $course->title . ' - Course Content')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Course Header -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl shadow-lg p-8 mb-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold mb-2">{{ $course->title }}</h1>
                <p class="text-blue-100 mb-4">{{ $course->description }}</p>
                <div class="flex items-center space-x-6">
                    <div class="flex items-center">
                        <i class="fas fa-clock mr-2"></i>
                        <span>{{ $course->formatted_total_duration }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-play-circle mr-2"></i>
                        <span>{{ $course->published_lessons_count }} Lessons</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-layer-group mr-2"></i>
                        <span>{{ $course->sections->count() }} Sections</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-signal mr-2"></i>
                        <span>{{ $course->difficulty_label }}</span>
                    </div>
                </div>
            </div>
            @if($course->image)
                <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" 
                     class="w-32 h-32 rounded-lg object-cover">
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Course Content -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b">
                    <h2 class="text-xl font-bold text-gray-800">Course Content</h2>
                </div>

                <div class="p-6">
                    @forelse($course->sections as $section)
                        <div class="mb-8 last:mb-0">
                            <!-- Section Header -->
                            <div class="bg-gray-100 rounded-lg p-4 mb-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800">{{ $section->title }}</h3>
                                        @if($section->description)
                                            <p class="text-gray-600 text-sm mt-1">{{ $section->description }}</p>
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $section->lessons->count() }} lessons
                                    </div>
                                </div>
                            </div>

                            <!-- Section Lessons -->
                            <div class="space-y-3">
                                @forelse($section->lessons->where('is_published', true) as $lesson)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center flex-1">
                                                <!-- Lesson Icon -->
                                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                                                    <i class="{{ $lesson->content_type_icon }} text-blue-600"></i>
                                                </div>

                                                <!-- Lesson Info -->
                                                <div class="flex-1">
                                                    <h4 class="font-medium text-gray-800">{{ $lesson->title }}</h4>
                                                    @if($lesson->description)
                                                        <p class="text-gray-600 text-sm mt-1">{{ Str::limit($lesson->description, 100) }}</p>
                                                    @endif
                                                    <div class="flex items-center space-x-4 mt-2">
                                                        <span class="text-xs bg-gray-200 text-gray-700 px-2 py-1 rounded">
                                                            {{ $lesson->content_type_label }}
                                                        </span>
                                                        @if($lesson->duration)
                                                            <span class="text-xs text-gray-500">
                                                                <i class="fas fa-clock mr-1"></i>
                                                                {{ $lesson->formatted_duration }}
                                                            </span>
                                                        @endif
                                                        @if($lesson->is_free)
                                                            <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">
                                                                <i class="fas fa-unlock mr-1"></i>
                                                                Free Preview
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Action Button -->
                                            <div class="ml-4">
                                                @if($lesson->is_free || $userEnrolled)
                                                    <a href="{{ route('student.lesson.view', ['courseId' => $course->id, 'lessonId' => $lesson->id]) }}" 
                                                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                                        <i class="fas fa-play mr-1"></i>
                                                        @if($lesson->content_type === 'video')
                                                            Watch
                                                        @elseif($lesson->content_type === 'text')
                                                            Read
                                                        @else
                                                            View
                                                        @endif
                                                    </a>
                                                @else
                                                    <span class="bg-gray-300 text-gray-600 px-4 py-2 rounded-lg text-sm">
                                                        <i class="fas fa-lock mr-1"></i>
                                                        Locked
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-8 text-gray-500">
                                        <i class="fas fa-inbox text-3xl mb-2"></i>
                                        <p>No lessons available in this section yet.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-gray-500">
                            <i class="fas fa-layer-group text-4xl mb-4"></i>
                            <h3 class="text-lg font-medium mb-2">No Content Available</h3>
                            <p>This course doesn't have any sections yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Course Progress -->
            @if($userEnrolled)
                <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Your Progress</h3>
                    <div class="mb-4">
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>Completed</span>
                            <span>{{ $course->getCompletionPercentageForUser(auth()->id()) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full transition-all duration-300" 
                                 style="width: {{ $course->getCompletionPercentageForUser(auth()->id()) }}%"></div>
                        </div>
                    </div>
                    <div class="text-sm text-gray-600">
                        {{ $completedLessons ?? 0 }} of {{ $course->published_lessons_count }} lessons completed
                    </div>
                </div>
            @endif

            <!-- Course Info -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Course Information</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Instructor</span>
                        <span class="font-medium">{{ $course->creator->username }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Category</span>
                        <span class="font-medium">{{ $course->category->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Level</span>
                        <span class="font-medium">{{ $course->difficulty_label }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Duration</span>
                        <span class="font-medium">{{ $course->formatted_total_duration }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Lessons</span>
                        <span class="font-medium">{{ $course->published_lessons_count }}</span>
                    </div>
                </div>
            </div>

            <!-- Enrollment Action -->
            @if(!$userEnrolled)
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Enroll in Course</h3>
                    <p class="text-gray-600 text-sm mb-4">
                        Get full access to all course content and track your progress.
                    </p>
                    <form action="{{ route('student.enrollCourse', $course->id) }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg font-medium transition-colors">
                            <i class="fas fa-graduation-cap mr-2"></i>
                            Enroll Now
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
