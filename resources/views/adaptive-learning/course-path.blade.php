@include('components.header')

<div class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Learning Path: {{ $course->title }}</h1>
                <p class="text-gray-600">Personalized recommendations based on your performance</p>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('student.adaptiveLearning') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to Dashboard
                </a>
                <a href="{{ route('student.adaptiveLearning.practice', $course->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                    </svg>
                    Start Practice
                </a>
            </div>
        </div>

        <!-- Performance Overview -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Performance Overview</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-blue-50 rounded-lg p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500">Mastery Level</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $learning_path['performance']['mastery_level'] }}%</p>
                        </div>
                        <div class="p-2 bg-blue-100 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="w-full bg-blue-200 rounded-full h-2.5 mt-2">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $learning_path['performance']['mastery_level'] }}%"></div>
                    </div>
                </div>
                
                <div class="bg-green-50 rounded-lg p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500">Average Score</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $learning_path['performance']['average_score'] }}%</p>
                        </div>
                        <div class="p-2 bg-green-100 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-purple-50 rounded-lg p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500">Highest Score</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $learning_path['performance']['highest_score'] }}%</p>
                        </div>
                        <div class="p-2 bg-purple-100 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-yellow-50 rounded-lg p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500">Quizzes Completed</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $learning_path['performance']['completed_quizzes'] }}/{{ $learning_path['performance']['total_quizzes'] }}</p>
                        </div>
                        <div class="p-2 bg-yellow-100 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Based on your performance, we've created a personalized learning path for you. Focus on the recommended content and practice questions to improve your understanding.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Areas for Improvement -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Areas for Improvement</h2>
                
                @if(count($learning_path['weak_areas']) > 0)
                    <div class="space-y-4">
                        @foreach($learning_path['weak_areas'] as $weakArea)
                            <div class="border-l-4 border-red-500 pl-4 py-2">
                                <h3 class="font-medium text-gray-800">{{ $weakArea['quiz_name'] }}</h3>
                                <p class="text-sm text-gray-500">Score: {{ $weakArea['score'] }}%</p>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @foreach($weakArea['questions'] as $type => $count)
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                            {{ ucfirst(str_replace('_', ' ', $type)) }} ({{ $count }})
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-gray-600">Great job! You're performing well in all areas of this course.</p>
                    </div>
                @endif
            </div>

            <!-- Recommended Practice -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Recommended Practice</h2>
                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                        Difficulty: {{ $learning_path['recommended_difficulty'] == 1 ? 'Easy' : ($learning_path['recommended_difficulty'] == 2 ? 'Medium' : 'Hard') }}
                    </span>
                </div>
                
                @if(count($learning_path['recommended_questions']) > 0)
                    <div class="space-y-4 mb-4">
                        @foreach($learning_path['recommended_questions'] as $index => $question)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <p class="font-medium text-gray-800 mb-2">{{ $index + 1 }}. {{ $question['question'] }}</p>
                                <div class="flex flex-wrap gap-2 text-sm text-gray-500">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                        {{ ucfirst(str_replace('_', ' ', $question['type'])) }}
                                    </span>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                        {{ $question['difficulty'] }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <a href="{{ route('student.adaptiveLearning.practice', $course->id) }}" class="block w-full px-4 py-2 bg-blue-600 text-white text-center rounded-md hover:bg-blue-700 transition">
                        Start Practice Session
                    </a>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-600 mb-4">No specific practice questions recommended at this time.</p>
                        <a href="{{ route('student.adaptiveLearning.practice', $course->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                            Practice Anyway
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recommended Content -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Recommended Content</h2>
            
            @if(count($learning_path['recommended_content']) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($learning_path['recommended_content'] as $content)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                @if($content['type'] === 'pdf')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="font-medium">PDF Document</span>
                                @elseif($content['type'] === 'youtube')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="font-medium">YouTube Video</span>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="font-medium">Document</span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-500 truncate mb-2">{{ $content['file'] }}</p>
                            <p class="text-xs text-blue-600">{{ ucfirst($content['relevance']) }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600 text-center py-4">No specific content recommended at this time.</p>
            @endif
        </div>
    </div>
</div>

@include('components.footer')
