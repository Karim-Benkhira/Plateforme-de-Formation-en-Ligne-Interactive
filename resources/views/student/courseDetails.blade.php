@include('components.header')

<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex flex-col text-gray-800">
  <main class="container mx-auto p-4 flex-grow">
    <section class="my-12 bg-white p-10 rounded-xl shadow-lg w-[70%] mx-auto">
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
      <div class="mt-10 text-center flex flex-col md:flex-row justify-between gap-4">
        <a href="{{ route('student.courses') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
          ← Back to Courses
        </a>
        @if($course->quizzes->isNotEmpty())
          <a href="{{ route('student.quiz', $course->quizzes[0]->id) }}" class="inline-block bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
            Take Quiz →
          </a>
        @else
          <span class="inline-block bg-gray-300 text-gray-700 font-semibold py-2 px-6 rounded-lg cursor-not-allowed">
            No Quiz Available
          </span>
        @endif
      </div>
    </section>
  </main>
</body>
