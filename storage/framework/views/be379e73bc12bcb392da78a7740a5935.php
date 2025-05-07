<?php echo $__env->make('components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex flex-col text-gray-800">
  <main class="container mx-auto p-4 flex-grow">
    <section class="my-12">
      <h2 class="text-3xl text-blue-600 font-extrabold mb-8 text-center drop-shadow">Quiz: <?php echo e($quiz->name); ?></h2>
      <form id="quizForm" action="<?php echo e(route('student.submitQuiz', $quiz->id)); ?>" method="POST" class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-8 space-y-8">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="quiz_id" value="<?php echo e($quiz->id); ?>">
        <?php if(count($quiz->questions) > 0): ?>
          <?php $__currentLoopData = $quiz->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="mb-8 bg-blue-50 rounded-lg shadow p-6">
              <h3 class="text-lg font-bold mb-4">
                <span class="text-blue-600">Q<?php echo e($index + 1); ?>:</span> <?php echo e($question->question); ?>

              </h3>
              <?php $answers = explode(',', $question->answers); ?>
              <div class="space-y-3">
                <?php $__currentLoopData = $answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answerIndex => $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <label class="block w-full">
                    <input
                      type="radio"
                      name="answers[<?php echo e($question->id); ?>]"
                      value="<?php echo e($answerIndex); ?>"
                      class="peer hidden"
                      id="answer<?php echo e($question->id); ?>_<?php echo e($answerIndex); ?>"
                      required
                    />
                    <span class="block w-full bg-white border border-gray-300 rounded px-4 py-3 text-center text-gray-800 cursor-pointer transition
                      peer-checked:bg-blue-100 peer-checked:border-blue-500
                      hover:bg-gray-100 hover:border-blue-400">
                      <?php echo e(trim($answer)); ?>

                    </span>
                  </label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
          <div class="text-center text-gray-500">No questions available for this quiz.</div>
        <?php endif; ?>
        <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-bold py-3 px-6 rounded-lg shadow transition duration-200">
          Submit Quiz
        </button>
      </form>
    </section>
  </main>
</body>
</html><?php /**PATH C:\Users\LENOVO\Desktop\BrightPath\resources\views/student/quiz.blade.php ENDPATH**/ ?>