@include('components.header')
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex flex-col text-gray-800">
  <main class="container mx-auto p-4 flex-grow">
    <section class="my-12 bg-white rounded-xl shadow-lg p-8">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <h2 class="text-3xl text-blue-600 font-extrabold drop-shadow">{{ $quiz->name }} - Questions</h2>
        <a href="{{ route('admin.createQuestion', $quiz->id) }}" class="bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 text-white font-bold py-2 px-6 rounded-lg shadow transition duration-200">
          Add Question
        </a>
      </div>
      <div class="overflow-x-auto">
        <table class="w-[90%] mx-auto text-center border-collapse bg-white shadow-lg">
          <thead>
            <tr>
              <th class="border-b-2 p-3 text-blue-700">Question</th>
              <th class="border-b-2 p-3 text-blue-700">Answers</th>
              <th class="border-b-2 p-3 text-blue-700">Correct Answer</th>
              <th class="border-b-2 p-3 text-blue-700">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($quiz->questions as $question)
              <tr class="{{ $loop->even ? 'bg-blue-50' : '' }}">
                <td class="p-3">{{ $question->question }}</td>
                <td class="p-3 max-w-[300px]">{{ $question->answers }}</td>
                <td class="p-3">
                    @php
                        $answers = explode(',', $question->answers);
                        $correctIndex = $question->correct ;
                    @endphp
                    {{ $answers[$correctIndex] ?? 'N/A' }}
                </td>
                <td class="p-3">
                  <a href="{{ route('admin.editQuestion', $question->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded transition">Edit</a>
                  <form action="{{ route('admin.deleteQuestion', $question->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded transition" onclick="return confirm('Are you sure?')">Delete</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </section>
  </main>
</body>