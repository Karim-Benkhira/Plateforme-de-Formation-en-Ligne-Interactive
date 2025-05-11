@extends('layouts.teacher')

@section('title', 'Manage Courses')

@section('content')
<!-- Page Header -->
<div class="welcome-banner bg-gradient-to-r from-primary-600 to-secondary-600 rounded-xl shadow-lg p-6 mb-8">
    <div class="flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold mb-2 text-white">Manage Courses</h1>
            <p class="text-blue-100">Create and manage your educational courses</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('teacher.courses.create') }}" class="btn-white">
                <i class="fas fa-plus mr-2"></i> Create New Course
            </a>
        </div>
    </div>
</div>

<!-- Courses List -->
<div class="section-card">
    <div class="section-header">
        <i class="fas fa-book-open mr-2"></i> Your Courses
    </div>
    <div class="section-content">
        @if(count($courses) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="py-3 px-4 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Title</th>
                            <th class="py-3 px-4 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Category</th>
                            <th class="py-3 px-4 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="py-3 px-4 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Created</th>
                            <th class="py-3 px-4 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @foreach($courses as $course)
                            <tr class="hover:bg-gray-700 transition-colors">
                                <td class="py-4 px-4">
                                    <div class="flex items-center">
                                        @if($course->image)
                                            <img class="h-10 w-10 rounded-full object-cover mr-4" src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gray-600 flex items-center justify-center mr-4">
                                                <i class="fas fa-book text-gray-300"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-sm font-medium text-white">{{ $course->title }}</div>
                                            <div class="text-sm text-gray-400">{{ Str::limit($course->description, 50) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-sm text-gray-200">
                                    {{ $course->category ? $course->category->name : 'Uncategorized' }}
                                </td>
                                <td class="py-4 px-4">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $course->is_published ? 'bg-primary-900 text-primary-300' : 'bg-secondary-900 text-secondary-300' }}">
                                        {{ $course->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-sm text-gray-200">
                                    {{ $course->created_at->format('M d, Y') }}
                                </td>
                                <td class="py-4 px-4 text-sm font-medium">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('teacher.courses.show', $course->id) }}" class="action-icon primary" title="View Course">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('teacher.generate-quiz', $course->id) }}" class="action-icon secondary" title="Generate AI Quiz">
                                            <i class="fas fa-magic"></i>
                                        </a>
                                        <a href="{{ route('teacher.course-analytics', $course->id) }}" class="action-icon primary" title="View Analytics">
                                            <i class="fas fa-chart-bar"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t border-gray-700 mt-4">
                {{ $courses->links() }}
            </div>
        @else
            <div class="p-6 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-900 mb-4">
                    <i class="fas fa-book-open text-primary-400 text-2xl"></i>
                </div>
                <p class="text-gray-400 mb-4">You haven't created any courses yet.</p>
                <a href="{{ route('teacher.courses.create') }}" class="btn-primary">
                    <i class="fas fa-plus mr-2"></i> Create Your First Course
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Quick Actions -->
<div class="section-card mt-8">
    <div class="section-header">
        <i class="fas fa-bolt mr-2"></i> Quick Actions
    </div>
    <div class="section-content">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('teacher.courses.create') }}" class="action-card">
                <div class="action-icon primary">
                    <i class="fas fa-plus"></i>
                </div>
                <div>
                    <h3 class="action-title">Create New Course</h3>
                    <p class="action-description">Add a new course to your catalog</p>
                </div>
            </a>
            <a href="{{ route('teacher.quizzes') }}" class="action-card">
                <div class="action-icon secondary">
                    <i class="fas fa-question-circle"></i>
                </div>
                <div>
                    <h3 class="action-title">Manage Quizzes</h3>
                    <p class="action-description">View and edit your quizzes</p>
                </div>
            </a>
            <a href="{{ route('teacher.analytics') }}" class="action-card">
                <div class="action-icon primary">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div>
                    <h3 class="action-title">View Analytics</h3>
                    <p class="action-description">Track student performance</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
