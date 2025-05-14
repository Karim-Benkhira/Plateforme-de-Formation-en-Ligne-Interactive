

<?php $__env->startSection('title', $quiz->name . ' - Questions'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    @keyframes pulse-slow {
        0%, 100% {
            opacity: 0.2;
        }
        50% {
            opacity: 0;
        }
    }
    .animate-pulse-slow {
        animation: pulse-slow 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    .bg-grid-white {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23FFFFFF' fill-opacity='0.1'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    /* Tooltip styles */
    .tooltip-trigger {
        position: relative;
    }

    .tooltip-text {
        visibility: hidden;
        position: absolute;
        bottom: 125%;
        left: 50%;
        transform: translateX(-50%);
        background-color: rgba(17, 24, 39, 0.95);
        color: #e2e8f0;
        text-align: center;
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 12px;
        white-space: nowrap;
        opacity: 0;
        transition: opacity 0.3s, visibility 0.3s;
        z-index: 10;
        border: 1px solid rgba(75, 85, 99, 0.3);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .tooltip-trigger:hover .tooltip-text {
        visibility: visible;
        opacity: 1;
    }

    /* Add a small arrow at the bottom of the tooltip */
    .tooltip-text::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: rgba(17, 24, 39, 0.95) transparent transparent transparent;
    }

    /* Question card styles */
    .question-row {
        transition: all 0.3s ease;
    }

    .question-row:hover {
        transform: translateY(-2px);
    }

    .question-text {
        position: relative;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .answers-list {
        position: relative;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="bg-gradient-to-r from-blue-900 via-primary-800 to-secondary-900 rounded-xl shadow-2xl p-6 mb-8 border border-blue-700/30 relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-white/[0.05] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-purple-500/10"></div>
    <div class="relative flex flex-col md:flex-row justify-between items-center">
        <div>
            <div class="flex items-center mb-2">
                <a href="<?php echo e(route('admin.quizzes')); ?>" class="text-blue-300 hover:text-blue-200 transition-colors mr-2">
                    <i class="fas fa-arrow-left"></i> Back to Quizzes
                </a>
                <span class="text-gray-400 mx-2">|</span>
                <h1 class="text-3xl font-bold text-white flex items-center">
                    <i class="fas fa-question-circle mr-3 text-purple-300"></i>
                    <?php echo e($quiz->name); ?>

                </h1>
            </div>
            <p class="text-blue-100 opacity-90">Manage questions for this quiz</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="<?php echo e(route('admin.createQuestion', $quiz->id)); ?>" class="group bg-white/10 backdrop-blur-sm border border-white/20 text-white hover:bg-white/20 font-semibold py-3 px-5 rounded-lg shadow-lg transition-all duration-300 inline-flex items-center hover:shadow-purple-500/20 hover:shadow-xl">
                <i class="fas fa-plus mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                <span>Add New Question</span>
            </a>
        </div>
    </div>
</div>

<!-- Questions Table Card -->
<div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 shadow-xl relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-purple-600/5 to-blue-800/5"></div>

    <div class="relative">
        <!-- Table Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <h2 class="text-xl font-bold text-white flex items-center">
                <div class="bg-purple-900/70 text-purple-400 rounded-lg p-2 mr-3 shadow-inner shadow-purple-950/50">
                    <i class="fas fa-list-alt"></i>
                </div>
                <span>Quiz Questions</span>
                <span class="ml-3 bg-purple-900/30 text-purple-400 text-sm py-1 px-3 rounded-full border border-purple-700/30">
                    <?php echo e(count($quiz->questions)); ?> questions
                </span>
            </h2>

            <div class="relative group w-full md:w-auto">
                <div class="absolute inset-0 bg-gradient-to-r from-purple-600/20 to-blue-600/20 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-200"></div>
                <div class="relative bg-gray-900 border border-gray-700 rounded-lg flex items-center overflow-hidden">
                    <div class="px-3 text-gray-400">
                        <i class="fas fa-search"></i>
                    </div>
                    <input type="text" id="question-search" placeholder="Search questions..."
                        class="bg-transparent border-0 px-2 py-2.5 focus:outline-none text-gray-200 w-full placeholder-gray-500">
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-xl border border-gray-700/50 shadow-inner bg-gray-900/50">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-800/80">
                        <th class="px-4 py-3 text-gray-400 font-medium text-left border-b border-gray-700/50">Question</th>
                        <th class="px-4 py-3 text-gray-400 font-medium text-left border-b border-gray-700/50">Answers</th>
                        <th class="px-4 py-3 text-gray-400 font-medium text-left border-b border-gray-700/50">Correct Answer</th>
                        <th class="px-4 py-3 text-gray-400 font-medium text-left border-b border-gray-700/50">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $quiz->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="question-row border-b border-gray-800/80 hover:bg-gray-800/50 transition-all duration-200">
                        <td class="px-4 py-4">
                            <div class="flex items-start">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white font-bold mr-3 shadow-md relative overflow-hidden flex-shrink-0 mt-1">
                                    <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:8px_8px]"></div>
                                    <span class="relative"><?php echo e($loop->iteration); ?></span>
                                </div>
                                <div class="question-text text-white"><?php echo e($question->question); ?></div>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="answers-list text-gray-300"><?php echo e($question->answers); ?></div>
                        </td>
                        <td class="px-4 py-4">
                            <?php
                                $answers = explode(',', $question->answers);
                                $correctIndex = $question->correct;
                            ?>
                            <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-900/30 text-green-300 border border-green-700/30">
                                <i class="fas fa-check-circle mr-1.5"></i>
                                <?php echo e($answers[$correctIndex] ?? 'N/A'); ?>

                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex gap-2">
                                <a href="<?php echo e(route('admin.editQuestion', $question->id)); ?>"
                                   class="group bg-blue-900/40 hover:bg-blue-800/60 text-blue-300 border border-blue-700/50 rounded-lg px-3 py-1.5 transition-all duration-200 flex items-center tooltip-trigger">
                                    <i class="fas fa-edit mr-1.5 group-hover:scale-110 transition-transform duration-200"></i>
                                    <span>Edit</span>
                                    <span class="tooltip-text">Edit Question</span>
                                </a>
                                <form action="<?php echo e(route('admin.deleteQuestion', $question->id)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit"
                                            class="group bg-red-900/40 hover:bg-red-800/60 text-red-300 border border-red-700/50 rounded-lg px-3 py-1.5 transition-all duration-200 flex items-center tooltip-trigger"
                                            onclick="return confirm('Are you sure you want to delete this question? This action cannot be undone.')">
                                        <i class="fas fa-trash-alt mr-1.5 group-hover:scale-110 transition-transform duration-200"></i>
                                        <span>Delete</span>
                                        <span class="tooltip-text">Delete Question</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <?php if($quiz->questions->isEmpty()): ?>
        <div class="text-center py-16 bg-gray-900/30 rounded-xl border border-gray-700/50 mt-4">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-800/80 text-gray-400 mb-6">
                <i class="fas fa-question-circle text-4xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-white mb-3">No questions found</h3>
            <p class="text-gray-400 mb-6 max-w-md mx-auto">Get started by adding questions to this quiz.</p>
            <a href="<?php echo e(route('admin.createQuestion', $quiz->id)); ?>" class="group bg-gradient-to-r from-purple-600/80 to-indigo-600/80 hover:from-purple-500/80 hover:to-indigo-500/80 text-white font-semibold py-3 px-6 rounded-lg shadow-lg transition-all duration-300 inline-flex items-center hover:shadow-purple-500/20 hover:shadow-xl">
                <i class="fas fa-plus mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                <span>Add Your First Question</span>
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Enhanced search functionality
        const searchInput = document.getElementById('question-search');
        const questionRows = document.querySelectorAll('.question-row');

        if (searchInput) {
            // Add focus effect to search input
            searchInput.addEventListener('focus', function() {
                this.parentElement.parentElement.classList.add('ring-2', 'ring-purple-500/50');
            });

            searchInput.addEventListener('blur', function() {
                this.parentElement.parentElement.classList.remove('ring-2', 'ring-purple-500/50');
            });

            // Enhanced search with highlighting
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                let visibleCount = 0;

                questionRows.forEach(row => {
                    const questionText = row.querySelector('.question-text').textContent.toLowerCase();
                    const answersText = row.querySelector('.answers-list').textContent.toLowerCase();

                    if (questionText.includes(searchTerm) || answersText.includes(searchTerm)) {
                        row.style.display = '';
                        visibleCount++;

                        // Add a subtle highlight effect for matching search terms
                        if (searchTerm !== '') {
                            // Reset any previous highlights
                            row.classList.add('bg-purple-900/10');
                            setTimeout(() => {
                                row.classList.remove('bg-purple-900/10');
                            }, 300);
                        }
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Update the question count badge
                const questionBadge = document.querySelector('.bg-purple-900/30.text-purple-400.text-sm');
                if (questionBadge) {
                    questionBadge.textContent = `${visibleCount} questions`;
                }

                // Show/hide empty state message
                const table = document.querySelector('table');
                if (visibleCount === 0 && questionRows.length > 0) {
                    // Check if we already have a "no results" message
                    let noResultsMsg = document.querySelector('.no-results-message');
                    if (!noResultsMsg) {
                        // Create a "no results" message
                        noResultsMsg = document.createElement('div');
                        noResultsMsg.className = 'no-results-message text-center py-8 bg-gray-900/30 rounded-xl border border-gray-700/50 mt-4';
                        noResultsMsg.innerHTML = `
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-800/80 text-gray-400 mb-4">
                                <i class="fas fa-search text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-white mb-2">No matching questions</h3>
                            <p class="text-gray-400">Try adjusting your search term</p>
                        `;
                        table.parentNode.appendChild(noResultsMsg);
                    } else {
                        noResultsMsg.style.display = 'block';
                    }
                } else {
                    const noResultsMsg = document.querySelector('.no-results-message');
                    if (noResultsMsg) {
                        noResultsMsg.style.display = 'none';
                    }
                }
            });
        }

        // Add click to expand functionality for truncated text
        document.querySelectorAll('.question-text, .answers-list').forEach(element => {
            element.addEventListener('click', function() {
                this.classList.toggle('-webkit-line-clamp-2');
                this.classList.toggle('-webkit-line-clamp-none');
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/admin/quizQuestions.blade.php ENDPATH**/ ?>