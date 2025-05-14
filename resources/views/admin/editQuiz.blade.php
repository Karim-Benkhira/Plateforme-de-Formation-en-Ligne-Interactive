@extends('layouts.admin')

@section('title', 'Edit Quiz')

@push('styles')
<style>
    @keyframes pulse-slow {
        0%, 100% {
            opacity: 0.2;
        }
        50% {
            opacity: 0;
        }
    }
    .animate-pulse-slow {
        animation: pulse-slow 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    .bg-grid-white {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23FFFFFF' fill-opacity='0.1'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    /* Input focus effect */
    .input-focus-effect {
        position: relative;
        transition: all 0.3s ease;
    }

    .input-focus-effect:focus-within {
        transform: translateY(-2px);
    }

    .input-focus-effect:focus-within::after {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        bottom: -5px;
        height: 3px;
        background: linear-gradient(to right, #8B5CF6, #3B82F6);
        border-radius: 3px;
        opacity: 0.7;
    }

    /* Select dropdown styling */
    .custom-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236B7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-position: right 0.75rem center;
        background-repeat: no-repeat;
        background-size: 1rem;
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-blue-900 via-primary-800 to-secondary-900 rounded-xl shadow-2xl p-6 mb-8 border border-blue-700/30 relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-white/[0.05] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-purple-500/10"></div>
    <div class="relative flex flex-col md:flex-row justify-between items-center">
        <div>
            <div class="flex items-center mb-2">
                <a href="{{ route('admin.quizzes') }}" class="text-blue-300 hover:text-blue-200 transition-colors mr-2">
                    <i class="fas fa-arrow-left"></i> Back to Quizzes
                </a>
                <span class="text-gray-400 mx-2">|</span>
                <h1 class="text-3xl font-bold text-white flex items-center">
                    <i class="fas fa-edit mr-3 text-purple-300"></i>
                    Edit Quiz
                </h1>
            </div>
            <p class="text-blue-100 opacity-90">Update quiz information</p>
        </div>
    </div>
</div>

<!-- Edit Quiz Form Card -->
<div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 shadow-xl relative overflow-hidden max-w-3xl mx-auto">
    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-purple-600/5 to-blue-800/5"></div>

    <div class="relative">
        <!-- Form Header -->
        <div class="mb-8">
            <div class="flex items-center">
                <div class="bg-purple-900/70 text-purple-400 rounded-lg p-2 mr-3 shadow-inner shadow-purple-950/50">
                    <i class="fas fa-question-circle text-xl"></i>
                </div>
                <h2 class="text-xl font-bold text-white">Quiz Details</h2>
            </div>
            <p class="text-gray-400 mt-2 ml-12">Update the information for this quiz</p>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
            <div class="bg-red-900/50 border border-red-700/50 text-red-300 p-5 rounded-xl mb-6">
                <div class="flex items-center mb-3">
                    <div class="bg-red-800/80 p-2 rounded-lg mr-3">
                        <i class="fas fa-exclamation-triangle text-red-400"></i>
                    </div>
                    <span class="font-semibold text-lg">Please fix the following errors:</span>
                </div>
                <ul class="list-disc pl-12 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Content -->
        <form action="{{ route('admin.updateQuiz', $quiz->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Quiz Name -->
            <div class="bg-gray-800/50 rounded-xl p-6 border border-gray-700/50">
                <label for="name" class="block text-gray-300 font-medium mb-3 flex items-center">
                    <i class="fas fa-signature text-purple-400 mr-2"></i>
                    Quiz Name <span class="text-red-500 ml-1">*</span>
                </label>
                <div class="relative input-focus-effect">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-question-circle text-purple-500/70"></i>
                    </div>
                    <input type="text" name="name" id="name" value="{{ old('name', $quiz->name) }}" required
                        class="w-full pl-12 p-4 bg-gray-900/70 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-transparent transition-all duration-300"
                        placeholder="Enter quiz name" />
                </div>
                <p class="text-sm text-gray-400 mt-2 ml-1">Choose a clear and descriptive name for the quiz</p>
            </div>

            <!-- Course Selection -->
            <div class="bg-gray-800/50 rounded-xl p-6 border border-gray-700/50">
                <label for="course_id" class="block text-gray-300 font-medium mb-3 flex items-center">
                    <i class="fas fa-book text-blue-400 mr-2"></i>
                    Select Course <span class="text-red-500 ml-1">*</span>
                </label>
                <div class="relative input-focus-effect">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-graduation-cap text-blue-500/70"></i>
                    </div>
                    <select name="course_id" id="course_id" required
                        class="w-full pl-12 p-4 bg-gray-900/70 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent transition-all duration-300 appearance-none custom-select pr-10">
                        <option value="">Select Course</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ (old('course_id', $quiz->course_id) == $course->id) ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <p class="text-sm text-gray-400 mt-2 ml-1">Select the course this quiz belongs to</p>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row justify-end gap-4 pt-4 border-t border-gray-700/50">
                <a href="{{ route('admin.quizzes') }}" class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-gray-300 font-medium rounded-lg transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-times mr-2"></i> Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white font-medium rounded-lg transition-all duration-300 flex items-center justify-center shadow-lg hover:shadow-purple-700/30">
                    <i class="fas fa-save mr-2"></i> Update Quiz
                </button>
            </div>
        </form>
    </div>
</div>
@endsection