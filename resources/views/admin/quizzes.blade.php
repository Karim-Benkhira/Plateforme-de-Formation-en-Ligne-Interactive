@extends('layouts.admin')

@section('title', 'Manage Quizzes')

@section('content')
<div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl shadow-lg p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Quiz Management</h1>
            <p class="text-blue-100">Create and manage quizzes to assess student knowledge.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('admin.createQuiz') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-200 inline-flex items-center">
                <i class="fas fa-plus mr-2"></i> Add New Quiz
            </a>
        </div>
    </div>
</div>

<div class="data-card">
    <div class="flex justify-between items-center mb-6">
        <h2 class="section-title flex items-center">
            <i class="fas fa-question-circle text-purple-500 mr-2"></i>
            All Quizzes
        </h2>
        <div class="flex items-center space-x-2">
            <div class="relative">
                <input type="text" id="quiz-search" placeholder="Search quizzes..." class="bg-gray-700 text-gray-200 border border-gray-600 rounded-lg py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="rounded-tl-lg">Quiz Name</th>
                    <th>Course</th>
                    <th>Category</th>
                    <th>Questions</th>
                    <th>AI Generated</th>
                    <th>Created</th>
                    <th class="rounded-tr-lg">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quizzes as $quiz)
                <tr class="quiz-row">
                    <td>
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-500 to-purple-700 flex items-center justify-center text-white font-bold mr-3">
                                <i class="fas fa-question"></i>
                            </div>
                            <span class="font-medium">{{ $quiz->name }}</span>
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('admin.showCourse', $quiz->course->id) }}" class="hover:text-blue-400 transition-colors">
                            {{ $quiz->course->title }}
                        </a>
                    </td>
                    <td>
                        <span class="px-2 py-1 bg-gray-700 text-gray-300 rounded-md text-xs">
                            {{ $quiz->course->category->name ?? 'Uncategorized' }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center">
                            <i class="fas fa-list-ul text-blue-400 mr-1"></i>
                            <span>{{ $quiz->questions->count() }}</span>
                        </div>
                    </td>
                    <td>
                        @if($quiz->is_ai_generated)
                            <span class="px-2 py-1 bg-purple-900 text-purple-300 rounded-md text-xs flex items-center justify-center w-16">
                                <i class="fas fa-robot mr-1"></i> AI
                            </span>
                        @else
                            <span class="px-2 py-1 bg-gray-700 text-gray-300 rounded-md text-xs flex items-center justify-center w-16">
                                <i class="fas fa-user mr-1"></i> Manual
                            </span>
                        @endif
                    </td>
                    <td>
                        <span class="text-gray-400">{{ $quiz->created_at->format('M d, Y') }}</span>
                    </td>
                    <td>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.quizQuestions', $quiz->id) }}" class="btn btn-sm bg-yellow-600 hover:bg-yellow-700 text-white rounded-md transition-colors" title="Manage Questions">
                                <i class="fas fa-list-alt"></i>
                            </a>
                            <a href="{{ route('admin.editQuiz', $quiz->id) }}" class="btn btn-sm bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors" title="Edit Quiz">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.deleteQuiz', $quiz->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm bg-red-600 hover:bg-red-700 text-white rounded-md transition-colors" onclick="return confirm('Are you sure you want to delete this quiz? This action cannot be undone and will remove all associated questions and results.')" title="Delete Quiz">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($quizzes->isEmpty())
    <div class="text-center py-8">
        <div class="text-gray-400 mb-4">
            <i class="fas fa-question-circle text-5xl"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-300 mb-2">No quizzes found</h3>
        <p class="text-gray-500">Get started by creating your first quiz</p>
        <a href="{{ route('admin.createQuiz') }}" class="mt-4 inline-block bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-200">
            <i class="fas fa-plus mr-2"></i> Add New Quiz
        </a>
    </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('quiz-search');
        const quizRows = document.querySelectorAll('.quiz-row');

        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();

            quizRows.forEach(row => {
                const quizName = row.querySelector('.font-medium').textContent.toLowerCase();
                const courseName = row.querySelector('a').textContent.toLowerCase();

                if (quizName.includes(searchTerm) || courseName.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
@endpush
@endsection