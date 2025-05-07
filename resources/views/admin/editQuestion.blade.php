@include('components.header')
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex flex-col text-gray-800">
  <main class="container mx-auto p-4 flex-grow">
    <section class="max-w-xl mx-auto my-12 bg-white rounded-xl shadow-lg p-8">
      <h2 class="text-3xl text-blue-600 font-extrabold mb-6 text-center drop-shadow">Edit Question</h2>
      @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
          @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
          @endforeach
        </div>
      @endif
      <form action="{{ route('admin.updateQuestion', $question->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
          <label class="block text-gray-700 font-semibold mb-2">Question</label>
          <input type="text" name="question" value="{{ old('question', $question->question) }}" required class="w-full p-3 border rounded focus:ring-2 focus:ring-blue-200" />
        </div>

        <div>
          <label class="block text-gray-700 font-semibold mb-2">Answers (comma separated)</label>
          <input type="text" name="answers" value="{{ old('answers', $question->answers) }}" required class="w-full p-3 border rounded focus:ring-2 focus:ring-blue-200" />
        </div>

        <div>
          <label class="block text-gray-700 font-semibold mb-2">Correct Answer (index, starting from 1)</label>
          <input type="number" name="correct" value="{{ old('correct', $question->correct + 1) }}" min="1" required class="w-full p-3 border rounded focus:ring-2 focus:ring-blue-200" />
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-bold py-3 px-6 rounded-lg shadow transition duration-200">
          Update
        </button>
      </form>
    </section>
  </main>
</body>