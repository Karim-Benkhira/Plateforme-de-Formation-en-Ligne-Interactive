<?php $__env->startSection('title', 'Manage Quizzes'); ?>

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
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="bg-gradient-to-r from-blue-900 via-primary-800 to-secondary-900 rounded-xl shadow-2xl p-6 mb-8 border border-blue-700/30 relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-white/[0.05] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-purple-500/10"></div>
    <div class="relative flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2 flex items-center">
                <i class="fas fa-brain mr-3 text-purple-300"></i>
                Quiz Management
            </h1>
            <p class="text-blue-100 opacity-90">Create and manage quizzes to assess student knowledge.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="<?php echo e(route('admin.createQuiz')); ?>" class="group bg-white/10 backdrop-blur-sm border border-white/20 text-white hover:bg-white/20 font-semibold py-3 px-5 rounded-lg shadow-lg transition-all duration-300 inline-flex items-center hover:shadow-purple-500/20 hover:shadow-xl">
                <i class="fas fa-plus mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                <span>Add New Quiz</span>
            </a>
        </div>
    </div>
</div>

<!-- Quizzes Table Card -->
<div class="bg-gradient-to-br from-gray-900 to-gray-800 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 shadow-xl relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-white/[0.02] bg-[length:20px_20px]"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-purple-600/5 to-blue-800/5"></div>

    <div class="relative">
        <!-- Table Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <h2 class="text-xl font-bold text-white flex items-center">
                <div class="bg-purple-900/70 text-purple-400 rounded-lg p-2 mr-3 shadow-inner shadow-purple-950/50">
                    <i class="fas fa-question-circle"></i>
                </div>
                <span>All Quizzes</span>
                <span class="ml-3 bg-purple-900/30 text-purple-400 text-sm py-1 px-3 rounded-full border border-purple-700/30">
                    <?php echo e(count($quizzes)); ?> quizzes
                </span>
            </h2>

            <div class="relative group w-full md:w-auto">
                <div class="absolute inset-0 bg-gradient-to-r from-purple-600/20 to-blue-600/20 rounded-lg blur opacity-75 group-hover:opacity-100 transition duration-200"></div>
                <div class="relative bg-gray-900 border border-gray-700 rounded-lg flex items-center overflow-hidden">
                    <div class="px-3 text-gray-400">
                        <i class="fas fa-search"></i>
                    </div>
                    <input type="text" id="quiz-search" placeholder="Search quizzes..."
                        class="bg-transparent border-0 px-2 py-2.5 focus:outline-none text-gray-200 w-full placeholder-gray-500">
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-xl border border-gray-700/50 shadow-inner bg-gray-900/50">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-800/80">
                        <th class="px-4 py-3 text-gray-400 font-medium text-left border-b border-gray-700/50">Quiz Name</th>
                        <th class="px-4 py-3 text-gray-400 font-medium text-left border-b border-gray-700/50">Course</th>
                        <th class="px-4 py-3 text-gray-400 font-medium text-left border-b border-gray-700/50">Category</th>
                        <th class="px-4 py-3 text-gray-400 font-medium text-left border-b border-gray-700/50">Questions</th>
                        <th class="px-4 py-3 text-gray-400 font-medium text-left border-b border-gray-700/50">AI Generated</th>
                        <th class="px-4 py-3 text-gray-400 font-medium text-left border-b border-gray-700/50">Created</th>
                        <th class="px-4 py-3 text-gray-400 font-medium text-left border-b border-gray-700/50">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $quizzes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="quiz-row border-b border-gray-800/80 hover:bg-gray-800/50 transition-all duration-200">
                        <td class="px-4 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white font-bold mr-3 shadow-md relative overflow-hidden">
                                    <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:8px_8px]"></div>
                                    <i class="fas fa-question relative"></i>
                                </div>
                                <span class="font-medium text-white"><?php echo e($quiz->name); ?></span>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <a href="<?php echo e(route('admin.showCourse', $quiz->course->id)); ?>" class="text-blue-400 hover:text-blue-300 transition-colors group">
                                <span><?php echo e($quiz->course->title); ?></span>
                                <div class="h-0.5 w-0 bg-gradient-to-r from-blue-500 to-purple-500 group-hover:w-full transition-all duration-300"></div>
                            </a>
                        </td>
                        <td class="px-4 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-900/30 text-blue-300 border border-blue-700/30">
                                <i class="fas fa-tag mr-1.5"></i>
                                <?php echo e($quiz->course->category->name ?? 'Uncategorized'); ?>

                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center bg-blue-900/20 text-blue-400 px-3 py-1 rounded-lg border border-blue-700/30 w-fit">
                                <i class="fas fa-list-ul mr-2"></i>
                                <span><?php echo e($quiz->questions->count()); ?></span>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <?php if($quiz->is_ai_generated): ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-900/50 text-purple-300 border border-purple-700/50">
                                    <i class="fas fa-robot mr-1.5"></i> AI Generated
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-800/80 text-gray-300 border border-gray-700/50">
                                    <i class="fas fa-user mr-1.5"></i> Manual
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center text-gray-400">
                                <i class="far fa-calendar-alt mr-2"></i>
                                <span><?php echo e($quiz->created_at->format('M d, Y')); ?></span>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex gap-2">
                                <a href="<?php echo e(route('admin.quizQuestions', $quiz->id)); ?>"
                                   class="group bg-yellow-900/40 hover:bg-yellow-800/60 text-yellow-300 border border-yellow-700/50 rounded-lg px-3 py-1.5 transition-all duration-200 flex items-center tooltip-trigger">
                                    <i class="fas fa-list-alt mr-1.5 group-hover:scale-110 transition-transform duration-200"></i>
                                    <span>Questions</span>
                                    <span class="tooltip-text">Manage Questions</span>
                                </a>
                                <a href="<?php echo e(route('admin.editQuiz', $quiz->id)); ?>"
                                   class="group bg-blue-900/40 hover:bg-blue-800/60 text-blue-300 border border-blue-700/50 rounded-lg px-3 py-1.5 transition-all duration-200 flex items-center tooltip-trigger">
                                    <i class="fas fa-edit mr-1.5 group-hover:scale-110 transition-transform duration-200"></i>
                                    <span>Edit</span>
                                    <span class="tooltip-text">Edit Quiz</span>
                                </a>
                                <form action="<?php echo e(route('admin.deleteQuiz', $quiz->id)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit"
                                            class="group bg-red-900/40 hover:bg-red-800/60 text-red-300 border border-red-700/50 rounded-lg px-3 py-1.5 transition-all duration-200 flex items-center tooltip-trigger"
                                            onclick="return confirm('Are you sure you want to delete this quiz? This action cannot be undone and will remove all associated questions and results.')">
                                        <i class="fas fa-trash-alt mr-1.5 group-hover:scale-110 transition-transform duration-200"></i>
                                        <span>Delete</span>
                                        <span class="tooltip-text">Delete Quiz</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <?php if($quizzes->isEmpty()): ?>
        <div class="text-center py-16 bg-gray-900/30 rounded-xl border border-gray-700/50 mt-4">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-800/80 text-gray-400 mb-6">
                <i class="fas fa-question-circle text-4xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-white mb-3">No quizzes found</h3>
            <p class="text-gray-400 mb-6 max-w-md mx-auto">Get started by creating your first quiz to assess student knowledge.</p>
            <a href="<?php echo e(route('admin.createQuiz')); ?>" class="group bg-gradient-to-r from-purple-600/80 to-indigo-600/80 hover:from-purple-500/80 hover:to-indigo-500/80 text-white font-semibold py-3 px-6 rounded-lg shadow-lg transition-all duration-300 inline-flex items-center hover:shadow-purple-500/20 hover:shadow-xl">
                <i class="fas fa-plus mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                <span>Create Your First Quiz</span>
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Enhanced search functionality
        const searchInput = document.getElementById('quiz-search');
        const quizRows = document.querySelectorAll('.quiz-row');
        const quizTable = document.querySelector('table');
        const noQuizzesMessage = document.querySelector('.text-center.py-16');

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

            quizRows.forEach(row => {
                const quizName = row.querySelector('.font-medium').textContent.toLowerCase();
                const courseName = row.querySelector('a span').textContent.toLowerCase();
                const categoryName = row.querySelector('td:nth-child(3)').textContent.toLowerCase();

                if (quizName.includes(searchTerm) || courseName.includes(searchTerm) || categoryName.includes(searchTerm)) {
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

            // Update the quiz count badge
            const quizBadge = document.querySelector('.bg-purple-900/30.text-purple-400.text-sm');
            if (quizBadge) {
                quizBadge.textContent = `${visibleCount} quizzes`;
            }

            // Show/hide empty state message
            if (quizTable && noQuizzesMessage) {
                if (visibleCount === 0 && quizRows.length > 0) {
                    quizTable.style.display = 'none';

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
                            <h3 class="text-xl font-semibold text-white mb-2">No matching quizzes</h3>
                            <p class="text-gray-400">Try adjusting your search term</p>
                        `;
                        quizTable.parentNode.appendChild(noResultsMsg);
                    } else {
                        noResultsMsg.style.display = 'block';
                    }
                } else {
                    quizTable.style.display = '';
                    const noResultsMsg = document.querySelector('.no-results-message');
                    if (noResultsMsg) {
                        noResultsMsg.style.display = 'none';
                    }
                }
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/admin/quizzes.blade.php ENDPATH**/ ?>