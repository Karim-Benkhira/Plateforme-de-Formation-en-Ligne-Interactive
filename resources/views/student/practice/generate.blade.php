@extends('layouts.student')

@section('title', 'Generate Practice Questions - ' . $course->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Generate Practice Questions</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $course->title }}</p>
            </div>
            <a href="{{ route('student.practice.dashboard', $course->id) }}" 
               class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>
                Back
            </a>
        </div>
    </div>

    <!-- AI Info Card -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-6 mb-8">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-robot text-blue-500 text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-medium text-blue-900">Gemini AI Technology</h3>
                <p class="text-blue-700 mt-1">
                    We use Google's Gemini AI technology to generate personalized practice questions based on your course content.
                    The questions are diverse and cover the main points in the curriculum.
                </p>
                <div class="mt-3 flex items-center text-sm text-blue-600">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>Completely Free</span>
                    <i class="fas fa-check-circle mr-2 ml-4"></i>
                    <span>High Quality Questions</span>
                    <i class="fas fa-check-circle mr-2 ml-4"></i>
                    <span>Detailed Explanations</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Generation Form -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                <i class="fas fa-cog text-gray-500 mr-2"></i>
                Generation Settings
            </h3>
        </div>
        
        <form action="{{ route('student.practice.generate', $course->id) }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Number of Questions -->
                <div>
                    <label for="num_questions" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-hashtag text-blue-500 mr-1"></i>
                        Number of Questions
                    </label>
                    <select name="num_questions" id="num_questions" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="5" {{ old('num_questions', '10') == '5' ? 'selected' : '' }}>5 Questions</option>
                        <option value="10" {{ old('num_questions', '10') == '10' ? 'selected' : '' }}>10 Questions</option>
                        <option value="15" {{ old('num_questions', '10') == '15' ? 'selected' : '' }}>15 Questions</option>
                        <option value="20" {{ old('num_questions', '10') == '20' ? 'selected' : '' }}>20 Questions</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Recommended: 10-15 questions</p>
                </div>

                <!-- Difficulty Level -->
                <div>
                    <label for="difficulty" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-signal text-green-500 mr-1"></i>
                        Difficulty Level
                    </label>
                    <select name="difficulty" id="difficulty" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="easy" {{ old('difficulty', request('difficulty', 'medium')) == 'easy' ? 'selected' : '' }}>Easy</option>
                        <option value="medium" {{ old('difficulty', request('difficulty', 'medium')) == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="hard" {{ old('difficulty', request('difficulty', 'medium')) == 'hard' ? 'selected' : '' }}>Hard</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Choose the appropriate level for you</p>
                </div>

                <!-- Question Type -->
                <div>
                    <label for="question_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-list text-purple-500 mr-1"></i>
                        Question Type
                    </label>
                    <select name="question_type" id="question_type" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="mixed" {{ old('question_type', 'mixed') == 'mixed' ? 'selected' : '' }}>Mixed (All Types)</option>
                        <option value="multiple_choice" {{ old('question_type', 'mixed') == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice Only</option>
                        <option value="true_false" {{ old('question_type', 'mixed') == 'true_false' ? 'selected' : '' }}>True/False Only</option>
                        <option value="short_answer" {{ old('question_type', 'mixed') == 'short_answer' ? 'selected' : '' }}>Short Answer Only</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Mixed provides more variety</p>
                </div>

                <!-- Language -->
                <div>
                    <label for="language" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-language text-orange-500 mr-1"></i>
                        Question Language
                    </label>
                    <select name="language" id="language" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="en" {{ old('language', 'en') == 'en' ? 'selected' : '' }}>English</option>
                        <option value="ar" {{ old('language', 'en') == 'ar' ? 'selected' : '' }}>Arabic</option>
                        <option value="fr" {{ old('language', 'en') == 'fr' ? 'selected' : '' }}>French</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Choose your preferred language for questions</p>
                </div>
            </div>

            <!-- Preview Section -->
            <div class="mt-8 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <i class="fas fa-eye text-blue-500 mr-1"></i>
                    Settings Preview
                </h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Count:</span>
                        <span id="preview-count" class="font-medium text-gray-900 dark:text-white">10</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Difficulty:</span>
                        <span id="preview-difficulty" class="font-medium text-gray-900 dark:text-white">Medium</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Type:</span>
                        <span id="preview-type" class="font-medium text-gray-900 dark:text-white">Mixed</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Language:</span>
                        <span id="preview-language" class="font-medium text-gray-900 dark:text-white">English</span>
                    </div>
                </div>
            </div>

            <!-- Warning -->
            <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-yellow-400"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-sm font-medium text-yellow-800">Important Note</h4>
                        <div class="mt-1 text-sm text-yellow-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Generation may take 30 seconds to 2 minutes</li>
                                <li>Make sure you have a stable internet connection</li>
                                <li>Questions will be saved automatically after generation</li>
                                <li>You can generate new questions anytime</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-8 flex items-center justify-between">
                <button type="submit" 
                        class="btn-primary flex items-center"
                        id="generateBtn">
                    <i class="fas fa-magic mr-2"></i>
                    <span id="btnText">Generate Questions</span>
                    <div id="loadingSpinner" class="hidden ml-2">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                </button>
                
                <div class="text-sm text-gray-500">
                    <i class="fas fa-clock mr-1"></i>
                    Expected time: 1-2 minutes
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Update preview when form changes
function updatePreview() {
    const count = document.getElementById('num_questions').value;
    const difficulty = document.getElementById('difficulty').value;
    const type = document.getElementById('question_type').value;
    const language = document.getElementById('language').value;
    
    document.getElementById('preview-count').textContent = count;
    
    const difficultyMap = { easy: 'Easy', medium: 'Medium', hard: 'Hard' };
    document.getElementById('preview-difficulty').textContent = difficultyMap[difficulty];
    
    const typeMap = { 
        mixed: 'Mixed', 
        multiple_choice: 'Multiple Choice', 
        true_false: 'True/False', 
        short_answer: 'Short Answer' 
    };
    document.getElementById('preview-type').textContent = typeMap[type];
    
    const languageMap = { en: 'English', ar: 'Arabic', fr: 'French' };
    document.getElementById('preview-language').textContent = languageMap[language];
}

// Add event listeners
document.getElementById('num_questions').addEventListener('change', updatePreview);
document.getElementById('difficulty').addEventListener('change', updatePreview);
document.getElementById('question_type').addEventListener('change', updatePreview);
document.getElementById('language').addEventListener('change', updatePreview);

// Handle form submission
document.querySelector('form').addEventListener('submit', function(e) {
    const btn = document.getElementById('generateBtn');
    const btnText = document.getElementById('btnText');
    const spinner = document.getElementById('loadingSpinner');
    
    btn.disabled = true;
    btnText.textContent = 'Generating...';
    spinner.classList.remove('hidden');
});

// Initialize preview
updatePreview();
</script>
@endsection
