<?php echo $__env->make('components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<div class="bg-gray-100 text-gray-800 flex flex-col min-h-screen">
  <main class="container mx-auto p-4 flex-grow">
    <section class="my-8">
      <h2 class="text-3xl text-blue-500 font-bold mb-4 text-center">Add New Course</h2>
      <form action="<?php echo e(route('admin.storeCourse')); ?>" method="POST" class="bg-white rounded-lg shadow p-8 w-[50%] mt-4 mx-auto">
        
        <?php echo csrf_field(); ?>
        <div class="mb-4">
          <label for="title" class="block text-gray-700">Course Title</label>
          <input type="text" name="title" id="title" required class="w-full p-3 border rounded" />
        </div>
        <div class="mb-4">
          <label for="description" class="block text-gray-700">Course Description</label>
          <textarea name="description" id="description" rows="4" required class="w-full p-3 border rounded"></textarea>
        </div>
        <div class="mb-4">
          <label for="score" class="block text-gray-700">Finishing Score</label>
          <input type="number" name="score" id="score" required class="w-full p-3 border rounded" />
        </div>
        <button type="submit" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
          Create Course
        </button>
      </form>
    </section>
  </main>
</div> <?php /**PATH C:\Users\LENOVO\Desktop\BrightPath\resources\views/admin/create.blade.php ENDPATH**/ ?>