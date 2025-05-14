@extends('layouts.admin')

@section('title', 'Preview AI Quiz')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-blue-900 via-primary-800 to-secondary-900 rounded-xl shadow-2xl p-6 mb-8 border border-blue-700/30 relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-white/[0.05] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-purple-500/10"></div>
    <div class="relative flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2 flex items-center">
                <i class="fas fa-eye mr-3 text-blue-300"></i>
                Preview AI Generated Quiz
            </h1>
            <p class="text-blue-100 opacity-90">Review the generated questions before saving</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('admin.showGenerateAIQuiz', $course->id) }}" class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg shadow-lg border border-gray-700 transition duration-200 inline-flex items-center group">
                <i class="fas fa-arrow-left mr-2 group-hover:transform group-hover:-translate-x-1 transition-transform"></i> Back to Generator
            </a>
        </div>
    </div>
</div>

<!-- Quiz Information Card -->
<div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 shadow-xl relative overflow-hidden mb-6">
    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/5 to-blue-800/5"></div>
    <div class="relative">
        <h2 class="text-xl font-bold text-white flex items-center mb-6 pb-3 border-b border-gray-700/50">
            <div class="bg-blue-900/70 text-blue-400 rounded-lg p-2 mr-3 shadow-inner shadow-blue-950/50">
                <i class="fas fa-info-circle"></i>
            </div>
            <span>Quiz Information</span>
        </h2>
        
        <div class="grid md:grid-cols-2 gap-6">
            <div class="space-y-3">
                <div class="flex items-center">
                    <div class="w-32 text-gray-400 font-medium">Quiz Name:</div>
                    <div class="text-white">{{ $quizName }}</div>
                </div>
                <div class="flex items-center">
                    <div class="w-32 text-gray-400 font-medium">Course:</div>
                    <div class="text-white">{{ $course->title }}</div>
                </div>
            </div>
            <div class="space-y-3">
                <div class="flex items-center">
                    <div class="w-32 text-gray-400 font-medium">Questions:</div>
                    <div class="text-white">{{ $numQuestions }}</div>
                </div>
                <div class="flex items-center">
                    <div class="w-32 text-gray-400 font-medium">Difficulty:</div>
                    <div class="text-white">{{ ucfirst($difficulty) }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Generated Questions -->
<div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 shadow-xl relative overflow-hidden mb-6">
    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-green-600/5 to-green-800/5"></div>
    <div class="relative">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6 pb-3 border-b border-gray-700/50">
            <h2 class="text-xl font-bold text-white flex items-center">
                <div class="bg-green-900/70 text-green-400 rounded-lg p-2 mr-3 shadow-inner shadow-green-950/50">
                    <i class="fas fa-question-circle"></i>
                </div>
                <span>Generated Questions</span>
            </h2>
            
            <div class="flex gap-3">
                <form action="{{ route('admin.generateAIQuiz', $course->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="name" value="{{ $quizName }}">
                    <input type="hidden" name="num_questions" value="{{ $numQuestions }}">
                    <input type="hidden" name="difficulty" value="{{ $difficulty }}">
                    <input type="hidden" name="question_type" value="{{ $questionType }}">
                    <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-500 hover:to-green-600 text-white font-medium rounded-lg shadow-lg transition duration-300 flex items-center group">
                        <i class="fas fa-save mr-2 group-hover:scale-110 transition-transform duration-200"></i> Save Quiz
                    </button>
                </form>
                
                <a href="{{ route('admin.showGenerateAIQuiz', $course->id) }}" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-500 hover:to-blue-600 text-white font-medium rounded-lg shadow-lg transition duration-300 flex items-center group">
                    <i class="fas fa-sync-alt mr-2 group-hover:scale-110 transition-transform duration-200"></i> Regenerate
                </a>
            </div>
        </div>
        
        @if(isset($questions) && count($questions) > 0)
            <div class="space-y-6">
                @foreach($questions as $index => $question)
                    <div class="bg-gray-800/50 rounded-lg p-5 border border-gray-700/50 shadow-inner">
                        <div class="flex items-start">
                            <div class="bg-blue-900/50 text-blue-400 rounded-full w-8 h-8 flex items-center justify-center mr-3 flex-shrink-0 mt-0.5 border border-blue-700/50">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-medium text-white mb-4">{{ $question['question'] }}</h3>
                                
                                @if($questionType === 'multiple_choice' || $questionType === 'true_false')
                                    <div class="space-y-3 ml-6">
                                        @foreach($question['options'] as $optionIndex => $option)
                                            <div class="flex items-start">
                                                <div class="flex items-center h-5">
                                                    <input type="radio" disabled {{ $optionIndex == $question['correct_index'] ? 'checked' : '' }}
                                                        class="h-4 w-4 text-blue-600 border-gray-700 focus:ring-blue-500 bg-gray-700">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label class="font-medium {{ $optionIndex == $question['correct_index'] ? 'text-green-400' : 'text-gray-300' }}">
                                                        {{ $option }}
                                                        @if($optionIndex == $question['correct_index'])
                                                            <span class="ml-2 text-green-500 text-xs">(Correct Answer)</span>
                                                        @endif
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif($questionType === 'short_answer')
                                    <div class="ml-6">
                                        <div class="mb-2 text-sm font-medium text-gray-400">Sample Answer:</div>
                                        <div class="p-3 bg-gray-900/50 border border-gray-700/50 rounded-md text-green-400">
                                            {{ $question['sample_answer'] }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="py-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-800/80 text-gray-400 mb-4">
                    <i class="fas fa-exclamation-circle text-2xl"></i>
                </div>
                <h3 class="text-xl font-medium text-gray-400 mb-2">No Questions Generated</h3>
                <p class="text-gray-500">There was an issue generating questions. Please try again.</p>
            </div>
        @endif
    </div>
</div>
@endsection
