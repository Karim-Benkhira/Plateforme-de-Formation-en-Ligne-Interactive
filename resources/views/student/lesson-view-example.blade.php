@extends('layouts.student')

@section('title', $lesson->title . ' - ' . $course->title)

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('student.courses') }}" class="hover:text-blue-600">Courses</a></li>
            <li><i class="fas fa-chevron-right text-xs"></i></li>
            <li><a href="{{ route('student.course.content', $course->id) }}" class="hover:text-blue-600">{{ Str::limit($course->title, 30) }}</a></li>
            <li><i class="fas fa-chevron-right text-xs"></i></li>
            <li class="text-gray-800 font-medium">{{ Str::limit($lesson->title, 40) }}</li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-3">
            <!-- Lesson Header -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $lesson->title }}</h1>
                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                            <span class="flex items-center">
                                <i class="{{ $lesson->content_type_icon }} mr-1"></i>
                                {{ $lesson->content_type_label }}
                            </span>
                            @if($lesson->duration)
                                <span class="flex items-center">
                                    <i class="fas fa-clock mr-1"></i>
                                    {{ $lesson->formatted_duration }}
                                </span>
                            @endif
                            @if($lesson->is_free)
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">
                                    <i class="fas fa-unlock mr-1"></i>
                                    Free Preview
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    @if($userEnrolled && $progress)
                        <div class="text-right">
                            @if($progress->is_completed)
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">
                                    <i class="fas fa-check mr-1"></i>
                                    Completed
                                </span>
                            @else
                                <button onclick="markAsCompleted()" 
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                    <i class="fas fa-check mr-1"></i>
                                    Mark as Complete
                                </button>
                            @endif
                        </div>
                    @endif
                </div>

                @if($lesson->description)
                    <p class="text-gray-600 mb-4">{{ $lesson->description }}</p>
                @endif
            </div>

            <!-- Lesson Content -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
                @if($lesson->content_type === 'video')
                    <!-- Video Content -->
                    <div class="aspect-video bg-black">
                        @if($lesson->video_provider === 'youtube')
                            <iframe src="{{ $lesson->video_embed_url }}" 
                                    class="w-full h-full" 
                                    frameborder="0" 
                                    allowfullscreen></iframe>
                        @elseif($lesson->video_provider === 'vimeo')
                            <iframe src="{{ $lesson->video_embed_url }}" 
                                    class="w-full h-full" 
                                    frameborder="0" 
                                    allowfullscreen></iframe>
                        @elseif($lesson->video_provider === 'local' && $lesson->content_file)
                            <video controls class="w-full h-full">
                                <source src="{{ asset('storage/' . $lesson->content_file) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @else
                            <div class="flex items-center justify-center h-full text-white">
                                <div class="text-center">
                                    <i class="fas fa-exclamation-triangle text-4xl mb-4"></i>
                                    <p>Video not available</p>
                                </div>
                            </div>
                        @endif
                    </div>
                @elseif($lesson->content_type === 'text')
                    <!-- Text Content -->
                    <div class="p-8">
                        <div class="prose max-w-none">
                            {!! nl2br(e($lesson->content_text)) !!}
                        </div>
                    </div>
                @elseif($lesson->content_type === 'pdf' && $lesson->content_file)
                    <!-- PDF Content -->
                    <div class="p-6">
                        <div class="text-center">
                            <i class="fas fa-file-pdf text-6xl text-red-500 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-800 mb-4">PDF Document</h3>
                            <a href="{{ asset('storage/' . $lesson->content_file) }}" 
                               target="_blank"
                               class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg inline-flex items-center transition-colors">
                                <i class="fas fa-download mr-2"></i>
                                Download PDF
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Navigation -->
            <div class="flex justify-between items-center">
                @if($previousLesson)
                    <a href="{{ route('student.lesson.view', ['courseId' => $course->id, 'lessonId' => $previousLesson->id]) }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg inline-flex items-center transition-colors">
                        <i class="fas fa-chevron-left mr-2"></i>
                        Previous Lesson
                    </a>
                @else
                    <div></div>
                @endif

                @if($nextLesson)
                    <a href="{{ route('student.lesson.view', ['courseId' => $course->id, 'lessonId' => $nextLesson->id]) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg inline-flex items-center transition-colors">
                        Next Lesson
                        <i class="fas fa-chevron-right ml-2"></i>
                    </a>
                @else
                    <div></div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Course Progress -->
            @if($userEnrolled)
                <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Course Progress</h3>
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
                </div>
            @endif

            <!-- Course Sections -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gray-50 px-4 py-3 border-b">
                    <h3 class="font-bold text-gray-800">Course Content</h3>
                </div>
                
                <div class="max-h-96 overflow-y-auto">
                    @foreach($course->sections as $section)
                        <div class="border-b border-gray-100 last:border-b-0">
                            <div class="px-4 py-3 bg-gray-50">
                                <h4 class="font-medium text-gray-800 text-sm">{{ $section->title }}</h4>
                            </div>
                            
                            @foreach($section->lessons->where('is_published', true) as $sectionLesson)
                                @if($sectionLesson->is_free || $userEnrolled)
                                    <a href="{{ route('student.lesson.view', ['courseId' => $course->id, 'lessonId' => $sectionLesson->id]) }}" 
                                       class="block px-4 py-3 hover:bg-gray-50 transition-colors {{ $sectionLesson->id === $lesson->id ? 'bg-blue-50 border-r-4 border-blue-500' : '' }}">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center flex-1">
                                                <i class="{{ $sectionLesson->content_type_icon }} text-gray-400 mr-2 text-sm"></i>
                                                <span class="text-sm {{ $sectionLesson->id === $lesson->id ? 'text-blue-600 font-medium' : 'text-gray-700' }}">
                                                    {{ Str::limit($sectionLesson->title, 25) }}
                                                </span>
                                            </div>
                                            
                                            @if($userEnrolled && $sectionLesson->progressForUser(auth()->id())?->is_completed)
                                                <i class="fas fa-check text-green-500 text-xs"></i>
                                            @elseif($sectionLesson->is_free)
                                                <i class="fas fa-unlock text-green-500 text-xs"></i>
                                            @endif
                                        </div>
                                        
                                        @if($sectionLesson->duration)
                                            <div class="text-xs text-gray-500 mt-1 ml-5">
                                                {{ $sectionLesson->formatted_duration }}
                                            </div>
                                        @endif
                                    </a>
                                @else
                                    <div class="px-4 py-3 opacity-50">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center flex-1">
                                                <i class="fas fa-lock text-gray-400 mr-2 text-sm"></i>
                                                <span class="text-sm text-gray-500">
                                                    {{ Str::limit($sectionLesson->title, 25) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@if($userEnrolled)
<script>
function markAsCompleted() {
    fetch(`/student/courses/{{ $course->id }}/lessons/{{ $lesson->id }}/complete`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({
            watch_time: 0 // You can track actual watch time here
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error marking lesson as completed');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error marking lesson as completed');
    });
}
</script>
@endif
@endsection
