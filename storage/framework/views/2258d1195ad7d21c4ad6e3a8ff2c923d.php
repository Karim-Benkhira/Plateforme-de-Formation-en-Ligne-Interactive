<?php $__env->startSection('title', 'Manage Categories'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl shadow-lg p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Category Management</h1>
            <p class="text-blue-100">Create and manage categories to organize your courses.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="<?php echo e(route('admin.createCategory')); ?>" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-200 inline-flex items-center">
                <i class="fas fa-plus mr-2"></i> Add New Category
            </a>
        </div>
    </div>
</div>

<div class="data-card">
    <div class="flex justify-between items-center mb-6">
        <h2 class="section-title flex items-center">
            <i class="fas fa-tags text-green-500 mr-2"></i>
            All Categories
        </h2>
        <div class="flex items-center space-x-2">
            <div class="relative">
                <input type="text" id="category-search" placeholder="Search categories..." class="bg-gray-700 text-gray-200 border border-gray-600 rounded-lg py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="rounded-tl-lg">Category Name</th>
                    <th>Courses</th>
                    <th>Created</th>
                    <th class="rounded-tr-lg">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="category-row">
                    <td>
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-green-500 to-green-700 flex items-center justify-center text-white font-bold mr-3">
                                <?php echo e(strtoupper(substr($category->name, 0, 1))); ?>

                            </div>
                            <span class="font-medium"><?php echo e($category->name); ?></span>
                        </div>
                    </td>
                    <td>
                        <div class="flex items-center">
                            <i class="fas fa-book text-blue-400 mr-1"></i>
                            <span><?php echo e($category->courses->count()); ?></span>
                        </div>
                    </td>
                    <td>
                        <span class="text-gray-400"><?php echo e($category->created_at->format('M d, Y')); ?></span>
                    </td>
                    <td>
                        <div class="flex space-x-2">
                            <a href="<?php echo e(route('admin.editCategory', $category->id)); ?>" class="btn btn-sm bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors" title="Edit Category">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?php echo e(route('admin.deleteCategory', $category->id)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm bg-red-600 hover:bg-red-700 text-white rounded-md transition-colors" onclick="return confirm('Are you sure you want to delete this category? This action cannot be undone and may affect courses assigned to this category.')" title="Delete Category">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <?php if(count($categories) == 0): ?>
    <div class="text-center py-8">
        <div class="text-gray-400 mb-4">
            <i class="fas fa-tags text-5xl"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-300 mb-2">No categories found</h3>
        <p class="text-gray-500">Get started by creating your first category</p>
        <a href="<?php echo e(route('admin.createCategory')); ?>" class="mt-4 inline-block bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-200">
            <i class="fas fa-plus mr-2"></i> Add New Category
        </a>
    </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('category-search');
        const categoryRows = document.querySelectorAll('.category-row');

        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();

            categoryRows.forEach(row => {
                const categoryName = row.querySelector('.font-medium').textContent.toLowerCase();
                if (categoryName.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/admin/categories.blade.php ENDPATH**/ ?>