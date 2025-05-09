@include('components.header')

<div class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Preview AI Generated Quiz</h1>
            <a href="{{ route('admin.showGenerateAIQuiz', $course->id) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Generator
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Quiz Information</h2>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600"><span class="font-medium">Quiz Name:</span> {{ $quizName }}</p>
                        <p class="text-gray-600"><span class="font-medium">Course:</span> {{ $course->title }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600"><span class="font-medium">Number of Questions:</span> {{ $numQuestions }}</p>
                        <p class="text-gray-600"><span class="font-medium">Difficulty:</span> {{ ucfirst($difficulty) }}</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-700">Generated Questions</h2>
                    <div class="flex space-x-2">
                        <form action="{{ route('admin.generateAIQuiz', $course->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="name" value="{{ $quizName }}">
                            <input type="hidden" name="num_questions" value="{{ $numQuestions }}">
                            <input type="hidden" name="difficulty" value="{{ $difficulty }}">
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                                Save Quiz
                            </button>
                        </form>
                        <a href="{{ route('admin.showGenerateAIQuiz', $course->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                            Regenerate
                        </a>
                    </div>
                </div>

                <div class="space-y-6 mt-6">
                    @if(empty($questions))
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        No questions were generated. Please try again with different parameters.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        @foreach($questions as $index => $question)
                            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Question {{ $index + 1 }}: {{ $question['question'] }}</h3>

                                @if($questionType === 'multiple_choice' || $questionType === 'true_false')
                                    <div class="space-y-3 ml-6">
                                        @foreach($question['options'] as $optionIndex => $option)
                                            <div class="flex items-start">
                                                <div class="flex items-center h-5">
                                                    <input type="radio" disabled {{ $optionIndex == $question['correct_index'] ? 'checked' : '' }}
                                                        class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label class="font-medium text-gray-700 {{ $optionIndex == $question['correct_index'] ? 'text-green-600' : '' }}">
                                                        {{ $option }}
                                                        @if($optionIndex == $question['correct_index'])
                                                            <span class="ml-2 text-green-600">(Correct Answer)</span>
                                                        @endif
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif($questionType === 'short_answer')
                                    <div class="ml-6">
                                        <div class="mb-2 text-sm font-medium text-gray-700">Sample Answer:</div>
                                        <div class="p-3 bg-white border border-gray-300 rounded-md text-gray-700">
                                            {{ $question['sample_answer'] }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('components.footer')
