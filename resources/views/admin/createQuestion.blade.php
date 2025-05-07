@include('components.header')
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex flex-col text-gray-800">
  <main class="container mx-auto p-4 flex-grow">
    <section class="max-w-xl mx-auto my-12 bg-white rounded-xl shadow-lg p-8">
      <h2 class="text-3xl text-blue-600 font-extrabold mb-6 text-center drop-shadow">Add New Question</h2>
      @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
          @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
          @endforeach
        </div>
      @endif
      <form action="{{ route('admin.storeQuestion', $quizId) }}" method="POST" class="space-y-6">
        @csrf

        <div>
          <label class="block text-gray-700 font-semibold mb-2">Question</label>
          <input type="text" name="question" value="{{ old('question') }}" required class="w-full p-3 border rounded focus:ring-2 focus:ring-blue-200" />
        </div>

        <div>
          <label class="block text-gray-700 font-semibold mb-2">Answers (comma separated)</label>
          <input type="text" name="answers" value="{{ old('answers') }}" required class="w-full p-3 border rounded focus:ring-2 focus:ring-blue-200" />
        </div>

        <div>
          <label class="block text-gray-700 font-semibold mb-2">Correct Answer (index, starting from 1)</label>
          <input type="number" name="correct" value="{{ old('correct') }}" min="1" required class="w-full p-3 border rounded focus:ring-2 focus:ring-blue-200" />
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 text-white font-bold py-3 px-6 rounded-lg shadow transition duration-200">
          Save
        </button>
      </form>
    </section>
  </main>
</body>