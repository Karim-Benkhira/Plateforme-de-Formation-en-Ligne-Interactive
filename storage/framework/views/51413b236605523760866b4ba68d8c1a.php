<?php echo $__env->make('components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<body class="bg-gray-100 text-gray-800 flex flex-col min-h-screen">
  <main class="container mx-auto p-4 flex-grow">
    <section class="my-8">
      <h2 class="text-3xl text-blue-500 font-bold mb-4 text-center">Edit Course</h2>
      <form action="<?php echo e(route('admin.updateCourse', $course->id)); ?>" enctype="multipart/form-data" method="POST" class="bg-white rounded-lg shadow p-8">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="mb-4">
          <label for="title" class="block text-gray-700">Course Title</label>
          <input type="text" name="title" id="title" value="<?php echo e($course->name); ?>" required class="w-full p-3 border rounded" />
        </div>
        <div class="mb-4">
          <label for="description" class="block text-gray-700">Course Description</label>
          <textarea name="description" id="description" rows="4" required class="w-full p-3 border rounded"><?php echo e($course->description); ?></textarea>
        </div>
        <div class="mb-4">
          <label for="score" class="block text-gray-700">Finishing Score</label>
          <input type="number" name="score" id="score" value="<?php echo e($course->score); ?>" required class="w-full p-3 border rounded" />
        </div>
        <div class="mb-4">
          <label for="category" class="block text-gray-700">Category</label>
          <select name="category" id="category" class="w-full p-3 border rounded mb-4">
            <option value="">Select Category</option>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($category->id); ?>" <?php echo e($course->category_id == $category->id ? 'selected' : ''); ?>><?php echo e($category->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>
        <div class="mb-4">
          <label for="content_type" class="block text-gray-700">Content Type</label>
          <select name="content_type" id="content_type" class="w-full p-3 border rounded mb-4" onchange="toggleContentInputs()">
            <option value="">Select Content Type</option>
            <option value="pdf" <?php echo e($course->contents->first()->type === 'pdf' ? 'selected' : ''); ?>>PDF</option>
            <option value="youtube" <?php echo e($course->contents->first()->type === 'youtube' ? 'selected' : ''); ?>>YouTube Video</option>
          </select>
        </div>
        <div id="pdf_input" class="<?php echo e($course->contents->first()->type === 'pdf' ? '' : 'hidden'); ?> mb-4">
          <label for="pdf_file" class="block text-gray-700">Upload PDF</label>
          <input type="file" name="pdf_file" id="pdf_file" class="w-full p-3 border rounded" />
        </div>
        <div id="youtube_input" class="<?php echo e($course->contents->first()->type === 'youtube' ? '' : 'hidden'); ?> mb-4">
          <label for="youtube_link" class="block text-gray-700">YouTube Video Link</label>
          <input type="text" name="youtube_link" id="youtube_link" value="<?php echo e($course->contents->first()->type === 'youtube' ? $course->contents->first()->file : ''); ?>" class="w-full p-3 border rounded" placeholder="Enter YouTube video link" />
        </div>
        <iframe class="<?php echo e($course->contents->first()->type === 'pdf' ? 'h-[750px]' : 'h-full'); ?> w-full border rounded mb-6" src="<?php echo e($course->contents->first()->type === 'pdf' ? asset('storage/' . $course->contents->first()->file) : $course->contents->first()->file); ?>" frameborder="0" allowfullscreen></iframe>
        <?php if($errors->any()): ?>
          <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="mt-4 p-3 bg-red-100 text-red-700 border border-red-300 rounded-md mb-4"><?php echo e($error); ?></div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
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
</body> <?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/admin/editCourse.blade.php ENDPATH**/ ?>