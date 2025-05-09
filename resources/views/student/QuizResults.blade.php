@include('components.header')
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex flex-col text-gray-800">
    <main class="container mx-auto p-4 flex-grow">
        <section class="my-12 max-w-3xl mx-auto">
            <div class="bg-white rounded-xl shadow-lg p-10 text-center mb-8">
                <h2 class="text-3xl text-blue-600 font-extrabold mb-6 drop-shadow">Quiz Results</h2>
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Quiz: {{ $quizName }}</h3>
                    <div class="flex flex-col items-center gap-2">
                        <span class="inline-block bg-blue-500 text-white text-lg font-bold px-6 py-2 rounded-full shadow mb-2">
                            Your Score: {{ $score }}
                        </span>
                        <span class="inline-block bg-green-100 text-green-700 text-sm font-semibold px-4 py-1 rounded-full">
                            Correct Answers: {{ $correctAnswers }} / {{ $totalQuestions }}
                        </span>
                    </div>
                </div>
            </div>

            @if(isset($questionDetails) && count($questionDetails) > 0)
                <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                    <h3 class="text-xl text-blue-600 font-bold mb-4">Detailed Results</h3>

                    <div class="space-y-6">
                        @foreach($questionDetails as $index => $detail)
                            <div class="border-b border-gray-200 pb-4 last:border-b-0 last:pb-0">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        @if($detail['is_correct'])
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-green-100 text-green-600">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-red-100 text-red-600">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <h4 class="text-md font-medium text-gray-800">
                                            Question {{ $index + 1 }}: {{ $detail['question'] }}
                                        </h4>

                                        <div class="mt-2 text-sm">
                                            @if($detail['type'] === 'short_answer')
                                                <div class="mb-2">
                                                    <span class="font-medium text-gray-700">Your Answer:</span>
                                                    <p class="mt-1 p-2 bg-gray-50 rounded border border-gray-200">{{ $detail['user_answer'] }}</p>
                                                </div>
                                                <div>
                                                    <span class="font-medium text-gray-700">Sample Answer:</span>
                                                    <p class="mt-1 p-2 bg-gray-50 rounded border border-gray-200">{{ $detail['correct_answer'] }}</p>
                                                </div>
                                            @else
                                                <div class="grid grid-cols-2 gap-2">
                                                    <div>
                                                        <span class="font-medium text-gray-700">Your Answer:</span>
                                                        <p class="mt-1 p-2 bg-gray-50 rounded border border-gray-200
                                                            @if($detail['is_correct']) text-green-600 border-green-200 @else text-red-600 border-red-200 @endif">
                                                            {{ $detail['user_answer'] }}
                                                        </p>
                                                    </div>
                                                    @if(!$detail['is_correct'])
                                                        <div>
                                                            <span class="font-medium text-gray-700">Correct Answer:</span>
                                                            <p class="mt-1 p-2 bg-green-50 rounded border border-green-200 text-green-600">
                                                                {{ $detail['correct_answer'] }}
                                                            </p>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="flex justify-center">
                <a href="{{ route('student.courses') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                    Back to Courses
                </a>
            </div>
        </section>
    </main>
</body>
</html>
