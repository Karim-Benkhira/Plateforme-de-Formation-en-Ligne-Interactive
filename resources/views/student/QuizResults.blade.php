    @include('components.header')
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex flex-col text-gray-800">
    <main class="container mx-auto p-4 flex-grow">
    <section class="my-12 max-w-xl mx-auto bg-white rounded-xl shadow-lg p-10 text-center">
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
      <a href="{{ route('student.courses') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg transition duration-200 mt-4">
                    Back to Courses
                </a>
        </section>
    </main>
</body>
</html>
