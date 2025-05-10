@extends('layouts.app')

@section('title', 'Edit Question')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center mb-6">
        <a href="{{ route('teacher.quizQuestions', $question->quiz_id) }}" class="mr-4 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Edit Question</h1>
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

        <form action="{{ route('teacher.updateQuestion', $question->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="question" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Question</label>
                <textarea name="question" id="question" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" required>{{ old('question', $question->question) }}</textarea>
            </div>
            
            <div>
                <label for="question_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Question Type</label>
                <select name="question_type" id="question_type" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" onchange="toggleQuestionType()">
                    <option value="multiple_choice" {{ (old('question_type', $question->type) == 'multiple_choice' || !$question->type) ? 'selected' : '' }}>Multiple Choice</option>
                    <option value="true_false" {{ old('question_type', $question->type) == 'true_false' ? 'selected' : '' }}>True/False</option>
                    <option value="short_answer" {{ old('question_type', $question->type) == 'short_answer' ? 'selected' : '' }}>Short Answer</option>
                </select>
            </div>
            
            <div id="multiple_choice_options" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Answer Options</label>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Enter each option on a new line. Mark the correct answer with an asterisk (*) at the beginning.</p>
                    <textarea name="options" id="options" rows="6" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">{{ old('options', $formattedOptions ?? '') }}</textarea>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Example:<br>Option 1<br>*Option 2 (correct)<br>Option 3</p>
                </div>
            </div>
            
            <div id="true_false_options" class="space-y-4 hidden">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Correct Answer</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="radio" id="true" name="correct_tf" value="true" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300" 
                                {{ old('correct_tf', ($question->type == 'true_false' && $question->correct == 0) ? 'true' : '') == 'true' ? 'checked' : '' }}>
                            <label for="true" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">True</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="false" name="correct_tf" value="false" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300" 
                                {{ old('correct_tf', ($question->type == 'true_false' && $question->correct == 1) ? 'false' : '') == 'false' ? 'checked' : '' }}>
                            <label for="false" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">False</label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="short_answer_options" class="space-y-4 hidden">
                <div>
                    <label for="correct_answer" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Correct Answer</label>
                    <input type="text" name="correct_answer" id="correct_answer" value="{{ old('correct_answer', $question->type == 'short_answer' ? $question->answers : '') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Enter the correct answer. Student responses will be checked against this.</p>
                </div>
            </div>
            
            <div class="pt-5 border-t border-gray-200 dark:border-gray-700">
                <div class="flex justify-end">
                    <a href="{{ route('teacher.quizQuestions', $question->quiz_id) }}" class="bg-white dark:bg-gray-700 py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Question
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Format the options for display in the textarea
    document.addEventListener('DOMContentLoaded', function() {
        const questionType = "{{ $question->type ?? 'multiple_choice' }}";
        const optionsTextarea = document.getElementById('options');
        
        if (questionType === 'multiple_choice' || !questionType) {
            const answers = "{{ $question->answers }}".split(',');
            const correctIndex = {{ $question->correct ?? 0 }};
            
            let formattedOptions = '';
            answers.forEach((answer, index) => {
                if (index === correctIndex) {
                    formattedOptions += '*' + answer + '\n';
                } else {
                    formattedOptions += answer + '\n';
                }
            });
            
            optionsTextarea.value = formattedOptions;
        }
        
        toggleQuestionType();
    });
    
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
</script>
@endpush
@endsection
