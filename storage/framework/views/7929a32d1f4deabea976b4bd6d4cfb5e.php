<?php $__env->startSection('title', 'All Courses'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="welcome-banner bg-gradient-to-r from-primary-600 to-secondary-600 rounded-xl shadow-lg p-6 mb-8">
    <div class="flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold mb-2 text-white">Explore Courses</h1>
            <p class="text-blue-100">Discover new courses and expand your knowledge</p>
        </div>
        <div class="mt-4 md:mt-0">
            <div class="relative">
                <input type="text" id="courseSearch" placeholder="Search courses..."
                    class="bg-white/20 border border-white/30 text-white rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent placeholder-blue-100">
                <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                    <i class="fas fa-search text-blue-100"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Course Categories -->
<div class="section-card mb-8">
    <div class="section-header">
        <i class="fas fa-tags mr-2"></i> Categories
    </div>
    <div class="section-content">
        <div class="flex flex-wrap gap-2">
            <button class="category-btn active" data-category="all">
                All Categories
            </button>
            <?php $__currentLoopData = $categories ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button class="category-btn" data-category="<?php echo e($category->id); ?>">
                    <?php echo e($category->name); ?>

                </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>

<!-- Courses Grid -->
<div class="section-card">
    <div class="section-header">
        <i class="fas fa-book-open mr-2"></i> Available Courses
    </div>
    <div class="section-content">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" id="coursesGrid">
            <?php if(count($courses) > 0): ?>
                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg transition-transform hover:scale-105 course-card" data-category="<?php echo e($course->category_id ?? 'all'); ?>">
                        <div class="relative">
                            <?php if($course->image): ?>
                                <img src="<?php echo e(asset('storage/' . $course->image)); ?>" alt="<?php echo e($course->title ?? $course->name); ?>" class="w-full h-48 object-cover">
                            <?php else: ?>
                                <div class="w-full h-48 bg-gradient-to-r from-primary-900 to-secondary-900 flex items-center justify-center">
                                    <i class="fas fa-book text-4xl text-white opacity-50"></i>
                                </div>
                            <?php endif; ?>
                            <div class="absolute top-3 right-3 bg-primary-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                                <?php echo e($course->category->name ?? 'General'); ?>

                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="text-xl font-bold text-white mb-2 line-clamp-1"><?php echo e($course->title ?? $course->name); ?></h3>
                            <p class="text-gray-400 mb-4 text-sm line-clamp-2"><?php echo e($course->description); ?></p>

                            <div class="flex justify-between items-center mb-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-primary-900 flex items-center justify-center mr-2">
                                        <span class="text-primary-300 font-bold text-xs">
                                            <?php echo e(substr($course->teacher->username ?? 'T', 0, 1)); ?>

                                        </span>
                                    </div>
                                    <span class="text-gray-400 text-sm"><?php echo e($course->teacher->username ?? 'Teacher'); ?></span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-users text-gray-500 mr-1"></i>
                                    <span class="text-gray-400 text-sm"><?php echo e($course->students_count ?? rand(10, 100)); ?></span>
                                </div>
                            </div>

                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="text-yellow-500 mr-1">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span class="text-white font-bold"><?php echo e($course->score ?? rand(3, 5)); ?></span>
                                    <span class="text-gray-400 text-sm ml-1">/5</span>
                                </div>
                                <a href="<?php echo e(route('student.showCourse', $course->id)); ?>"
                                    class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 inline-flex items-center">
                                    <i class="fas fa-eye mr-2"></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="col-span-3 text-center py-12">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-900 mb-4">
                        <i class="fas fa-book-open text-primary-400 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">No Courses Available</h3>
                    <p class="text-gray-400">There are no courses available at the moment. Please check back later.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Learning Tips -->
<div class="section-card mt-8">
    <div class="section-header">
        <i class="fas fa-lightbulb mr-2"></i> Learning Tips
    </div>
    <div class="section-content">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="tip-card">
                <div class="tip-icon bg-primary-900">
                    <i class="fas fa-calendar-alt text-primary-400"></i>
                </div>
                <p class="tip-text">Set a regular study schedule to maintain consistent progress in your courses.</p>
            </div>
            <div class="tip-card">
                <div class="tip-icon bg-primary-900">
                    <i class="fas fa-tasks text-primary-400"></i>
                </div>
                <p class="tip-text">Take notes while watching course videos to improve retention of key concepts.</p>
            </div>
            <div class="tip-card">
                <div class="tip-icon bg-secondary-900">
                    <i class="fas fa-users text-secondary-400"></i>
                </div>
                <p class="tip-text">Join study groups to discuss course material and solve problems together.</p>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Course search functionality
        const searchInput = document.getElementById('courseSearch');
        const coursesGrid = document.getElementById('coursesGrid');
        const courseCards = document.querySelectorAll('.course-card');

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            courseCards.forEach(card => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                const description = card.querySelector('p').textContent.toLowerCase();

                if (title.includes(searchTerm) || description.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Category filter functionality
        const categoryButtons = document.querySelectorAll('.category-btn');

        categoryButtons.forEach(button => {
            button.addEventListener('click', function() {
                const category = this.getAttribute('data-category');

                // Update active button
                categoryButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                // Filter courses
                courseCards.forEach(card => {
                    if (category === 'all' || card.getAttribute('data-category') === category) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>

<style>
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .category-btn {
        background-color: #1f2937;
        color: #9ca3af;
        font-weight: 500;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        transition: all 0.2s;
    }

    .category-btn:hover {
        background-color: #374151;
        color: #f3f4f6;
    }

    .category-btn.active {
        background-color: #3b82f6;
        color: white;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/student/courses-new.blade.php ENDPATH**/ ?>