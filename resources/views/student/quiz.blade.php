@include('components.header')
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex flex-col text-gray-800">
  <main class="container mx-auto p-4 flex-grow">
    <section class="my-12">
      <h2 class="text-3xl text-blue-600 font-extrabold mb-8 text-center drop-shadow">Quiz: {{ $quiz->name }}</h2>
      <form id="quizForm" action="{{ route('student.submitQuiz', $quiz->id) }}" method="POST" class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-8 space-y-8">
        @csrf
        <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
        @if(count($quiz->questions) > 0)
          @foreach($quiz->questions as $index => $question)
            <div class="mb-8 bg-blue-50 rounded-lg shadow p-6">
              <h3 class="text-lg font-bold mb-4">
                <span class="text-blue-600">Q{{ $index + 1 }}:</span> {{ $question->question }}
              </h3>
              @php $answers = explode(',', $question->answers); @endphp
              <div class="space-y-3">
                @foreach($answers as $answerIndex => $answer)
                  <label class="block w-full">
                    <input
                      type="radio"
                      name="answers[{{ $question->id }}]"
                      value="{{ $answerIndex }}"
                      class="peer hidden"
                      id="answer{{ $question->id }}_{{ $answerIndex }}"
                      required
                    />
                    <span class="block w-full bg-white border border-gray-300 rounded px-4 py-3 text-center text-gray-800 cursor-pointer transition
                      peer-checked:bg-blue-100 peer-checked:border-blue-500
                      hover:bg-gray-100 hover:border-blue-400">
                      {{ trim($answer) }}
                    </span>
                  </label>
                @endforeach
              </div>
            </div>
          @endforeach
        @else
          <div class="text-center text-gray-500">No questions available for this quiz.</div>
        @endif
        <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-bold py-3 px-6 rounded-lg shadow transition duration-200">
          Submit Quiz
        </button>
      </form>
    </section>
  </main>
</body>
</html>