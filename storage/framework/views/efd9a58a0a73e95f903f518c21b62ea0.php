<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex flex-col text-gray-800">
  <?php echo $__env->make('components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <main class="container mx-auto p-4 flex-grow">
    <section class="w-[60%] mx-auto my-8">
      <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h2 class="text-2xl text-blue-600 font-extrabold mb-4 text-center">Support Guidelines</h2>
        <ul class="list-disc list-inside text-gray-700 space-y-2">
          <li>Please describe your issue or suggestion clearly and concisely.</li>
          <li>Do not submit duplicate requests for the same issue.</li>
          <li>Check the FAQ or course instructions before submitting a technical issue.</li>
          <li>Our support team will respond as soon as possible. You can track your requests below.</li>
        </ul>
      </div>

      <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <h2 class="text-xl text-blue-600 font-extrabold mb-4 text-center">Submit a Reclamation</h2>
        <?php if(session('success')): ?>
          <div class="mb-4 p-3 bg-green-100 text-green-700 rounded"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
          <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div><?php echo e($error); ?></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        <?php endif; ?>
        <form action="<?php echo e(route('student.support.submit')); ?>" method="POST" class="space-y-4">
          <?php echo csrf_field(); ?>
          <textarea name="message" rows="5" placeholder="Describe your issue or suggestion..." required class="w-full p-3 border rounded"></textarea>
          <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-bold py-2 px-4 rounded">
            Submit Request
          </button>
        </form>
      </div>

      <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-xl text-blue-600 font-extrabold mb-4 text-center">Your Reclamations</h2>
        <?php if(count($reclamations) > 0): ?>
          <div class="overflow-x-auto">
            <table class="w-full border-collapse text-center">
              <thead>
                <tr>
                  <th class="border-b-2 p-2 text-blue-700">Date</th>
                  <th class="border-b-2 p-2 text-blue-700">Message</th>
                  <th class="border-b-2 p-2 text-blue-700">Status</th>
                  <th class="border-b-2 p-2 text-blue-700">Response</th>
                  <th class="border-b-2 p-2 text-blue-700">Agent</th>
                </tr>
              </thead>
              <tbody class="text-gray-600">
                <?php $__currentLoopData = $reclamations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr class="<?php echo e($loop->even ? 'bg-blue-50' : ''); ?>">
                    <td class="p-2 text-sm"><?php echo e($rec->created_at->format('Y-m-d H:i')); ?></td>
                    <td class="p-2 text-sm"><?php echo e($rec->message); ?></td>
                    <td class="p-2 text-sm">
                      <span class="inline-block px-3 py-1 rounded-full text-white <?php echo e($rec->status === 'resolved' ? 'bg-green-500' : 'bg-yellow-500'); ?>">
                        <?php echo e(ucfirst($rec->status)); ?>

                      </span>
                    </td>
                    <td class="p-2 text-sm"><?php echo e($rec->response ?? '-'); ?></td>
                    <td class="p-2 text-sm"><?php echo e($rec->agent->name ?? '-'); ?></td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <div class="text-center text-gray-500">You have not submitted any reclamations yet.</div>
        <?php endif; ?>
      </div>
    </section>
  </main>
</body>
<?php /**PATH C:\Users\LENOVO\Desktop\BrightPath\resources\views/student/support.blade.php ENDPATH**/ ?>