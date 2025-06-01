@extends('layouts.student')

@section('title', 'All Courses')

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
    .course-card {
        background: rgba(31, 41, 55, 0.5);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(236, 72, 153, 0.2);
        border-radius: 1rem;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .course-card:hover {
        border-color: rgba(236, 72, 153, 0.5);
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(236, 72, 153, 0.2);
    }
    .category-btn {
        background: rgba(31, 41, 55, 0.5);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(236, 72, 153, 0.2);
        color: #9ca3af;
        font-weight: 500;
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
    }
    .category-btn:hover {
        border-color: rgba(236, 72, 153, 0.5);
        color: #f3f4f6;
        transform: translateY(-2px);
    }
    .category-btn.active {
        background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
        border-color: rgba(236, 72, 153, 0.8);
        color: white;
        transform: translateY(-2px);
    }
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
@endpush

@section('content')
<!-- Hero Section -->
<div class="gradient-pink-purple rounded-2xl shadow-2xl p-8 mb-8 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-32 h-32 bg-white rounded-full -translate-x-16 -translate-y-16"></div>
        <div class="absolute bottom-0 right-0 w-24 h-24 bg-white rounded-full translate-x-12 translate-y-12"></div>
        <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-white rounded-full opacity-50"></div>
    </div>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 relative z-10">
        <div>
            <h1 class="text-4xl font-bold text-white mb-3 text-shadow">📚 Discover Amazing Courses</h1>
            <p class="text-pink-100 text-lg">Explore our catalog of courses and expand your knowledge with expert instructors.</p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <input type="text" id="courseSearch" placeholder="Search courses..."
                    class="bg-white/20 backdrop-blur-sm border border-white/30 text-white placeholder-pink-200 rounded-xl pl-12 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-white/50 transition-all">
                <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                    <i class="fas fa-search text-pink-200"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Course Categories -->
<div class="mb-8">
    <div class="flex items-center mb-4">
        <h2 class="text-xl font-bold text-white mr-4">Browse by Category</h2>
    </div>
    <div class="flex flex-wrap gap-3">
        <button class="category-btn active" data-category="all">
            <i class="fas fa-th-large mr-2"></i> All Categories
        </button>
        @foreach($categories ?? [] as $category)
            <button class="category-btn" data-category="{{ $category->id }}">
                <i class="fas fa-folder mr-2"></i> {{ $category->name }}
            </button>
        @endforeach
    </div>
</div>

<!-- Courses Grid -->
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8" id="coursesGrid">
    @if(count($courses) > 0)
        @foreach($courses as $course)
            @php
                $isEnrolled = false;
                if (auth()->check()) {
                    $user = auth()->user();
                    $isEnrolled = $user->enrolledCourses()->where('course_id', $course->id)->exists();
                }
            @endphp
            <div class="course-card card-hover" data-category="{{ $course->category_id ?? 'all' }}">
                <div class="relative">
                    @if($course->image)
                        <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title ?? $course->name }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 gradient-pink-blue flex items-center justify-center">
                            <i class="fas fa-book text-4xl text-white opacity-70"></i>
                        </div>
                    @endif
                    <div class="absolute top-3 right-3 bg-white/20 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full border border-white/30">
                        {{ $course->category->name ?? 'General' }}
                    </div>
                    @if($isEnrolled)
                        <div class="absolute top-3 left-3 bg-emerald-500/90 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full flex items-center">
                            <i class="fas fa-check mr-1"></i> Enrolled
                        </div>
                    @endif
                </div>

                <div class="p-6">
                    <h3 class="text-xl font-bold text-white mb-3 line-clamp-1">{{ $course->title ?? $course->name }}</h3>
                    <p class="text-gray-300 mb-4 text-sm line-clamp-2">{{ $course->description }}</p>

                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full gradient-pink-blue flex items-center justify-center mr-3">
                                <span class="text-white font-bold text-sm">
                                    {{ substr($course->teacher->username ?? 'T', 0, 1) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-white text-sm font-medium">{{ $course->teacher->username ?? 'Teacher' }}</p>
                                <p class="text-gray-400 text-xs">Instructor</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="flex items-center text-yellow-400 mb-1">
                                <i class="fas fa-star mr-1"></i>
                                <span class="text-white font-bold text-sm">{{ $course->score ?? number_format(rand(35, 50)/10, 1) }}</span>
                            </div>
                            <div class="flex items-center text-gray-400 text-xs">
                                <i class="fas fa-users mr-1"></i>
                                <span>{{ $course->students_count ?? rand(50, 500) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        @if($isEnrolled)
                            <div class="flex items-center text-emerald-400">
                                <i class="fas fa-play-circle mr-2"></i>
                                <span class="text-sm font-medium">Continue Learning</span>
                            </div>
                            <a href="{{ route('student.showCourse', $course->id) }}"
                                class="gradient-pink-blue hover:opacity-90 text-white font-medium py-2 px-6 rounded-xl transition-all inline-flex items-center transform hover:scale-105">
                                <i class="fas fa-play mr-2"></i> Continue
                            </a>
                        @else
                            <div class="flex items-center text-gray-400">
                                <i class="fas fa-lock mr-2"></i>
                                <span class="text-sm">Enrollment Required</span>
                            </div>
                            <a href="{{ route('student.showCourse', $course->id) }}"
                                class="bg-gray-700 hover:bg-gray-600 text-white font-medium py-2 px-6 rounded-xl transition-all inline-flex items-center transform hover:scale-105">
                                <i class="fas fa-eye mr-2"></i> Preview
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-span-3 course-card p-12 text-center">
            <div class="flex flex-col items-center">
                <div class="w-24 h-24 gradient-pink-purple rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-book-open text-white text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-3">No Courses Available</h3>
                <p class="text-gray-300 text-lg">There are no courses available at the moment. Please check back later.</p>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Course search functionality
        const searchInput = document.getElementById('courseSearch');
        const coursesGrid = document.getElementById('coursesGrid');
        const courseCards = document.querySelectorAll('.course-card');

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            courseCards.forEach(card => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                const description = card.querySelector('p').textContent.toLowerCase();

                if (title.includes(searchTerm) || description.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Category filter functionality
        const categoryButtons = document.querySelectorAll('.category-btn');

        categoryButtons.forEach(button => {
            button.addEventListener('click', function() {
                const category = this.getAttribute('data-category');

                // Update active button
                categoryButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                // Filter courses
                courseCards.forEach(card => {
                    if (category === 'all' || card.getAttribute('data-category') === category) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
@endpush
@endsection
