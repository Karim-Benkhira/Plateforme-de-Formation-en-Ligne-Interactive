@include('components.header')
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex flex-col text-gray-800">
  <main class="container mx-auto p-4 flex-grow">
    <section class="my-12 bg-white rounded-xl shadow-lg p-10 w-[70%] mx-auto">
      <h2 class="text-4xl text-blue-600 font-extrabold mb-6 text-center drop-shadow">{{ $course->name }}</h2>
      <div class="text-lg text-gray-700 space-y-2 mb-6 text-center">
        <p>{{ $course->description }}</p>
        <p><span class="font-semibold text-gray-900">Finishing Score:</span> {{ $course->score }}</p>
      </div>
      <h3 class="text-2xl text-blue-500 font-bold mb-4 border-b border-blue-200 pb-2">Course Content</h3>
      <div class="space-y-6">
        @if(count($course->contents) > 0)
          @foreach($course->contents as $content)
            <div class="bg-gray-50 border border-gray-200 p-4 rounded-lg shadow-sm">
              @if($content->type === 'pdf')
                <h4 class="text-xl font-semibold text-gray-800 mb-2">PDF Document</h4>
                <iframe src="{{ asset('storage/' . $content->file) }}" class="w-full h-[750px] border rounded" frameborder="0"></iframe>
                <p class="text-sm text-gray-500 mt-2">
                  <a href="{{ asset('storage/' . $content->file) }}" class="text-blue-500 hover:underline" target="_blank">Download PDF</a>
                </p>
              @elseif($content->type === 'youtube')
                <h4 class="text-xl font-semibold text-gray-800 mb-2">YouTube Video</h4>
                <div class="aspect-w-16 aspect-h-9">
                  <iframe src="{{ $content->file }}" class="w-full h-full rounded border" frameborder="0" allowfullscreen></iframe>
                </div>
              @endif
            </div>
          @endforeach
        @else
          <div class="text-center text-gray-500">No content available for this course.</div>
        @endif
      </div>
      <h3 class="text-2xl text-blue-500 font-bold mb-4 border-b border-blue-200 pb-2 mt-10">Quizzes</h3>
      <div class="space-y-6">
        @if(count($course->quizzes) > 0)
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($course->quizzes as $quiz)
              <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 hover:shadow-md transition">
                <div class="flex justify-between items-start">
                  <div>
                    <h4 class="text-lg font-semibold text-gray-800">{{ $quiz->name }}</h4>
                    <p class="text-sm text-gray-500">
                      {{ $quiz->questions->count() }} questions
                      @if($quiz->is_ai_generated)
                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                          AI Generated
                        </span>
                      @endif
                    </p>
                  </div>
                  <a href="{{ route('admin.quizQuestions', $quiz->id) }}" class="text-blue-500 hover:text-blue-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" />
                      <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" />
                    </svg>
                  </a>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <div class="text-center text-gray-500 mb-4">No quizzes available for this course.</div>
        @endif

        <div class="flex flex-wrap justify-center gap-4 mt-6">
          <a href="{{ route('admin.createQuiz') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Create Manual Quiz
          </a>
          <a href="{{ route('admin.showGenerateAIQuiz', $course->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
              <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
            </svg>
            Generate AI Quiz
          </a>
        </div>
      </div>

      <div class="mt-10 text-center flex flex-col md:flex-row justify-between gap-4">
        <a href="{{ route('admin.courses') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
          ← Back to Courses
        </a>
        <a href="{{ route('admin.editCourse', $course->id) }}" class="inline-block bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
          Edit Course
        </a>
      </div>
    </section>
  </main>
</body>
