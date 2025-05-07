@include('components.header')
<body class="bg-gray-100 text-gray-800 flex flex-col min-h-screen">
  <main class="container mx-auto p-4 flex-grow">
    <section class="my-8">
      <h2 class="text-3xl text-blue-500 font-bold mb-4 text-center">Edit Course</h2>
      <form action="{{ route('admin.updateCourse', $course->id) }}" enctype="multipart/form-data" method="POST" class="bg-white rounded-lg shadow p-8">
        @csrf
        @method('PUT')
        <div class="mb-4">
          <label for="title" class="block text-gray-700">Course Title</label>
          <input type="text" name="title" id="title" value="{{ $course->name }}" required class="w-full p-3 border rounded" />
        </div>
        <div class="mb-4">
          <label for="description" class="block text-gray-700">Course Description</label>
          <textarea name="description" id="description" rows="4" required class="w-full p-3 border rounded">{{ $course->description }}</textarea>
        </div>
        <div class="mb-4">
          <label for="score" class="block text-gray-700">Finishing Score</label>
          <input type="number" name="score" id="score" value="{{ $course->score }}" required class="w-full p-3 border rounded" />
        </div>
        <div class="mb-4">
          <label for="category" class="block text-gray-700">Category</label>
          <select name="category" id="category" class="w-full p-3 border rounded mb-4">
            <option value="">Select Category</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ $course->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-4">
          <label for="content_type" class="block text-gray-700">Content Type</label>
          <select name="content_type" id="content_type" class="w-full p-3 border rounded mb-4" onchange="toggleContentInputs()">
            <option value="">Select Content Type</option>
            <option value="pdf" {{ $course->contents->first()->type === 'pdf' ? 'selected' : '' }}>PDF</option>
            <option value="youtube" {{ $course->contents->first()->type === 'youtube' ? 'selected' : '' }}>YouTube Video</option>
          </select>
        </div>
        <div id="pdf_input" class="{{ $course->contents->first()->type === 'pdf' ? '' : 'hidden' }} mb-4">
          <label for="pdf_file" class="block text-gray-700">Upload PDF</label>
          <input type="file" name="pdf_file" id="pdf_file" class="w-full p-3 border rounded" />
        </div>
        <div id="youtube_input" class="{{ $course->contents->first()->type === 'youtube' ? '' : 'hidden' }} mb-4">
          <label for="youtube_link" class="block text-gray-700">YouTube Video Link</label>
          <input type="text" name="youtube_link" id="youtube_link" value="{{ $course->contents->first()->type === 'youtube' ? $course->contents->first()->file : '' }}" class="w-full p-3 border rounded" placeholder="Enter YouTube video link" />
        </div>
        <iframe class="{{ $course->contents->first()->type === 'pdf' ? 'h-[750px]' : 'h-full' }} w-full border rounded mb-6" src="{{ $course->contents->first()->type === 'pdf' ? asset('storage/' . $course->contents->first()->file) : $course->contents->first()->file }}" frameborder="0" allowfullscreen></iframe>
        @if ($errors->any())
          @foreach ($errors->all() as $error)
            <div class="mt-4 p-3 bg-red-100 text-red-700 border border-red-300 rounded-md mb-4">{{ $error }}</div>
          @endforeach
        @endif
        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
          Update Course
        </button>
      </form>
    </section>
  </main>

  <script>
    function toggleContentInputs() {
      const contentType = document.getElementById('content_type').value;
      const pdfInput = document.getElementById('pdf_input');
      const youtubeInput = document.getElementById('youtube_input');

      if (contentType === 'pdf') {
        pdfInput.classList.remove('hidden');
        youtubeInput.classList.add('hidden');
      } else if (contentType === 'youtube') {
        youtubeInput.classList.remove('hidden');
        pdfInput.classList.add('hidden');
      } else {
        pdfInput.classList.add('hidden');
        youtubeInput.classList.add('hidden');
      }
    }
  </script>
</body> 