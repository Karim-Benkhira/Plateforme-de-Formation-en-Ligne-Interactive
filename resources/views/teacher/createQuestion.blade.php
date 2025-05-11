@extends('layouts.app')

@section('title', 'Create Question')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-8">
        <a href="{{ route('teacher.quizQuestions', $quizId) }}" class="mr-4 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 p-2 rounded-full transition duration-300">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white flex items-center">
            <span class="bg-primary-100 dark:bg-primary-900 p-2 rounded-full mr-3">
                <i class="fas fa-question-circle text-primary-600 dark:text-primary-400"></i>
            </span>
            Add Question to {{ $quiz->name }}
        </h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="bg-gradient-to-r from-primary-600 to-secondary-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-edit mr-2"></i> Question Details
                    </h2>
                </div>

                @if($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mx-6 mt-6" role="alert">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="font-bold">Please fix the following errors:</p>
                                <ul class="mt-1 list-disc list-inside text-sm">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="p-8">
                    <form action="{{ route('teacher.storeQuestion', $quizId) }}" method="POST" class="space-y-8">
                        @csrf

                        <div class="mb-6">
                            <label for="question" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-pen mr-2 text-primary-600"></i>Question Text
                            </label>
                            <textarea name="question" id="question" rows="4" placeholder="Enter your question here..." class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-50 transition duration-200" required>{{ old('question') }}</textarea>
                        </div>

                        <div class="mb-8">
                            <label for="question_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-list-ul mr-2 text-primary-600"></i>Question Type
                            </label>
                            <div class="grid grid-cols-3 gap-4">
                                <div class="relative">
                                    <input type="radio" name="question_type" id="type_multiple_choice" value="multiple_choice" class="peer absolute h-0 w-0 opacity-0" {{ old('question_type', 'multiple_choice') == 'multiple_choice' ? 'checked' : '' }} onchange="toggleQuestionType()">
                                    <label for="type_multiple_choice" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer peer-checked:border-primary-500 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900/20 hover:bg-gray-50 dark:hover:bg-gray-750 transition duration-200">
                                        <i class="fas fa-list-ol text-2xl mb-2 text-gray-500 dark:text-gray-400 peer-checked:text-primary-600"></i>
                                        <span class="font-medium text-gray-700 dark:text-gray-300 peer-checked:text-primary-700 dark:peer-checked:text-primary-300">Multiple Choice</span>
                                    </label>
                                </div>
                                <div class="relative">
                                    <input type="radio" name="question_type" id="type_true_false" value="true_false" class="peer absolute h-0 w-0 opacity-0" {{ old('question_type') == 'true_false' ? 'checked' : '' }} onchange="toggleQuestionType()">
                                    <label for="type_true_false" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer peer-checked:border-primary-500 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900/20 hover:bg-gray-50 dark:hover:bg-gray-750 transition duration-200">
                                        <i class="fas fa-toggle-on text-2xl mb-2 text-gray-500 dark:text-gray-400 peer-checked:text-primary-600"></i>
                                        <span class="font-medium text-gray-700 dark:text-gray-300 peer-checked:text-primary-700 dark:peer-checked:text-primary-300">True/False</span>
                                    </label>
                                </div>
                                <div class="relative">
                                    <input type="radio" name="question_type" id="type_short_answer" value="short_answer" class="peer absolute h-0 w-0 opacity-0" {{ old('question_type') == 'short_answer' ? 'checked' : '' }} onchange="toggleQuestionType()">
                                    <label for="type_short_answer" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer peer-checked:border-secondary-500 peer-checked:bg-secondary-50 dark:peer-checked:bg-secondary-900/20 hover:bg-gray-50 dark:hover:bg-gray-750 transition duration-200">
                                        <i class="fas fa-keyboard text-2xl mb-2 text-gray-500 dark:text-gray-400 peer-checked:text-secondary-600"></i>
                                        <span class="font-medium text-gray-700 dark:text-gray-300 peer-checked:text-secondary-700 dark:peer-checked:text-secondary-300">Short Answer</span>
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" id="question_type_hidden" name="question_type" value="{{ old('question_type', 'multiple_choice') }}">
                        </div>

                        <!-- Multiple Choice Options -->
                        <div id="multiple_choice_options" class="p-6 bg-primary-50 dark:bg-primary-900/10 rounded-lg border border-primary-100 dark:border-primary-800">
                            <div class="flex items-center mb-4">
                                <i class="fas fa-list-ol text-primary-600 text-xl mr-2"></i>
                                <h3 class="text-lg font-medium text-primary-700 dark:text-primary-300">Multiple Choice Options</h3>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Enter each option on a new line. Mark the correct answer with an asterisk (*) at the beginning.</p>
                                <textarea name="options" id="options" rows="6" class="w-full px-4 py-3 rounded-lg border border-primary-200 dark:border-primary-700 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-50 transition duration-200">{{ old('options') }}</textarea>
                                <div class="mt-3 p-3 bg-white dark:bg-gray-800 rounded-lg border border-primary-100 dark:border-primary-800">
                                    <p class="text-sm font-medium text-primary-600 dark:text-primary-400 mb-1">Example:</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Paris</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">London</p>
                                    <p class="text-sm text-primary-600 dark:text-primary-400">*Berlin (correct)</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Madrid</p>
                                </div>
                            </div>
                        </div>

                        <!-- True/False Options -->
                        <div id="true_false_options" class="p-6 bg-primary-50 dark:bg-primary-900/10 rounded-lg border border-primary-100 dark:border-primary-800 hidden">
                            <div class="flex items-center mb-4">
                                <i class="fas fa-toggle-on text-primary-600 text-xl mr-2"></i>
                                <h3 class="text-lg font-medium text-primary-700 dark:text-primary-300">True/False Answer</h3>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Select the correct answer for this true/false question.</p>
                                <div class="flex items-center space-x-6">
                                    <div class="relative">
                                        <input type="radio" id="true" name="correct_tf" value="true" class="peer absolute h-0 w-0 opacity-0" {{ old('correct_tf', 'true') == 'true' ? 'checked' : '' }}>
                                        <label for="true" class="flex items-center justify-center px-6 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer peer-checked:border-primary-500 peer-checked:bg-primary-100 dark:peer-checked:bg-primary-900/30 hover:bg-gray-50 dark:hover:bg-gray-750 transition duration-200">
                                            <i class="fas fa-check text-xl mr-2 text-primary-600"></i>
                                            <span class="font-medium">True</span>
                                        </label>
                                    </div>
                                    <div class="relative">
                                        <input type="radio" id="false" name="correct_tf" value="false" class="peer absolute h-0 w-0 opacity-0" {{ old('correct_tf') == 'false' ? 'checked' : '' }}>
                                        <label for="false" class="flex items-center justify-center px-6 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer peer-checked:border-primary-500 peer-checked:bg-primary-100 dark:peer-checked:bg-primary-900/30 hover:bg-gray-50 dark:hover:bg-gray-750 transition duration-200">
                                            <i class="fas fa-times text-xl mr-2 text-primary-600"></i>
                                            <span class="font-medium">False</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Short Answer Options -->
                        <div id="short_answer_options" class="p-6 bg-secondary-50 dark:bg-secondary-900/10 rounded-lg border border-secondary-100 dark:border-secondary-800 hidden">
                            <div class="flex items-center mb-4">
                                <i class="fas fa-keyboard text-secondary-600 text-xl mr-2"></i>
                                <h3 class="text-lg font-medium text-secondary-700 dark:text-secondary-300">Short Answer</h3>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Enter the correct answer. Student responses will be checked against this.</p>
                                <input type="text" name="correct_answer" id="correct_answer" value="{{ old('correct_answer') }}" placeholder="Enter correct answer" class="w-full px-4 py-3 rounded-lg border border-secondary-200 dark:border-secondary-700 dark:bg-gray-700 dark:text-white shadow-sm focus:border-secondary-500 focus:ring-2 focus:ring-secondary-500 focus:ring-opacity-50 transition duration-200">
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Keep answers concise (1-3 words) for better matching with student responses.</p>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex justify-end">
                                <a href="{{ route('teacher.quizQuestions', $quizId) }}" class="bg-white dark:bg-gray-700 py-3 px-6 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-300">
                                    Cancel
                                </a>
                                <button type="submit" class="ml-4 inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-gradient-to-r from-primary-600 to-secondary-600 hover:from-primary-700 hover:to-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-300">
                                    <i class="fas fa-save mr-2"></i> Add Question
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 sticky top-8">
                <div class="bg-gradient-to-r from-primary-600 to-secondary-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-lightbulb mr-2"></i> Question Tips
                    </h2>
                </div>
                <div class="p-6">
                    <div class="space-y-6">
                        <div class="bg-primary-50 dark:bg-primary-900/20 p-4 rounded-lg border border-primary-100 dark:border-primary-800">
                            <h3 class="font-bold text-primary-700 dark:text-primary-300 mb-2 flex items-center">
                                <i class="fas fa-list-ol mr-2"></i> Multiple Choice
                            </h3>
                            <ul class="list-disc pl-5 space-y-1 text-gray-700 dark:text-gray-300 text-sm">
                                <li>Keep options similar in length and structure</li>
                                <li>Avoid using "All of the above" or "None of the above"</li>
                                <li>Make sure there is only one clearly correct answer</li>
                                <li>Use plausible distractors that test common misconceptions</li>
                            </ul>
                        </div>

                        <div class="bg-primary-50 dark:bg-primary-900/20 p-4 rounded-lg border border-primary-100 dark:border-primary-800">
                            <h3 class="font-bold text-primary-700 dark:text-primary-300 mb-2 flex items-center">
                                <i class="fas fa-toggle-on mr-2"></i> True/False
                            </h3>
                            <ul class="list-disc pl-5 space-y-1 text-gray-700 dark:text-gray-300 text-sm">
                                <li>Avoid using absolute terms like "always" or "never"</li>
                                <li>Keep statements clear and unambiguous</li>
                                <li>Focus on testing important concepts, not trivial details</li>
                                <li>Ensure statements are completely true or completely false</li>
                            </ul>
                        </div>

                        <div class="bg-secondary-50 dark:bg-secondary-900/20 p-4 rounded-lg border border-secondary-100 dark:border-secondary-800">
                            <h3 class="font-bold text-secondary-700 dark:text-secondary-300 mb-2 flex items-center">
                                <i class="fas fa-keyboard mr-2"></i> Short Answer
                            </h3>
                            <ul class="list-disc pl-5 space-y-1 text-gray-700 dark:text-gray-300 text-sm">
                                <li>Be specific about what you're asking for</li>
                                <li>Consider alternative correct answers or spellings</li>
                                <li>Keep the required answer brief (1-3 words is ideal)</li>
                                <li>Use for testing recall of key terms or concepts</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function toggleQuestionType() {
        // Get the selected question type from the radio buttons
        const radioButtons = document.querySelectorAll('input[name="question_type"]');
        let selectedType = 'multiple_choice'; // Default

        for (const radioButton of radioButtons) {
            if (radioButton.checked) {
                selectedType = radioButton.value;
                break;
            }
        }

        // Update the hidden input value
        document.getElementById('question_type_hidden').value = selectedType;

        // Hide all option sections first
        document.getElementById('multiple_choice_options').classList.add('hidden');
        document.getElementById('true_false_options').classList.add('hidden');
        document.getElementById('short_answer_options').classList.add('hidden');

        // Show the selected option section with a fade-in effect
        const selectedSection = document.getElementById(`${selectedType}_options`);
        selectedSection.classList.remove('hidden');
        selectedSection.classList.add('animate-fade-in');

        // Add animation class
        setTimeout(() => {
            selectedSection.classList.remove('animate-fade-in');
        }, 500);
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Add animation class
        document.head.insertAdjacentHTML('beforeend', `
            <style>
                @keyframes fadeIn {
                    from { opacity: 0; transform: translateY(10px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                .animate-fade-in {
                    animation: fadeIn 0.3s ease-out forwards;
                }
            </style>
        `);

        // Initialize the form based on the selected question type
        toggleQuestionType();

        // Add event listeners to radio buttons
        const radioButtons = document.querySelectorAll('input[type="radio"][name="question_type"]');
        radioButtons.forEach(radio => {
            radio.addEventListener('change', toggleQuestionType);
        });
    });
</script>
@endpush
@endsection
