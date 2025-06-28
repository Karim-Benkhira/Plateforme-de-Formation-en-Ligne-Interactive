@extends('layouts.admin')

@section('title', 'Create New Quiz')

@push('styles')
<style>
    :root {
        /* Admin Color Scheme - Yellow/Pink */
        --admin-primary: #f59e0b;
        --admin-primary-dark: #d97706;
        --admin-primary-light: #fbbf24;
        --admin-secondary: #ec4899;
        --admin-secondary-dark: #db2777;
        --admin-secondary-light: #f472b6;
        --admin-accent: #fbbf24;
        --admin-accent-dark: #f59e0b;
        --admin-bg-primary: #1f2937;
        --admin-bg-secondary: #111827;
        --admin-text-primary: #f9fafb;
        --admin-text-secondary: #d1d5db;
        --admin-border: #374151;
    }

    @keyframes admin-glow {
        0%, 100% {
            box-shadow: 0 0 20px rgba(245, 158, 11, 0.3);
        }
        50% {
            box-shadow: 0 0 30px rgba(245, 158, 11, 0.5);
        }
    }

    .admin-glow {
        animation: admin-glow 2s ease-in-out infinite;
    }

    .admin-gradient-bg {
        background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%);
    }

    .bg-grid-white {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23FFFFFF' fill-opacity='0.1'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="admin-gradient-bg rounded-xl shadow-2xl p-6 mb-8 border border-yellow-500/30 relative overflow-hidden admin-glow">
    <div class="absolute inset-0 bg-grid-white/[0.05] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-yellow-500/10 to-pink-500/10"></div>
    <div class="relative flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2 flex items-center">
                <i class="fas fa-brain mr-3 text-yellow-300"></i>
                Create New Quiz
            </h1>
            <p class="text-yellow-100 opacity-90">Create a quiz to assess student knowledge.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('admin.quizzes') }}" class="group bg-white/10 backdrop-blur-sm border border-white/20 text-white hover:bg-yellow-500/20 font-semibold py-3 px-5 rounded-lg shadow-lg transition-all duration-300 inline-flex items-center hover:shadow-yellow-500/30 hover:shadow-xl">
                <i class="fas fa-arrow-left mr-2 group-hover:transform group-hover:-translate-x-1 transition-transform duration-300"></i>
                <span>Back to Quizzes</span>
            </a>
        </div>
    </div>
</div>

<!-- Quiz Creation Form -->
<div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-yellow-500/30 rounded-xl p-6 shadow-xl relative overflow-hidden mb-6 hover:shadow-yellow-500/20 hover:shadow-xl transition-all duration-300">
    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-yellow-600/5 to-pink-600/5"></div>
    <div class="relative">
        <form action="{{ route('admin.storeQuiz') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Basic Information Section -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-white flex items-center mb-6 pb-3 border-b border-gray-700/50">
                    <div class="bg-yellow-900/70 text-yellow-400 rounded-lg p-2 mr-3 shadow-inner shadow-yellow-950/50">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <span>Basic Information</span>
                </h2>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-gray-300 font-medium mb-2">Quiz Name <span class="text-red-500">*</span></label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-question-circle text-gray-500 group-hover:text-yellow-400 transition-colors duration-200"></i>
                            </div>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200"
                                placeholder="Enter quiz name" />
                        </div>
                    </div>

                    <div>
                        <label for="course_id" class="block text-gray-300 font-medium mb-2">Course <span class="text-red-500">*</span></label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-book text-gray-500 group-hover:text-yellow-400 transition-colors duration-200"></i>
                            </div>
                            <select name="course_id" id="course_id" required
                                class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 appearance-none">
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-500"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <label for="description" class="block text-gray-300 font-medium mb-2">Quiz Description</label>
                    <div class="relative">
                        <textarea name="description" id="description" rows="4"
                            class="w-full p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200"
                            placeholder="Enter a description for this quiz">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Quiz Settings Section -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-white flex items-center mb-6 pb-3 border-b border-gray-700/50">
                    <div class="bg-pink-900/70 text-pink-400 rounded-lg p-2 mr-3 shadow-inner shadow-pink-950/50">
                        <i class="fas fa-cog"></i>
                    </div>
                    <span>Quiz Settings</span>
                </h2>

                <div class="grid md:grid-cols-3 gap-6">
                    <div>
                        <label for="duration" class="block text-gray-300 font-medium mb-2">Duration (minutes) <span class="text-red-500">*</span></label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-clock text-gray-500 group-hover:text-pink-400 transition-colors duration-200"></i>
                            </div>
                            <input type="number" name="duration" id="duration" value="{{ old('duration', 30) }}" min="1" max="180" required
                                class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all duration-200" />
                        </div>
                        <p class="text-sm text-gray-400 mt-1">Time allowed to complete the quiz</p>
                    </div>

                    <div>
                        <label for="passing_score" class="block text-gray-300 font-medium mb-2">Passing Score (%) <span class="text-red-500">*</span></label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-percentage text-gray-500 group-hover:text-pink-400 transition-colors duration-200"></i>
                            </div>
                            <input type="number" name="passing_score" id="passing_score" value="{{ old('passing_score', 70) }}" min="1" max="100" required
                                class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all duration-200" />
                        </div>
                        <p class="text-sm text-gray-400 mt-1">Minimum score to pass the quiz</p>
                    </div>

                    <div>
                        <label for="attempts_allowed" class="block text-gray-300 font-medium mb-2">Attempts Allowed <span class="text-red-500">*</span></label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-redo text-gray-500 group-hover:text-pink-400 transition-colors duration-200"></i>
                            </div>
                            <input type="number" name="attempts_allowed" id="attempts_allowed" value="{{ old('attempts_allowed', 3) }}" min="1" max="10" required
                                class="w-full pl-10 p-3 bg-gray-800/80 border border-gray-700 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all duration-200" />
                        </div>
                        <p class="text-sm text-gray-400 mt-1">Number of times a student can take this quiz</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div class="bg-gray-800/50 p-4 rounded-lg border border-gray-700/50">
                        <div class="flex items-center">
                            <input type="checkbox" name="is_published" id="is_published" value="1" class="h-5 w-5 text-yellow-600 focus:ring-yellow-500 border-gray-700 bg-gray-700 rounded" {{ old('is_published') ? 'checked' : '' }}>
                            <label for="is_published" class="ml-2 text-gray-300 font-medium">Publish quiz immediately</label>
                        </div>
                        <p class="text-sm text-gray-400 mt-1 ml-7">If unchecked, the quiz will be saved as a draft</p>
                    </div>

                    <div class="bg-gray-800/50 p-4 rounded-lg border border-gray-700/50">
                        <div class="flex items-center">
                            <input type="checkbox" name="requires_face_verification" id="requires_face_verification" value="1" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-700 bg-gray-700 rounded" {{ old('requires_face_verification') ? 'checked' : '' }}>
                            <label for="requires_face_verification" class="ml-2 text-gray-300 font-medium">Require face verification</label>
                        </div>
                        <p class="text-sm text-gray-400 mt-1 ml-7">Students will need to verify their identity with facial recognition</p>
                    </div>

                </div>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-6 bg-red-900/40 border border-red-700/50 text-red-300 px-4 py-3 rounded-lg flex items-center shadow-lg relative overflow-hidden">
                    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-red-500/5 to-red-600/5"></div>
                    <div class="relative w-full">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-circle text-red-500 mr-2 text-xl mt-0.5"></i>
                            <div>
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4 pt-4 border-t border-gray-700/50">
                <a href="{{ route('admin.quizzes') }}" class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white font-medium rounded-lg shadow-lg transition duration-200 flex items-center">
                    <i class="fas fa-times mr-2"></i> Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-yellow-600 to-yellow-700 hover:from-yellow-500 hover:to-yellow-600 text-white font-medium rounded-lg shadow-lg transition duration-300 flex items-center group">
                    <i class="fas fa-save mr-2 group-hover:scale-110 transition-transform duration-200"></i> Create Quiz
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
