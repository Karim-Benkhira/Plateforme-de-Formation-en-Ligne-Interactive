@extends('layouts.app')

@section('title', 'Create Question')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-6">
        <a href="{{ route('teacher.quizQuestions', $quizId) }}" class="mr-4 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Add Question to {{ $quiz->name }}</h1>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p class="font-bold">Error</p>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('teacher.storeQuestion', $quizId) }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label for="question" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Question</label>
                <textarea name="question" id="question" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>{{ old('question') }}</textarea>
            </div>
            
            <div>
                <label for="question_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Question Type</label>
                <select name="question_type" id="question_type" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" onchange="toggleQuestionType()">
                    <option value="multiple_choice" {{ old('question_type') == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                    <option value="true_false" {{ old('question_type') == 'true_false' ? 'selected' : '' }}>True/False</option>
                    <option value="short_answer" {{ old('question_type') == 'short_answer' ? 'selected' : '' }}>Short Answer</option>
                </select>
            </div>
            
            <div id="multiple_choice_options" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Answer Options</label>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Enter each option on a new line. Mark the correct answer with an asterisk (*) at the beginning.</p>
                    <textarea name="options" id="options" rows="6" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">{{ old('options') }}</textarea>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Example:<br>Option 1<br>*Option 2 (correct)<br>Option 3</p>
                </div>
            </div>
            
            <div id="true_false_options" class="space-y-4 hidden">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Correct Answer</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="radio" id="true" name="correct_tf" value="true" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300" {{ old('correct_tf') == 'true' ? 'checked' : '' }}>
                            <label for="true" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">True</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="false" name="correct_tf" value="false" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300" {{ old('correct_tf') == 'false' ? 'checked' : '' }}>
                            <label for="false" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">False</label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="short_answer_options" class="space-y-4 hidden">
                <div>
                    <label for="correct_answer" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Correct Answer</label>
                    <input type="text" name="correct_answer" id="correct_answer" value="{{ old('correct_answer') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Enter the correct answer. Student responses will be checked against this.</p>
                </div>
            </div>
            
            <div class="pt-5 border-t border-gray-200 dark:border-gray-700">
                <div class="flex justify-end">
                    <a href="{{ route('teacher.quizQuestions', $quizId) }}" class="bg-white dark:bg-gray-700 py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Add Question
                    </button>
                </div>
            </div>
        </form>
    </div>
    
    <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Tips for Creating Effective Questions</h2>
        
        <div class="space-y-4">
            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-md">
                <h3 class="font-bold text-blue-700 dark:text-blue-300 mb-2">Multiple Choice Questions</h3>
                <ul class="list-disc pl-5 space-y-1 text-gray-700 dark:text-gray-300">
                    <li>Keep options similar in length and structure</li>
                    <li>Avoid using "All of the above" or "None of the above"</li>
                    <li>Make sure there is only one clearly correct answer</li>
                    <li>Use plausible distractors that test common misconceptions</li>
                </ul>
            </div>
            
            <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-md">
                <h3 class="font-bold text-green-700 dark:text-green-300 mb-2">True/False Questions</h3>
                <ul class="list-disc pl-5 space-y-1 text-gray-700 dark:text-gray-300">
                    <li>Avoid using absolute terms like "always" or "never"</li>
                    <li>Keep statements clear and unambiguous</li>
                    <li>Focus on testing important concepts, not trivial details</li>
                    <li>Ensure statements are completely true or completely false</li>
                </ul>
            </div>
            
            <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-md">
                <h3 class="font-bold text-purple-700 dark:text-purple-300 mb-2">Short Answer Questions</h3>
                <ul class="list-disc pl-5 space-y-1 text-gray-700 dark:text-gray-300">
                    <li>Be specific about what you're asking for</li>
                    <li>Consider alternative correct answers or spellings</li>
                    <li>Keep the required answer brief (1-3 words is ideal)</li>
                    <li>Use for testing recall of key terms or concepts</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function toggleQuestionType() {
        const questionType = document.getElementById('question_type').value;
        
        // Hide all option sections first
        document.getElementById('multiple_choice_options').classList.add('hidden');
        document.getElementById('true_false_options').classList.add('hidden');
        document.getElementById('short_answer_options').classList.add('hidden');
        
        // Show the selected option section
        if (questionType === 'multiple_choice') {
            document.getElementById('multiple_choice_options').classList.remove('hidden');
        } else if (questionType === 'true_false') {
            document.getElementById('true_false_options').classList.remove('hidden');
        } else if (questionType === 'short_answer') {
            document.getElementById('short_answer_options').classList.remove('hidden');
        }
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleQuestionType();
    });
</script>
@endpush
@endsection
