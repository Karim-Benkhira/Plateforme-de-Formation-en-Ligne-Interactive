<?php $__env->startSection('title', 'Support Tickets'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl shadow-lg p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Support Ticket Management</h1>
            <p class="text-blue-100">Manage and respond to user support tickets and inquiries.</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-2">
            <div class="relative">
                <select id="status-filter" class="bg-gray-700 text-gray-200 border border-gray-600 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <option value="all">All Tickets</option>
                    <option value="pending">Pending</option>
                    <option value="resolved">Resolved</option>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="data-card">
    <div class="flex justify-between items-center mb-6">
        <h2 class="section-title flex items-center">
            <i class="fas fa-ticket-alt text-red-500 mr-2"></i>
            Support Tickets
        </h2>
        <div class="flex items-center space-x-2">
            <div class="relative">
                <input type="text" id="ticket-search" placeholder="Search tickets..." class="bg-gray-700 text-gray-200 border border-gray-600 rounded-lg py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="rounded-tl-lg">User</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th>Response</th>
                    <th class="rounded-tr-lg">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $reclamations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reclamation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="ticket-row" data-status="<?php echo e($reclamation->status); ?>">
                    <td>
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white font-bold mr-3">
                                <?php echo e(strtoupper(substr($reclamation->user->username ?? 'U', 0, 1))); ?>

                            </div>
                            <div>
                                <span class="font-medium block"><?php echo e($reclamation->user->username ?? 'Unknown'); ?></span>
                                <span class="text-xs text-gray-400"><?php echo e($reclamation->user->email ?? ''); ?></span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="max-w-xs truncate">
                            <?php echo e($reclamation->message); ?>

                        </div>
                    </td>
                    <td>
                        <?php if($reclamation->status === 'resolved'): ?>
                            <span class="px-2 py-1 bg-green-900 text-green-300 rounded-md text-xs flex items-center justify-center w-20">
                                <i class="fas fa-check-circle mr-1"></i> Resolved
                            </span>
                        <?php else: ?>
                            <span class="px-2 py-1 bg-yellow-900 text-yellow-300 rounded-md text-xs flex items-center justify-center w-20">
                                <i class="fas fa-clock mr-1"></i> Pending
                            </span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="text-gray-400"><?php echo e($reclamation->created_at->format('M d, Y')); ?></span>
                    </td>
                    <td>
                        <div class="max-w-xs truncate">
                            <?php echo e($reclamation->response ?? 'No response yet'); ?>

                        </div>
                    </td>
                    <td>
                        <div class="flex space-x-2">
                            <?php if($reclamation->status !== 'resolved'): ?>
                                <a href="<?php echo e(route('admin.respondReclamation', $reclamation->id)); ?>" class="btn btn-sm bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors" title="Respond to Ticket">
                                    <i class="fas fa-reply"></i>
                                </a>
                            <?php else: ?>
                                <button disabled class="btn btn-sm bg-gray-600 text-gray-400 rounded-md cursor-not-allowed opacity-50" title="Already Resolved">
                                    <i class="fas fa-check"></i>
                                </button>
                            <?php endif; ?>
                            <form action="<?php echo e(route('admin.deleteReclamation', $reclamation->id)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm bg-red-600 hover:bg-red-700 text-white rounded-md transition-colors" onclick="return confirm('Are you sure you want to delete this support ticket? This action cannot be undone.')" title="Delete Ticket">
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

    <?php if($reclamations->isEmpty()): ?>
    <div class="text-center py-8">
        <div class="text-gray-400 mb-4">
            <i class="fas fa-ticket-alt text-5xl"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-300 mb-2">No support tickets found</h3>
        <p class="text-gray-500">All user inquiries have been addressed</p>
    </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('ticket-search');
        const statusFilter = document.getElementById('status-filter');
        const ticketRows = document.querySelectorAll('.ticket-row');

        // Search functionality
        searchInput.addEventListener('keyup', function() {
            filterTickets();
        });

        // Status filter functionality
        statusFilter.addEventListener('change', function() {
            filterTickets();
        });

        function filterTickets() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value;

            ticketRows.forEach(row => {
                const username = row.querySelector('.font-medium').textContent.toLowerCase();
                const message = row.querySelector('.max-w-xs').textContent.toLowerCase();
                const status = row.dataset.status;

                const matchesSearch = username.includes(searchTerm) || message.includes(searchTerm);
                const matchesStatus = statusValue === 'all' || status === statusValue;

                if (matchesSearch && matchesStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/admin/reclamations.blade.php ENDPATH**/ ?>