<?php echo $__env->make('components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex flex-col text-gray-800">
  <main class="container mx-auto p-4 flex-grow">
    <section class="my-12 bg-white rounded-xl shadow-lg p-8 w-full max-w-3xl mx-auto">
      <h2 class="text-3xl text-blue-600 font-extrabold drop-shadow mb-6 text-center">Add New Course</h2>

      <form method="POST" action="<?php echo e(route('admin.storeCourse')); ?>" enctype="multipart/form-data" class="space-y-5">
        <?php echo csrf_field(); ?>

        <div>
          <label for="title" class="block text-gray-700 font-medium mb-2">Course Title</label>
          <input type="text" name="title" id="title" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
        </div>

        <div>
          <label for="description" class="block text-gray-700 font-medium mb-2">Course Description</label>
          <textarea name="description" id="description" rows="4" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
        </div>

        <div>
          <label for="score" class="block text-gray-700 font-medium mb-2">Finishing Score</label>
          <input type="number" name="score" id="score" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
        </div>

        <div>
          <label for="category" class="block text-gray-700 font-medium mb-2">Category</label>
          <select name="category" id="category" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">Select Category</option>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>

        <div>
          <label for="content_type" class="block text-gray-700 font-medium mb-2">Content Type</label>
          <select name="content_type" id="content_type" onchange="toggleContentInputs()" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">Select Content Type</option>
            <option value="pdf">PDF</option>
            <option value="youtube">YouTube Video</option>
          </select>
        </div>

        <div id="pdf_input" class="hidden">
          <label for="pdf_file" class="block text-gray-700 font-medium mb-2">Upload PDF</label>
          <input type="file" name="pdf_file" id="pdf_file" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
        </div>

        <div id="youtube_input" class="hidden">
          <label for="youtube_link" class="block text-gray-700 font-medium mb-2">YouTube Video Link</label>
          <input type="text" name="youtube_link" id="youtube_link" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Enter YouTube video link" />
        </div>

        <?php if($errors->any()): ?>
          <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-red-100 border border-red-300 text-red-700 p-3 rounded-lg"><?php echo e($error); ?></div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

        <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 text-white font-bold py-3 px-6 rounded-lg shadow transition duration-200">
          Create Course
        </button>
      </form>
    </section>
  </main>

  <script>
    function toggleContentInputs() {
      const contentType = document.getElementById('content_type').value;
      const pdfInput = document.getElementById('pdf_input');
      const youtubeInput = document.getElementById('youtube_input');

      pdfInput.classList.add('hidden');
      youtubeInput.classList.add('hidden');

      if (contentType === 'pdf') {
        pdfInput.classList.remove('hidden');
      } else if (contentType === 'youtube') {
        youtubeInput.classList.remove('hidden');
      }
    }
  </script>
</body>
<?php /**PATH C:\Users\LENOVO\Desktop\BrightPath\resources\views/admin/createCourse.blade.php ENDPATH**/ ?>