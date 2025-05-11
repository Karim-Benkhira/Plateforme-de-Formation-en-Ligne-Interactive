@extends('layouts.student')

@section('title', 'All Courses')

@section('content')
<div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl shadow-lg p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">All Courses</h1>
            <p class="text-blue-100">Explore our catalog of courses and expand your knowledge.</p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <input type="text" id="courseSearch" placeholder="Search courses..."
                    class="bg-gray-700 border border-gray-600 text-white rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Course Categories -->
<div class="mb-8">
    <div class="flex flex-wrap gap-2">
        <button class="category-btn active" data-category="all">
            All Categories
        </button>
        @foreach($categories ?? [] as $category)
            <button class="category-btn" data-category="{{ $category->id }}">
                {{ $category->name }}
            </button>
        @endforeach
    </div>
</div>

<!-- Courses Grid -->
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8" id="coursesGrid">
    @if(count($courses) > 0)
        @foreach($courses as $course)
            <div class="course-card overflow-hidden" data-category="{{ $course->category_id ?? 'all' }}">
                <div class="relative">
                    @if($course->image)
                        <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title ?? $course->name }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-r from-blue-900 to-purple-900 flex items-center justify-center">
                            <i class="fas fa-book text-4xl text-white opacity-50"></i>
                        </div>
                    @endif
                    <div class="absolute top-3 right-3 bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                        {{ $course->category->name ?? 'General' }}
                    </div>
                </div>

                <div class="p-6">
                    <h3 class="text-xl font-bold text-white mb-2 line-clamp-1">{{ $course->title ?? $course->name }}</h3>
                    <p class="text-gray-400 mb-4 text-sm line-clamp-2">{{ $course->description }}</p>

                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-900 flex items-center justify-center mr-2">
                                <span class="text-blue-300 font-bold text-xs">
                                    {{ substr($course->teacher->username ?? 'T', 0, 1) }}
                                </span>
                            </div>
                            <span class="text-gray-400 text-sm">{{ $course->teacher->username ?? 'Teacher' }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-users text-gray-500 mr-1"></i>
                            <span class="text-gray-400 text-sm">{{ $course->students_count ?? rand(10, 100) }}</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="text-yellow-500 mr-1">
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="text-white font-bold">{{ $course->score ?? rand(3, 5) }}</span>
                            <span class="text-gray-400 text-sm ml-1">/5</span>
                        </div>
                        <a href="{{ route('student.showCourse', $course->id) }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 inline-flex items-center">
                            <i class="fas fa-eye mr-2"></i> View
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-span-3 data-card p-8 text-center">
            <div class="flex flex-col items-center">
                <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-book-open text-gray-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">No Courses Available</h3>
                <p class="text-gray-400">There are no courses available at the moment. Please check back later.</p>
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

    .category-btn {
        background-color: #1f2937;
        color: #9ca3af;
        font-weight: 500;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        transition: all 0.2s;
    }

    .category-btn:hover {
        background-color: #374151;
        color: #f3f4f6;
    }

    .category-btn.active {
        background-color: #3b82f6;
        color: white;
    }
</style>
@endsection
