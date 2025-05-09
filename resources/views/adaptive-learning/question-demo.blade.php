@include('components.header')

<div class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Interactive Question Types Demo</h1>
                <p class="text-gray-600">Explore different types of interactive questions</p>
            </div>
            <div>
                <a href="{{ route('student.adaptiveLearning') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to Dashboard
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex items-center mb-6">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Interactive Learning Experience</h2>
                    <p class="text-gray-600">Our platform offers various types of interactive questions to enhance your learning experience</p>
                </div>
            </div>
            
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            This demo showcases the different types of interactive questions available on our platform. Try them out to get familiar with how they work before taking actual quizzes.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Multiple Choice Question -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-lg font-medium text-gray-800">Multiple Choice Question</h3>
                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                    Standard
                </span>
            </div>
            
            <div class="mb-4">
                <p class="text-gray-800 mb-2">What is the capital of France?</p>
            </div>
            
            <div class="space-y-2 mb-4">
                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                    <input type="radio" name="demo_mc" value="0" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                    <span class="ml-3 text-gray-700">London</span>
                </label>
                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                    <input type="radio" name="demo_mc" value="1" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                    <span class="ml-3 text-gray-700">Paris</span>
                </label>
                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                    <input type="radio" name="demo_mc" value="2" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                    <span class="ml-3 text-gray-700">Berlin</span>
                </label>
                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                    <input type="radio" name="demo_mc" value="3" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                    <span class="ml-3 text-gray-700">Madrid</span>
                </label>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">
                    <span class="font-medium">About this question type:</span> Multiple choice questions present several options, and you need to select the correct answer. These questions test your knowledge recall and understanding of concepts.
                </p>
            </div>
        </div>
        
        <!-- True/False Question -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-lg font-medium text-gray-800">True/False Question</h3>
                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                    Simple
                </span>
            </div>
            
            <div class="mb-4">
                <p class="text-gray-800 mb-2">The Earth is the third planet from the Sun.</p>
            </div>
            
            <div class="space-y-2 mb-4">
                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                    <input type="radio" name="demo_tf" value="true" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                    <span class="ml-3 text-gray-700">True</span>
                </label>
                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                    <input type="radio" name="demo_tf" value="false" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                    <span class="ml-3 text-gray-700">False</span>
                </label>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">
                    <span class="font-medium">About this question type:</span> True/False questions present a statement, and you need to determine whether it's true or false. These questions test your ability to evaluate the accuracy of information.
                </p>
            </div>
        </div>
        
        <!-- Matching Question -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-lg font-medium text-gray-800">Matching Question</h3>
                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                    Advanced
                </span>
            </div>
            
            <div class="mb-4">
                <p class="text-gray-800 mb-2">Match each country with its capital city:</p>
            </div>
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="space-y-2">
                    <div class="p-3 border border-gray-200 rounded-lg bg-gray-50">
                        1. France
                    </div>
                    <div class="p-3 border border-gray-200 rounded-lg bg-gray-50">
                        2. Japan
                    </div>
                    <div class="p-3 border border-gray-200 rounded-lg bg-gray-50">
                        3. Egypt
                    </div>
                    <div class="p-3 border border-gray-200 rounded-lg bg-gray-50">
                        4. Brazil
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="p-3 border border-gray-200 rounded-lg">
                        <select class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Select match --</option>
                            <option value="0">1</option>
                            <option value="1">2</option>
                            <option value="2">3</option>
                            <option value="3">4</option>
                        </select>
                        <span class="ml-2">Tokyo</span>
                    </div>
                    <div class="p-3 border border-gray-200 rounded-lg">
                        <select class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Select match --</option>
                            <option value="0">1</option>
                            <option value="1">2</option>
                            <option value="2">3</option>
                            <option value="3">4</option>
                        </select>
                        <span class="ml-2">Cairo</span>
                    </div>
                    <div class="p-3 border border-gray-200 rounded-lg">
                        <select class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Select match --</option>
                            <option value="0">1</option>
                            <option value="1">2</option>
                            <option value="2">3</option>
                            <option value="3">4</option>
                        </select>
                        <span class="ml-2">Paris</span>
                    </div>
                    <div class="p-3 border border-gray-200 rounded-lg">
                        <select class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Select match --</option>
                            <option value="0">1</option>
                            <option value="1">2</option>
                            <option value="2">3</option>
                            <option value="3">4</option>
                        </select>
                        <span class="ml-2">Brasília</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">
                    <span class="font-medium">About this question type:</span> Matching questions require you to match items from two different columns. These questions test your ability to associate related concepts and understand relationships between items.
                </p>
            </div>
        </div>
        
        <!-- Fill in the Blanks Question -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-lg font-medium text-gray-800">Fill in the Blanks Question</h3>
                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                    Interactive
                </span>
            </div>
            
            <div class="mb-4">
                <p class="text-gray-800 mb-2">Fill in the blanks with the correct words:</p>
            </div>
            
            <div class="mb-4">
                <p class="text-gray-700">
                    The process of photosynthesis converts 
                    <input type="text" class="border-b-2 border-gray-300 focus:border-blue-500 focus:outline-none px-1 w-32"> 
                    and 
                    <input type="text" class="border-b-2 border-gray-300 focus:border-blue-500 focus:outline-none px-1 w-32"> 
                    into 
                    <input type="text" class="border-b-2 border-gray-300 focus:border-blue-500 focus:outline-none px-1 w-32"> 
                    and 
                    <input type="text" class="border-b-2 border-gray-300 focus:border-blue-500 focus:outline-none px-1 w-32">.
                </p>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">
                    <span class="font-medium">About this question type:</span> Fill in the blanks questions require you to complete a sentence or paragraph by filling in missing words. These questions test your recall of specific terms and understanding of concepts in context.
                </p>
            </div>
        </div>
        
        <!-- Drag and Drop Question -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-lg font-medium text-gray-800">Drag and Drop Question</h3>
                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                    Interactive
                </span>
            </div>
            
            <div class="mb-4">
                <p class="text-gray-800 mb-2">Arrange the following events in chronological order:</p>
            </div>
            
            <div class="mb-4">
                <div class="space-y-2">
                    <div class="p-3 border border-gray-200 rounded-lg bg-gray-50 flex justify-between items-center">
                        <span>World War II</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="p-3 border border-gray-200 rounded-lg bg-gray-50 flex justify-between items-center">
                        <span>The Industrial Revolution</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="p-3 border border-gray-200 rounded-lg bg-gray-50 flex justify-between items-center">
                        <span>The Renaissance</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="p-3 border border-gray-200 rounded-lg bg-gray-50 flex justify-between items-center">
                        <span>The Digital Revolution</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">
                    <span class="font-medium">About this question type:</span> Drag and drop questions require you to arrange items in a specific order or group them into categories. These questions test your ability to organize information and understand sequences or classifications.
                </p>
                <p class="text-sm text-gray-500 mt-2 italic">Note: This is a static demo. In actual quizzes, you'll be able to drag and reorder the items.</p>
            </div>
        </div>
        
        <div class="text-center">
            <a href="{{ route('student.adaptiveLearning') }}" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition inline-block">
                Back to Adaptive Learning Dashboard
            </a>
        </div>
    </div>
</div>

@include('components.footer')
