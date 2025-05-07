<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>BrightPath</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<div>
    <header class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-blue-500 text-2xl font-bold">BrightPath</h1>
        <nav>
            <?php if(Auth::check()): ?>
                <?php if(Auth::user()->role === 'admin'): ?>
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a>
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="<?php echo e(route('admin.users')); ?>">Users</a>
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="<?php echo e(route('admin.courses')); ?>">Courses</a>
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="<?php echo e(route('admin.categories')); ?>">categories</a>
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="<?php echo e(route('admin.reclamations')); ?>">Reports</a>
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="<?php echo e(route('admin.quizzes')); ?>">Quizzes</a>
                <?php elseif(Auth::user()->role === 'agent'): ?>
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="<?php echo e(route('agent.dashboard')); ?>">Dashboard</a>
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="<?php echo e(route('agent.reclamations')); ?>">Reclamations</a>
                <?php elseif(Auth::user()->role === 'user'): ?>
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="<?php echo e(route('student.dashboard')); ?>">Dashboard</a>
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="<?php echo e(route('student.courses')); ?>">Courses</a>
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="<?php echo e(route('student.myCourses')); ?>">My Courses</a>
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="<?php echo e(route('student.leaderboard')); ?>">Leaderboard</a>
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="<?php echo e(route('student.achievements')); ?>">Achievements</a>
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="<?php echo e(route('student.profile')); ?>">Profile</a>
                    <a class="text-blue-500 hover:text-blue-700 mx-2" href="<?php echo e(route('student.support')); ?>">Support</a>
                <?php endif; ?>
                <form action="<?php echo e(route('logout')); ?>" method="POST" class="inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="text-blue-500 hover:text-blue-700 mx-2">Logout</button>
                </form>
            <?php else: ?>
                <a class="text-blue-500 hover:text-blue-700 mx-2" href="/">Home</a>
                <a class="text-blue-500 hover:text-blue-700 mx-2" href="/about">about</a>
                <a class="text-blue-500 hover:text-blue-700 mx-2" href="<?php echo e(route('login')); ?>">Login</a>
                <a class="text-blue-500 hover:text-blue-700 mx-2" href="<?php echo e(route('register')); ?>">Register</a>
            <?php endif; ?>
        </nav>
    </header>
</body>
</html> <?php /**PATH C:\Users\LENOVO\Desktop\BrightPath\resources\views/components/header.blade.php ENDPATH**/ ?>