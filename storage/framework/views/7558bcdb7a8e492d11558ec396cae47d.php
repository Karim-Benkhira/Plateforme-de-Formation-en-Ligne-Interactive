<?php echo $__env->make('components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex flex-col text-gray-800">
  <main class="container mx-auto p-4 flex-grow">
    <section class="max-w-xl mx-auto my-12 bg-white rounded-xl shadow-lg p-8">
      <h2 class="text-3xl text-blue-600 font-extrabold mb-6 text-center drop-shadow">Edit Quiz</h2>
      <?php if($errors->any()): ?>
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
          <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div><?php echo e($error); ?></div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      <?php endif; ?>
      <form action="<?php echo e(route('admin.updateQuiz', $quiz->id)); ?>" method="POST" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div>
          <label class="block text-gray-700 font-semibold mb-2">Quiz Name</label>
          <input type="text" name="name" value="<?php echo e(old('name', $quiz->name)); ?>" required class="w-full p-3 border rounded focus:ring-2 focus:ring-blue-200" />
        </div>

        <div>
          <label class="block text-gray-700 font-semibold mb-2">Select Course</label>
          <select name="course_id" class="w-full p-3 border rounded focus:ring-2 focus:ring-blue-200" required>
            <option value="">Select Course</option>
            <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($course->id); ?>" <?php echo e((old('course_id', $quiz->course_id) == $course->id) ? 'selected' : ''); ?>><?php echo e($course->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-bold py-3 px-6 rounded-lg shadow transition duration-200">
          Update Quiz
        </button>
      </form>
    </section>
  </main>

  <!-- Footer -->
  <footer class="bg-white border-t p-4 text-center">
    <p class="text-gray-600">&copy; 2023 BrightPath Admin.</p>
  </footer>
</body> <?php /**PATH C:\Users\LENOVO\Desktop\BrightPath\resources\views/admin/editQuiz.blade.php ENDPATH**/ ?>