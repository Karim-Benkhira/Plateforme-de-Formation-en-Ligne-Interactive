@extends('layouts.app')

@section('title', 'Explore Courses | BrightPath')

@section('content')
<div class="bg-gray-950 min-h-screen py-8">
    <div class="container mx-auto px-4">
        <!-- Page Header -->
        <div class="bg-blue-600 rounded-lg shadow-lg p-6 mb-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold mb-2 text-white">Explore Courses</h1>
                    <p class="text-blue-100">Discover new courses and expand your knowledge</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <div class="relative">
                        <input type="text" id="courseSearch" placeholder="Search courses..."
                            class="w-full md:w-72 bg-gray-900 border border-gray-800 text-white rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-400">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-gray-800 rounded-lg p-5 border-l-4 border-blue-500 shadow-lg">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-blue-900/50 flex items-center justify-center mr-4">
                        <i class="fas fa-book text-blue-400 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-white">{{ count($courses ?? []) }}</div>
                        <div class="text-gray-400 text-sm">Available Courses</div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-800 rounded-lg p-5 border-l-4 border-green-500 shadow-lg">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-green-900/50 flex items-center justify-center mr-4">
                        <i class="fas fa-users text-green-400 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-white">500+</div>
                        <div class="text-gray-400 text-sm">Active Students</div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-800 rounded-lg p-5 border-l-4 border-red-500 shadow-lg">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-red-900/50 flex items-center justify-center mr-4">
                        <i class="fas fa-certificate text-red-400 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-white">100%</div>
                        <div class="text-gray-400 text-sm">Satisfaction Rate</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course Categories -->
        <div class="mb-8">
            <div class="flex items-center text-xl font-bold text-white mb-4">
                <i class="fas fa-tags mr-2 text-blue-500"></i> Categories
            </div>
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
        <div>
            <div class="flex items-center text-xl font-bold text-white mb-6">
                <i class="fas fa-book-open mr-2 text-blue-500"></i> Available Courses
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" id="coursesGrid">
                @if(isset($courses) && count($courses) > 0)
                    @foreach($courses as $course)
                        <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg transition-all hover:shadow-blue-900/30 hover:shadow-xl course-card" data-category="{{ $course->category_id ?? 'all' }}">
                            <div class="relative">
                                @if($course->image)
                                    <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title ?? $course->name }}" class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gradient-to-r from-red-900 to-red-700 flex items-center justify-center">
                                        <i class="fas fa-book text-4xl text-white opacity-50"></i>
                                    </div>
                                @endif
                                <div class="absolute top-3 right-3 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                                    {{ $course->category->name ?? 'Red Team' }}
                                </div>
                            </div>

                            <div class="p-4">
                                <h3 class="text-lg font-bold text-white mb-2 line-clamp-1">{{ $course->title ?? $course->name }}</h3>
                                <p class="text-gray-400 mb-4 text-sm line-clamp-2">{{ $course->description }}</p>

                                <div class="flex justify-between items-center mb-3">
                                    <div class="flex items-center">
                                        <div class="w-7 h-7 rounded-full bg-blue-900 flex items-center justify-center mr-2">
                                            <span class="text-blue-300 font-bold text-xs">
                                                {{ substr($course->teacher->username ?? 'T', 0, 1) }}
                                            </span>
                                        </div>
                                        <span class="text-gray-400 text-sm">{{ $course->teacher->username ?? 'Teacher1' }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-400 text-sm">{{ $course->students_count ?? rand(50, 99) }} <i class="fas fa-users text-gray-500 ml-1"></i></span>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                        <div class="text-yellow-500 mr-1">
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <span class="text-white font-bold">{{ $course->score ?? '100' }}</span>
                                        <span class="text-gray-400 text-sm ml-1">/5</span>
                                    </div>
                                    @auth
                                        <a href="{{ route('student.showCourse', $course->id) }}"
                                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-1.5 px-3 rounded transition duration-200 inline-flex items-center text-sm">
                                            <i class="fas fa-eye mr-1"></i> Login to View
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}"
                                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-1.5 px-3 rounded transition duration-200 inline-flex items-center text-sm">
                                            <i class="fas fa-sign-in-alt mr-1"></i> Login to View
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-3 text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-900 mb-4">
                            <i class="fas fa-book-open text-blue-400 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">No Courses Available</h3>
                        <p class="text-gray-400">There are no courses available at the moment. Please check back later.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Learning Tips -->
        <div class="mt-12 mb-8">
            <div class="flex items-center text-xl font-bold text-white mb-6">
                <i class="fas fa-lightbulb mr-2 text-yellow-500"></i> Learning Tips
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-800 rounded-lg p-5 border-t-4 border-blue-500 shadow-lg hover:shadow-blue-900/20 transition-all duration-300">
                    <div class="w-12 h-12 rounded-full bg-blue-900 flex items-center justify-center mb-4">
                        <i class="fas fa-calendar-alt text-blue-400 text-xl"></i>
                    </div>
                    <h4 class="text-white font-semibold mb-2">Regular Schedule</h4>
                    <p class="text-gray-400">Set a regular study schedule to maintain consistent progress in your courses.</p>
                </div>
                <div class="bg-gray-800 rounded-lg p-5 border-t-4 border-purple-500 shadow-lg hover:shadow-purple-900/20 transition-all duration-300">
                    <div class="w-12 h-12 rounded-full bg-purple-900 flex items-center justify-center mb-4">
                        <i class="fas fa-tasks text-purple-400 text-xl"></i>
                    </div>
                    <h4 class="text-white font-semibold mb-2">Take Notes</h4>
                    <p class="text-gray-400">Take notes while watching course videos to improve retention of key concepts.</p>
                </div>
                <div class="bg-gray-800 rounded-lg p-5 border-t-4 border-red-500 shadow-lg hover:shadow-red-900/20 transition-all duration-300">
                    <div class="w-12 h-12 rounded-full bg-red-900 flex items-center justify-center mb-4">
                        <i class="fas fa-users text-red-400 text-xl"></i>
                    </div>
                    <h4 class="text-white font-semibold mb-2">Study Groups</h4>
                    <p class="text-gray-400">Join study groups to discuss course material and solve problems together.</p>
                </div>
            </div>
        </div>
    </div>
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
        border: 1px solid #374151;
    }

    .category-btn:hover {
        background-color: #111827;
        color: #f3f4f6;
        border-color: #4b5563;
    }

    .category-btn.active {
        background-color: #1d4ed8;
        color: white;
        border-color: #2563eb;
    }

    /* Course card hover effect */
    .course-card {
        transition: all 0.3s ease;
    }

    .course-card:hover {
        transform: translateY(-5px);
    }
</style>
@endsection
