<?php $__env->startSection('title', $course->title ?? $course->name); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .gradient-pink-purple {
        background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 50%, #06b6d4 100%);
    }
    .gradient-pink-blue {
        background: linear-gradient(135deg, #f472b6 0%, #a855f7 50%, #3b82f6 100%);
    }
    .card-hover {
        transition: all 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(236, 72, 153, 0.3);
    }
    .text-shadow {
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }
    .course-card {
        background: rgba(31, 41, 55, 0.5);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(236, 72, 153, 0.2);
        border-radius: 1rem;
        transition: all 0.3s ease;
    }
    .course-card:hover {
        border-color: rgba(236, 72, 153, 0.5);
    }
    .lesson-card {
        background: rgba(31, 41, 55, 0.5);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(236, 72, 153, 0.2);
        border-radius: 0.75rem;
        transition: all 0.3s ease;
    }
    .lesson-card:hover {
        border-color: rgba(236, 72, 153, 0.5);
        transform: translateY(-2px);
    }
    .section-card {
        background: rgba(31, 41, 55, 0.5);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(236, 72, 153, 0.2);
        border-radius: 1rem;
        transition: all 0.3s ease;
    }
    .section-card:hover {
        border-color: rgba(236, 72, 153, 0.5);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- Course Header -->
<div class="gradient-pink-purple rounded-2xl shadow-2xl p-8 mb-8 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-32 h-32 bg-white rounded-full -translate-x-16 -translate-y-16"></div>
        <div class="absolute bottom-0 right-0 w-24 h-24 bg-white rounded-full translate-x-12 translate-y-12"></div>
        <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-white rounded-full opacity-50"></div>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-center relative z-10">
        <div class="flex-1">
            <h1 class="text-4xl font-bold mb-3 text-white text-shadow">🎓 <?php echo e($course->title ?? $course->name); ?></h1>
            <p class="text-pink-100 text-lg mb-4"><?php echo e($course->description); ?></p>
            <div class="flex items-center space-x-6">
                <div class="flex items-center text-pink-200">
                    <i class="fas fa-user-tie mr-2"></i>
                    <span><?php echo e($course->teacher->username ?? 'Unknown Teacher'); ?></span>
                </div>
                <div class="flex items-center text-pink-200">
                    <i class="fas fa-layer-group mr-2"></i>
                    <span><?php echo e($course->category->name ?? 'Uncategorized'); ?></span>
                </div>
                <div class="flex items-center text-pink-200">
                    <i class="fas fa-users mr-2"></i>
                    <span><?php echo e($course->users()->count() ?? 0); ?> students</span>
                </div>
                <?php if($isEnrolled && $totalLessons > 0): ?>
                    <div class="flex items-center text-pink-200" id="progress-info-header">
                        <i class="fas fa-chart-line mr-2"></i>
                        <span><?php echo e($courseProgress); ?>% Complete (<?php echo e($completedLessons); ?>/<?php echo e($totalLessons); ?>)</span>
                    </div>
                <?php endif; ?>
            </div>

            <?php if($isEnrolled && $totalLessons > 0): ?>
                <!-- Progress Bar -->
                <div class="mt-4" id="progress-bar-section">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-pink-200 text-sm font-medium">Course Progress</span>
                        <span class="text-pink-200 text-sm" id="progress-percentage-text"><?php echo e($courseProgress); ?>%</span>
                        <!-- DEBUG: Show calculation details -->
                        <span class="text-xs text-yellow-400 ml-2">(<?php echo e($completedLessons); ?>/<?php echo e($totalLessons); ?>)</span>
                    </div>
                    <div class="w-full bg-white/20 rounded-full h-3">
                        <div class="bg-gradient-to-r from-emerald-400 to-emerald-600 h-3 rounded-full transition-all duration-500"
                             id="progress-bar-fill" style="width: <?php echo e($courseProgress); ?>%"></div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="mt-6 md:mt-0">
            <?php if($isEnrolled): ?>
                <div class="bg-emerald-500/20 backdrop-blur-sm border border-emerald-400/50 text-emerald-300 px-6 py-3 rounded-xl inline-flex items-center">
                    <i class="fas fa-check-circle mr-3 text-lg"></i>
                    <span class="font-medium">Enrolled Successfully</span>
                </div>
            <?php elseif($enrollmentStatus === 'pending'): ?>
                <div class="bg-yellow-500/20 backdrop-blur-sm border border-yellow-400/50 text-yellow-300 px-6 py-3 rounded-xl inline-flex items-center">
                    <i class="fas fa-clock mr-3 text-lg"></i>
                    <span class="font-medium">Pending Approval</span>
                </div>
            <?php elseif($enrollmentStatus === 'rejected'): ?>
                <div class="bg-red-500/20 backdrop-blur-sm border border-red-400/50 text-red-300 px-6 py-3 rounded-xl inline-flex items-center">
                    <i class="fas fa-times-circle mr-3 text-lg"></i>
                    <span class="font-medium">Request Rejected</span>
                </div>
            <?php else: ?>
                <form action="<?php echo e(route('student.enrollCourse', $course->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-8 py-4 rounded-xl transition-all flex items-center font-medium shadow-lg hover:shadow-xl transform hover:scale-105">
                        <i class="fas fa-graduation-cap mr-3 text-lg"></i> Request Enrollment
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if(session('success')): ?>
    <div class="bg-emerald-500/20 border-l-4 border-emerald-500 text-emerald-300 p-4 mb-8 rounded-xl shadow-lg backdrop-blur-sm">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-emerald-400 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="font-medium"><?php echo e(session('success')); ?></p>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if(session('info')): ?>
    <div class="bg-blue-500/20 border-l-4 border-blue-500 text-blue-300 p-4 mb-8 rounded-xl shadow-lg backdrop-blur-sm">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-400 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="font-medium"><?php echo e(session('info')); ?></p>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Course Details -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Column - Course Content -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Course Information -->
        <div class="course-card p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-info-circle mr-3 text-pink-400"></i> Course Information
                </h2>
            </div>
            <div class="prose prose-dark max-w-none">
                <p class="text-gray-300 text-lg leading-relaxed"><?php echo e($course->description); ?></p>
            </div>
        </div>

        <!-- Course Content -->
        <div class="course-card p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-play-circle mr-3 text-pink-400"></i> Course Content
                </h2>
                <?php if($isEnrolled): ?>
                    <span class="bg-emerald-500/20 text-emerald-300 px-3 py-1 rounded-full text-sm">
                        <i class="fas fa-unlock mr-1"></i> Full Access
                    </span>
                <?php else: ?>
                    <span class="bg-red-500/20 text-red-300 px-3 py-1 rounded-full text-sm">
                        <i class="fas fa-lock mr-1"></i> Enrollment Required
                    </span>
                <?php endif; ?>
            </div>

            <?php if($isEnrolled): ?>
                <?php
                    $hasContent = false;
                    $contentCount = 0;
                ?>

                
                <?php if($course->sections && count($course->sections) > 0): ?>
                    <?php
                        $hasContent = true;
                        $lessonIndex = 0;
                    ?>
                    <div class="space-y-6">
                        <?php $__currentLoopData = $course->sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($section->lessons && count($section->lessons) > 0): ?>
                                
                                <div class="bg-gradient-to-r from-pink-600/20 to-purple-600/20 rounded-xl p-4 border border-pink-500/30">
                                    <h3 class="text-lg font-bold text-white mb-2">
                                        <i class="fas fa-folder-open mr-2 text-pink-400"></i>
                                        <?php echo e($section->title); ?>

                                    </h3>
                                    <?php if($section->description): ?>
                                        <p class="text-gray-300 text-sm"><?php echo e($section->description); ?></p>
                                    <?php endif; ?>
                                </div>

                                
                                <div class="space-y-4 ml-4">
                                    <?php $__currentLoopData = $section->lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $lessonIndex++;
                                            $isCompleted = isset($userProgress[$lesson->id]) && $userProgress[$lesson->id]['is_completed'];
                                            $progressPercent = isset($userProgress[$lesson->id]) ? $userProgress[$lesson->id]['progress_percentage'] : 0;
                                        ?>
                                        <div class="lesson-card overflow-hidden <?php echo e($isCompleted ? 'border-emerald-500/50' : ''); ?>" data-lesson-id="<?php echo e($lesson->id); ?>">
                                            <div class="flex items-center justify-between p-4 border-b border-gray-700/50">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 rounded-full <?php echo e($isCompleted ? 'bg-emerald-500' : 'gradient-pink-blue'); ?> flex items-center justify-center mr-4">
                                                        <?php if($isCompleted): ?>
                                                            <i class="fas fa-check text-white"></i>
                                                        <?php else: ?>
                                                            <span class="text-white font-bold"><?php echo e($lessonIndex); ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div>
                                                        <h4 class="text-white font-medium <?php echo e($isCompleted ? 'line-through opacity-75' : ''); ?>"><?php echo e($lesson->title); ?></h4>
                                                        <p class="text-gray-400 text-sm">
                                                            <?php if($lesson->content_type === 'video'): ?>
                                                                <i class="fas fa-play mr-1"></i> Video Lesson
                                                                <?php if($lesson->duration): ?>
                                                                    • <?php echo e($lesson->duration); ?> min
                                                                <?php endif; ?>
                                                            <?php elseif($lesson->content_type === 'pdf'): ?>
                                                                <i class="fas fa-file-pdf mr-1"></i> PDF Material
                                                            <?php elseif($lesson->content_type === 'text'): ?>
                                                                <i class="fas fa-file-text mr-1"></i> Text Content
                                                            <?php else: ?>
                                                                <i class="fas fa-book mr-1"></i> Lesson
                                                            <?php endif; ?>
                                                            <?php if($isCompleted): ?>
                                                                • <span class="text-emerald-400">Completed</span>
                                                            <?php elseif($progressPercent > 0): ?>
                                                                • <span class="text-yellow-400"><?php echo e($progressPercent); ?>% watched</span>
                                                            <?php endif; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <span class="text-xs px-3 py-1 rounded-full <?php echo e($lesson->content_type === 'pdf' ? 'bg-red-500/20 text-red-300' : ($lesson->content_type === 'video' ? 'bg-blue-500/20 text-blue-300' : 'bg-gray-500/20 text-gray-300')); ?>">
                                                        <?php echo e(ucfirst($lesson->content_type)); ?>

                                                    </span>
                                                    <?php if($isCompleted): ?>
                                                        <span class="text-xs px-2 py-1 bg-emerald-500/20 text-emerald-300 rounded-full">
                                                            <i class="fas fa-check mr-1"></i>Done
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="p-4">
                                                <?php if($lesson->content_type === 'video' && $lesson->content_url): ?>
                                                    <div class="bg-gray-900 rounded-xl overflow-hidden relative">
                                                        <?php if($lesson->video_provider === 'youtube'): ?>
                                                            <iframe
                                                                id="video-<?php echo e($lesson->id); ?>"
                                                                src="https://www.youtube.com/embed/<?php echo e($lesson->video_id); ?>?enablejsapi=1&rel=0"
                                                                class="w-full h-[400px]"
                                                                frameborder="0"
                                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                                allowfullscreen>
                                                            </iframe>
                                                        <?php elseif($lesson->video_provider === 'vimeo'): ?>
                                                            <iframe
                                                                id="video-<?php echo e($lesson->id); ?>"
                                                                src="https://player.vimeo.com/video/<?php echo e($lesson->video_id); ?>"
                                                                class="w-full h-[400px]"
                                                                frameborder="0"
                                                                allow="autoplay; fullscreen; picture-in-picture"
                                                                allowfullscreen>
                                                            </iframe>
                                                        <?php else: ?>
                                                            <video
                                                                id="video-<?php echo e($lesson->id); ?>"
                                                                controls
                                                                class="w-full h-[400px] bg-black"
                                                                data-lesson-id="<?php echo e($lesson->id); ?>"
                                                                ontimeupdate="updateVideoProgress(<?php echo e($lesson->id); ?>, this.currentTime, this.duration)"
                                                                onended="markLessonCompleted(<?php echo e($lesson->id); ?>)">
                                                                <source src="<?php echo e(asset('storage/' . $lesson->content_file)); ?>" type="video/mp4">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        <?php endif; ?>

                                                        <!-- Progress overlay for videos -->
                                                        <?php if($progressPercent > 0 && $progressPercent < 100): ?>
                                                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-4">
                                                                <div class="flex items-center justify-between text-white text-sm">
                                                                    <span>Progress: <?php echo e($progressPercent); ?>%</span>
                                                                    <span><?php echo e($isCompleted ? 'Completed' : 'In Progress'); ?></span>
                                                                </div>
                                                                <div class="w-full bg-gray-600 rounded-full h-2 mt-2">
                                                                    <div class="bg-emerald-500 h-2 rounded-full transition-all" style="width: <?php echo e($progressPercent); ?>%"></div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>


                                                <?php elseif($lesson->content_type === 'pdf' && $lesson->content_file): ?>
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center">
                                                            <i class="fas fa-file-pdf text-red-400 text-2xl mr-3"></i>
                                                            <div>
                                                                <p class="text-white font-medium">PDF Document</p>
                                                                <p class="text-gray-400 text-sm">View or download the PDF material</p>
                                                            </div>
                                                        </div>
                                                        <a href="<?php echo e(asset('storage/' . $lesson->content_file)); ?>" target="_blank"
                                                           class="gradient-pink-blue hover:opacity-90 text-white px-4 py-2 rounded-lg text-sm inline-flex items-center transition-all transform hover:scale-105">
                                                            <i class="fas fa-external-link-alt mr-2"></i> Open PDF
                                                        </a>
                                                    </div>
                                                <?php elseif($lesson->content_type === 'text' && $lesson->content_text): ?>
                                                    <div class="prose prose-dark max-w-none">
                                                        <div class="text-gray-300 leading-relaxed">
                                                            <?php echo $lesson->content_text; ?>

                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if($lesson->description): ?>
                                                    <div class="mt-4 p-3 bg-gray-800/50 rounded-lg">
                                                        <p class="text-gray-300 text-sm"><?php echo e($lesson->description); ?></p>
                                                    </div>
                                                <?php endif; ?>

                                                <!-- Lesson Controls for all content types -->
                                                <div class="mt-4 flex items-center justify-between">
                                                    <div class="flex items-center space-x-3">
                                                        <?php if(!$isCompleted): ?>
                                                            <button
                                                                onclick="markLessonCompleted(<?php echo e($lesson->id); ?>)"
                                                                class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm inline-flex items-center transition-all transform hover:scale-105 active:scale-95">
                                                                <i class="fas fa-check mr-2"></i> Mark as Complete
                                                            </button>
                                                        <?php else: ?>
                                                            <span class="bg-emerald-500/20 text-emerald-300 px-4 py-2 rounded-lg text-sm inline-flex items-center animate-pulse">
                                                                <i class="fas fa-check mr-2"></i> Completed
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>

                                                    <!-- Navigation buttons -->
                                                    <div class="flex items-center space-x-2">
                                                        <?php if($lessonIndex > 1): ?>
                                                            <button
                                                                onclick="scrollToLesson(<?php echo e($lessonIndex - 1); ?>)"
                                                                class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded-lg text-sm inline-flex items-center transition-all">
                                                                <i class="fas fa-chevron-left mr-1"></i> Previous
                                                            </button>
                                                        <?php endif; ?>

                                                        <?php if($lessonIndex < $totalLessons): ?>
                                                            <button
                                                                onclick="scrollToLesson(<?php echo e($lessonIndex + 1); ?>)"
                                                                class="gradient-pink-blue hover:opacity-90 text-white px-3 py-2 rounded-lg text-sm inline-flex items-center transition-all">
                                                                Next <i class="fas fa-chevron-right ml-1"></i>
                                                            </button>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>

                
                <?php if($course->contents && count($course->contents) > 0): ?>
                    <?php
                        $hasContent = true;
                        $contentCount = count($course->contents);
                    ?>
                    <div class="space-y-4 <?php echo e($course->sections && count($course->sections) > 0 ? 'mt-8' : ''); ?>">
                        <?php if($course->sections && count($course->sections) > 0): ?>
                            <div class="bg-gradient-to-r from-pink-600/20 to-purple-600/20 rounded-xl p-4 border border-pink-500/30 mb-6">
                                <h3 class="text-lg font-bold text-white">
                                    <i class="fas fa-folder-open mr-2 text-pink-400"></i>
                                    Additional Course Materials
                                </h3>
                            </div>
                        <?php endif; ?>

                        <?php $__currentLoopData = $course->contents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $contentKey = 'content_' . $content->id;
                                $isCompleted = isset($userProgress[$contentKey]) && $userProgress[$contentKey]['is_completed'];
                                $progressPercent = isset($userProgress[$contentKey]) ? $userProgress[$contentKey]['progress_percentage'] : 0;
                            ?>
                            <div class="lesson-card overflow-hidden <?php echo e($isCompleted ? 'border-emerald-500/50' : ''); ?>" data-content-id="<?php echo e($content->id); ?>">
                                <div class="flex items-center justify-between p-4 border-b border-gray-700/50">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full <?php echo e($isCompleted ? 'bg-emerald-500' : 'gradient-pink-blue'); ?> flex items-center justify-center mr-4">
                                            <?php if($isCompleted): ?>
                                                <i class="fas fa-check text-white"></i>
                                            <?php else: ?>
                                                <span class="text-white font-bold"><?php echo e($index + 1); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <h3 class="text-white font-medium <?php echo e($isCompleted ? 'line-through opacity-75' : ''); ?>">
                                                <?php echo e($content->title ?? ($content->type === 'pdf' ? 'PDF Document' : ($content->type === 'youtube' ? 'Video Lesson' : 'Lesson Content'))); ?>

                                            </h3>
                                            <p class="text-gray-400 text-sm">
                                                <?php if($content->type === 'pdf'): ?>
                                                    <i class="fas fa-file-pdf mr-1"></i> PDF Material
                                                <?php elseif($content->type === 'youtube'): ?>
                                                    <i class="fas fa-play mr-1"></i> Video Lesson
                                                <?php else: ?>
                                                    <i class="fas fa-file-text mr-1"></i> Text Content
                                                <?php endif; ?>
                                                <?php if($isCompleted): ?>
                                                    • <span class="text-emerald-400">Completed</span>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs px-3 py-1 rounded-full <?php echo e($content->type === 'pdf' ? 'bg-red-500/20 text-red-300' : ($content->type === 'youtube' ? 'bg-blue-500/20 text-blue-300' : 'bg-gray-500/20 text-gray-300')); ?>">
                                            <?php echo e(ucfirst($content->type)); ?>

                                        </span>
                                        <?php if($isCompleted): ?>
                                            <span class="text-xs px-2 py-1 bg-emerald-500/20 text-emerald-300 rounded-full">
                                                <i class="fas fa-check mr-1"></i>Done
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <?php if($content->type === 'pdf'): ?>
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <i class="fas fa-file-pdf text-red-400 text-2xl mr-3"></i>
                                                <div>
                                                    <p class="text-white font-medium">PDF Document</p>
                                                    <p class="text-gray-400 text-sm">View or download the PDF material</p>
                                                </div>
                                            </div>
                                            <a href="<?php echo e(asset('storage/' . $content->file)); ?>" target="_blank"
                                               class="gradient-pink-blue hover:opacity-90 text-white px-4 py-2 rounded-lg text-sm inline-flex items-center transition-all transform hover:scale-105">
                                                <i class="fas fa-external-link-alt mr-2"></i> Open PDF
                                            </a>
                                        </div>
                                    <?php elseif($content->type === 'youtube'): ?>
                                        <div class="bg-gray-900 rounded-xl overflow-hidden">
                                            <iframe
                                                id="content-video-<?php echo e($content->id); ?>"
                                                src="<?php echo e(getYoutubeEmbedUrl($content->file)); ?>"
                                                class="w-full h-[400px]"
                                                frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen>
                                            </iframe>
                                        </div>
                                    <?php elseif($content->type === 'text'): ?>
                                        <div class="prose prose-dark max-w-none">
                                            <div class="text-gray-300 leading-relaxed">
                                                <?php echo $content->content; ?>

                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Content Controls -->
                                    <div class="mt-4 flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <?php if(!$isCompleted): ?>
                                                <button
                                                    onclick="markContentCompleted(<?php echo e($content->id); ?>)"
                                                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm inline-flex items-center transition-all transform hover:scale-105 active:scale-95">
                                                    <i class="fas fa-check mr-2"></i> Mark as Complete
                                                </button>
                                            <?php else: ?>
                                                <span class="bg-emerald-500/20 text-emerald-300 px-4 py-2 rounded-lg text-sm inline-flex items-center animate-pulse">
                                                    <i class="fas fa-check mr-2"></i> Completed
                                                </span>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Navigation buttons for contents -->
                                        <div class="flex items-center space-x-2">
                                            <?php if($index > 0): ?>
                                                <button
                                                    onclick="scrollToContentByIndex(<?php echo e($index - 1); ?>)"
                                                    class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded-lg text-sm inline-flex items-center transition-all">
                                                    <i class="fas fa-chevron-left mr-1"></i> Previous
                                                </button>
                                            <?php endif; ?>

                                            <?php if($index < count($course->contents) - 1): ?>
                                                <button
                                                    onclick="scrollToContentByIndex(<?php echo e($index + 1); ?>)"
                                                    class="gradient-pink-blue hover:opacity-90 text-white px-3 py-2 rounded-lg text-sm inline-flex items-center transition-all">
                                                    Next <i class="fas fa-chevron-right ml-1"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>

                
                <?php if(!$hasContent): ?>
                    <div class="text-center py-12">
                        <div class="w-20 h-20 mx-auto gradient-pink-purple rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-book text-white text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-2">No Content Available</h3>
                        <p class="text-gray-400">Content will be added soon. You'll be notified when new lessons are available.</p>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <!-- Preview for non-enrolled students -->
                <div class="text-center py-12">
                    <div class="w-20 h-20 mx-auto bg-gray-700/50 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-lock text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Course Content Locked</h3>
                    <p class="text-gray-400 mb-6">Enroll in this course to access all lessons and materials.</p>
                    <div class="bg-gray-800/50 rounded-xl p-6 max-w-md mx-auto">
                        <h4 class="text-white font-medium mb-4">What you'll get:</h4>
                        <ul class="space-y-2 text-sm text-gray-300">
                            <li class="flex items-center">
                                <i class="fas fa-check text-emerald-400 mr-2"></i>
                                <?php
                                    $totalLessons = 0;
                                    if($course->sections && count($course->sections) > 0) {
                                        foreach($course->sections as $section) {
                                            $totalLessons += count($section->lessons);
                                        }
                                    }
                                    if($course->contents && count($course->contents) > 0) {
                                        $totalLessons += count($course->contents);
                                    }
                                ?>
                                <?php echo e($totalLessons > 0 ? $totalLessons : 'Multiple'); ?> lessons and materials
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-emerald-400 mr-2"></i>
                                Lifetime access to course content
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-emerald-400 mr-2"></i>
                                Certificate of completion
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-emerald-400 mr-2"></i>
                                AI-powered practice questions
                            </li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Right Column - Course Details and Actions -->
    <div class="space-y-8">
        <!-- Course Stats -->
        <div class="course-card p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-chart-bar mr-3 text-pink-400"></i> Course Details
                </h2>
            </div>

            <div class="space-y-4">
                <div class="flex items-center p-3 bg-gray-800/50 rounded-xl">
                    <div class="w-12 h-12 rounded-full gradient-pink-blue flex items-center justify-center mr-4">
                        <i class="fas fa-user-tie text-white"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Instructor</p>
                        <p class="text-white font-medium"><?php echo e($course->teacher->username ?? 'Unknown Teacher'); ?></p>
                    </div>
                </div>

                <div class="flex items-center p-3 bg-gray-800/50 rounded-xl">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-purple-500 to-pink-600 flex items-center justify-center mr-4">
                        <i class="fas fa-layer-group text-white"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Category</p>
                        <p class="text-white font-medium"><?php echo e($course->category->name ?? 'Uncategorized'); ?></p>
                    </div>
                </div>

                <div class="flex items-center p-3 bg-gray-800/50 rounded-xl">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-emerald-500 to-teal-600 flex items-center justify-center mr-4">
                        <i class="fas fa-users text-white"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Students Enrolled</p>
                        <p class="text-white font-medium"><?php echo e($course->users()->count() ?? 0); ?> students</p>
                    </div>
                </div>

                <div class="flex items-center p-3 bg-gray-800/50 rounded-xl">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-yellow-500 to-orange-600 flex items-center justify-center mr-4">
                        <i class="fas fa-star text-white"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Rating</p>
                        <div class="flex items-center">
                            <div class="flex text-yellow-400 mr-2">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <?php if($i <= ($course->score ?? 4)): ?>
                                        <i class="fas fa-star"></i>
                                    <?php elseif($i - 0.5 <= ($course->score ?? 4)): ?>
                                        <i class="fas fa-star-half-alt"></i>
                                    <?php else: ?>
                                        <i class="far fa-star"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                            <span class="text-white font-medium"><?php echo e($course->score ?? 4); ?>/5</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course Actions -->
        <div class="course-card p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-tasks mr-3 text-pink-400"></i> Actions
                </h2>
            </div>

            <div class="space-y-4">
                <a href="<?php echo e(route('student.courses')); ?>"
                   class="w-full bg-gray-700 hover:bg-gray-600 text-white font-medium py-3 px-4 rounded-xl transition-all inline-flex items-center justify-center">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Courses
                </a>

                <?php if($isEnrolled): ?>
                    <!-- AI Practice Questions Button -->
                    <a href="<?php echo e(route('student.practice.dashboard', $course->id)); ?>"
                       class="w-full block bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-medium py-4 px-4 rounded-xl transition-all transform hover:scale-105 shadow-lg">
                        <div class="text-center">
                            <div class="flex items-center justify-center mb-2">
                                <i class="fas fa-robot text-xl mr-2"></i>
                                <span class="font-bold">AI Practice Questions</span>
                                <i class="fas fa-brain text-xl ml-2"></i>
                            </div>
                            <div class="text-sm opacity-90">
                                <i class="fab fa-google mr-1"></i> Powered by Gemini AI
                            </div>
                        </div>
                    </a>

                    <?php if($course->quizzes->isNotEmpty()): ?>
                        <?php if($canTakeQuiz): ?>
                            <a href="<?php echo e(route('student.quiz', $course->quizzes[0]->id)); ?>"
                               class="w-full gradient-pink-blue hover:opacity-90 text-white font-medium py-3 px-4 rounded-xl transition-all inline-flex items-center justify-center transform hover:scale-105">
                                <i class="fas fa-question-circle mr-2"></i> Take Quiz
                            </a>

                            <a href="<?php echo e(route('student.secureExam', $course->quizzes[0]->id)); ?>"
                               class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-4 rounded-xl transition-all inline-flex items-center justify-center transform hover:scale-105">
                                <i class="fas fa-lock mr-2"></i> Take Secure Exam
                            </a>
                        <?php else: ?>
                            <div class="w-full bg-gray-600/50 text-gray-400 font-medium py-3 px-4 rounded-xl cursor-not-allowed">
                                <div class="text-center">
                                    <i class="fas fa-lock mr-2"></i> Complete All Lessons First
                                    <div class="text-xs mt-1"><?php echo e($completedLessons); ?>/<?php echo e($totalLessons); ?> lessons completed</div>
                                </div>
                            </div>

                            <div class="bg-yellow-500/20 border border-yellow-500/50 text-yellow-300 p-3 rounded-xl text-sm">
                                <div class="flex items-start">
                                    <i class="fas fa-info-circle mr-2 mt-0.5"></i>
                                    <div>
                                        <p class="font-medium">Quiz Locked</p>
                                        <p class="text-xs mt-1">You must complete all <?php echo e($totalLessons); ?> lessons before taking the quiz.</p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <button disabled
                                class="w-full bg-gray-600 text-gray-400 font-medium py-3 px-4 rounded-xl cursor-not-allowed inline-flex items-center justify-center">
                            <i class="fas fa-question-circle mr-2"></i> No Quiz Available
                        </button>
                    <?php endif; ?>
                <?php elseif($enrollmentStatus === 'pending'): ?>
                    <div class="w-full bg-yellow-500/20 border border-yellow-400/50 text-yellow-300 font-medium py-4 px-4 rounded-xl inline-flex items-center justify-center">
                        <i class="fas fa-clock mr-2"></i> Enrollment Pending Approval
                    </div>
                <?php elseif($enrollmentStatus === 'rejected'): ?>
                    <div class="w-full bg-red-500/20 border border-red-400/50 text-red-300 font-medium py-4 px-4 rounded-xl inline-flex items-center justify-center">
                        <i class="fas fa-times-circle mr-2"></i> Enrollment Request Rejected
                    </div>
                <?php else: ?>
                    <form action="<?php echo e(route('student.enrollCourse', $course->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit"
                                class="w-full gradient-pink-blue hover:opacity-90 text-white font-bold py-4 px-4 rounded-xl transition-all transform hover:scale-105 shadow-lg">
                            <i class="fas fa-graduation-cap mr-2"></i> Request Enrollment
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// CSRF Token for AJAX requests
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const courseId = <?php echo e($course->id); ?>;

// Mark lesson as completed
function markLessonCompleted(lessonId) {
    console.log('Marking lesson completed:', lessonId);

    fetch(`/student/courses/${courseId}/lessons/${lessonId}/complete`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({})
    })
    .then(response => {
        console.log('Lesson response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Lesson response data:', data);
        if (data.success) {
            // Update UI
            const lessonCard = document.querySelector(`[data-lesson-id="${lessonId}"]`);
            console.log('Found lesson card:', lessonCard);

            if (lessonCard) {
                updateLessonUI(lessonCard, true);
            }

            // Show success message
            showNotification('Lesson completed successfully!', 'success');

            // Update progress immediately
            updateCourseProgress();

            // Refresh page to update progress
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            console.error('Server returned error:', data);
            showNotification('Error: ' + (data.message || 'Unknown error'), 'error');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        showNotification('Network error: ' + error.message, 'error');
    });
}

// Mark content as completed (for old system)
function markContentCompleted(contentId) {
    console.log('Marking content completed:', contentId);

    fetch(`/student/courses/${courseId}/contents/${contentId}/complete`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({})
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            // Update UI immediately
            const contentCard = document.querySelector(`[data-content-id="${contentId}"]`);
            console.log('Found content card:', contentCard);

            if (contentCard) {
                updateContentUI(contentCard, true);
            }

            // Show success message
            showNotification('Content completed successfully!', 'success');

            // Update progress bar and quiz access immediately
            updateCourseProgress();

            // Refresh page to update progress after a delay
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            console.error('Server returned error:', data);
            showNotification('Error: ' + (data.message || 'Unknown error'), 'error');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        showNotification('Network error: ' + error.message, 'error');
    });
}

// Update lesson UI
function updateLessonUI(lessonCard, isCompleted) {
    // Update completion status
    const numberCircle = lessonCard.querySelector('.w-10.h-10');
    if (isCompleted) {
        numberCircle.className = 'w-10 h-10 rounded-full bg-emerald-500 flex items-center justify-center mr-4';
        numberCircle.innerHTML = '<i class="fas fa-check text-white"></i>';
    }

    // Update title
    const title = lessonCard.querySelector('h4');
    if (title && isCompleted) {
        title.className = 'text-white font-medium line-through opacity-75';
    }

    // Update status text
    const statusText = lessonCard.querySelector('.text-gray-400');
    if (statusText && isCompleted) {
        statusText.innerHTML = statusText.innerHTML.replace(/• <span class="text-yellow-400">.*?<\/span>/, '') + ' • <span class="text-emerald-400">Completed</span>';
    }

    // Update button
    const button = lessonCard.querySelector('button[onclick*="markLessonCompleted"]');
    if (button && isCompleted) {
        button.outerHTML = '<span class="bg-emerald-500/20 text-emerald-300 px-4 py-2 rounded-lg text-sm inline-flex items-center"><i class="fas fa-check mr-2"></i> Completed</span>';
    }

    // Add completed badge
    const badgeContainer = lessonCard.querySelector('.flex.items-center.space-x-2');
    if (badgeContainer && isCompleted && !badgeContainer.querySelector('.bg-emerald-500\\/20')) {
        badgeContainer.innerHTML += '<span class="text-xs px-2 py-1 bg-emerald-500/20 text-emerald-300 rounded-full"><i class="fas fa-check mr-1"></i>Done</span>';
    }

    // Add border
    if (isCompleted) {
        lessonCard.classList.add('border-emerald-500/50');
    }
}

// Update content UI (for old system)
function updateContentUI(contentCard, isCompleted) {
    console.log('Updating content UI:', contentCard, isCompleted);

    if (!contentCard) {
        console.error('Content card not found');
        return;
    }

    // Update completion status
    const numberCircle = contentCard.querySelector('.w-10.h-10.rounded-full');
    console.log('Found number circle:', numberCircle);

    if (numberCircle && isCompleted) {
        numberCircle.className = 'w-10 h-10 rounded-full bg-emerald-500 flex items-center justify-center mr-4';
        numberCircle.innerHTML = '<i class="fas fa-check text-white"></i>';
    }

    // Update title
    const title = contentCard.querySelector('h3');
    console.log('Found title:', title);

    if (title && isCompleted) {
        title.classList.add('line-through', 'opacity-75');
    }

    // Update status text
    const statusText = contentCard.querySelector('.text-gray-400');
    console.log('Found status text:', statusText);

    if (statusText && isCompleted && !statusText.innerHTML.includes('Completed')) {
        statusText.innerHTML = statusText.innerHTML + ' • <span class="text-emerald-400">Completed</span>';
    }

    // Update button
    const button = contentCard.querySelector('button[onclick*="markContentCompleted"]');
    console.log('Found button:', button);

    if (button && isCompleted) {
        const completedSpan = document.createElement('span');
        completedSpan.className = 'bg-emerald-500/20 text-emerald-300 px-4 py-2 rounded-lg text-sm inline-flex items-center animate-pulse';
        completedSpan.innerHTML = '<i class="fas fa-check mr-2"></i> Completed';
        button.parentNode.replaceChild(completedSpan, button);
    }

    // Add completed badge
    const badgeContainer = contentCard.querySelector('.flex.items-center.space-x-2');
    console.log('Found badge container:', badgeContainer);

    if (badgeContainer && isCompleted) {
        const existingBadge = badgeContainer.querySelector('.bg-emerald-500\\/20');
        if (!existingBadge) {
            const badge = document.createElement('span');
            badge.className = 'text-xs px-2 py-1 bg-emerald-500/20 text-emerald-300 rounded-full';
            badge.innerHTML = '<i class="fas fa-check mr-1"></i>Done';
            badgeContainer.appendChild(badge);
        }
    }

    // Add border
    if (isCompleted) {
        contentCard.classList.add('border-emerald-500/50');
    }

    console.log('Content UI updated successfully');
}

// Update video progress
function updateVideoProgress(lessonId, currentTime, duration) {
    if (duration > 0) {
        const progress = Math.round((currentTime / duration) * 100);

        // Update progress every 10%
        if (progress % 10 === 0 && progress > 0) {
            fetch(`/student/courses/${courseId}/lessons/${lessonId}/progress`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    progress: progress,
                    position: currentTime
                })
            });
        }

        // Auto-complete when 90% watched
        if (progress >= 90) {
            markLessonCompleted(lessonId);
        }
    }
}

// Scroll to specific lesson
function scrollToLesson(lessonNumber) {
    const lessons = document.querySelectorAll('[data-lesson-id]');
    if (lessons[lessonNumber - 1]) {
        lessons[lessonNumber - 1].scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });

        // Highlight the lesson briefly
        lessons[lessonNumber - 1].style.boxShadow = '0 0 20px rgba(236, 72, 153, 0.5)';
        setTimeout(() => {
            lessons[lessonNumber - 1].style.boxShadow = '';
        }, 2000);
    }
}

// Scroll to specific content (for old system)
function scrollToContent(contentNumber) {
    console.log('Scrolling to content:', contentNumber);
    const contents = document.querySelectorAll('[data-content-id]');
    console.log('Found contents:', contents.length);

    if (contents[contentNumber - 1]) {
        contents[contentNumber - 1].scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });

        // Highlight the content briefly
        contents[contentNumber - 1].style.boxShadow = '0 0 20px rgba(236, 72, 153, 0.5)';
        setTimeout(() => {
            contents[contentNumber - 1].style.boxShadow = '';
        }, 2000);
    } else {
        console.log('Content not found at index:', contentNumber - 1);
    }
}

// Scroll to content by index (0-based)
function scrollToContentByIndex(index) {
    console.log('Scrolling to content by index:', index);
    const contents = document.querySelectorAll('[data-content-id]');
    console.log('Found contents:', contents.length);

    if (contents[index]) {
        contents[index].scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });

        // Highlight the content briefly
        contents[index].style.boxShadow = '0 0 20px rgba(236, 72, 153, 0.5)';
        setTimeout(() => {
            contents[index].style.boxShadow = '';
        }, 2000);
    } else {
        console.log('Content not found at index:', index);
    }
}

// Update course progress immediately
function updateCourseProgress() {
    try {
        // Count completed items more accurately
        const completedLessons = document.querySelectorAll('[data-lesson-id] .bg-emerald-500').length;
        const completedContents = document.querySelectorAll('[data-content-id] .bg-emerald-500').length;
        const totalLessons = document.querySelectorAll('[data-lesson-id]').length;
        const totalContents = document.querySelectorAll('[data-content-id]').length;
        const totalItems = totalLessons + totalContents;

        const completedTotal = completedLessons + completedContents;
        const newProgress = totalItems > 0 ? Math.round((completedTotal / totalItems) * 100) : 0;

        console.log('Progress Update:', {
            completedLessons,
            completedContents,
            totalLessons,
            totalContents,
            totalItems,
            completedTotal,
            newProgress
        });

        // Update progress bar
        const progressBarFill = document.getElementById('progress-bar-fill');
        if (progressBarFill) {
            progressBarFill.style.width = newProgress + '%';
            console.log('Updated progress bar to:', newProgress + '%');
        }

        // Update progress percentage text
        const progressPercentageText = document.getElementById('progress-percentage-text');
        if (progressPercentageText) {
            progressPercentageText.textContent = newProgress + '%';
            console.log('Updated progress percentage text to:', newProgress + '%');
        }

        // Update progress info in header
        const progressInfoHeader = document.getElementById('progress-info-header');
        if (progressInfoHeader) {
            const span = progressInfoHeader.querySelector('span');
            if (span) {
                span.textContent = `${newProgress}% Complete (${completedTotal}/${totalItems})`;
                console.log('Updated progress info header');
            }
        }

        // Enable/disable quiz buttons
        if (newProgress >= 100) {
            const quizButtons = document.querySelectorAll('a[href*="quiz"], a[href*="secureExam"]');
            quizButtons.forEach(button => {
                button.classList.remove('pointer-events-none', 'opacity-50');
            });
            console.log('Quiz buttons enabled');
        }

    } catch (error) {
        console.error('Error updating course progress:', error);
    }
}

// Show notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 ${
        type === 'success' ? 'bg-emerald-500 text-white' :
        type === 'error' ? 'bg-red-500 text-white' :
        'bg-blue-500 text-white'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : 'info'} mr-2"></i>
            ${message}
        </div>
    `;

    document.body.appendChild(notification);

    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Initialize video tracking for local videos
document.addEventListener('DOMContentLoaded', function() {
    const videos = document.querySelectorAll('video[data-lesson-id]');
    videos.forEach(video => {
        const lessonId = video.getAttribute('data-lesson-id');

        // Set saved position if available
        const savedPosition = <?php echo json_encode($userProgress ?? []); ?>;
        if (savedPosition[lessonId] && savedPosition[lessonId].last_position) {
            video.currentTime = savedPosition[lessonId].last_position;
        }

        // Track progress
        video.addEventListener('timeupdate', function() {
            updateVideoProgress(lessonId, this.currentTime, this.duration);
        });

        // Auto-complete on end
        video.addEventListener('ended', function() {
            if (typeof markLessonCompleted === 'function') {
                markLessonCompleted(lessonId);
            } else {
                console.log('Video ended for lesson:', lessonId);
            }
        });
    });

    // Initial progress calculation
    setTimeout(() => {
        console.log('Running initial progress calculation...');
        updateCourseProgress();
    }, 500);

    // Also update immediately on page load
    updateCourseProgress();

    console.log('Page initialized. Found:', {
        lessons: document.querySelectorAll('[data-lesson-id]').length,
        contents: document.querySelectorAll('[data-content-id]').length,
        videos: videos.length,
        courseId: courseId,
        csrfToken: csrfToken ? 'Present' : 'Missing'
    });

    // Test function for debugging
    window.testMarkComplete = function(contentId) {
        console.log('Testing mark complete for content:', contentId);
        markContentCompleted(contentId);
    };

    // Test function for navigation
    window.testNavigation = function(index) {
        console.log('Testing navigation to index:', index);
        scrollToContentByIndex(index);
    };

    // Simple test function to mark content as completed without AJAX
    window.testMarkCompleteSimple = function(contentId) {
        console.log('Testing simple mark complete for content:', contentId);
        const contentCard = document.querySelector(`[data-content-id="${contentId}"]`);
        if (contentCard) {
            updateContentUI(contentCard, true);
            updateCourseProgress();
            showNotification('Content marked as completed (test mode)!', 'success');
        } else {
            console.error('Content card not found for ID:', contentId);
        }
    };
});

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey || e.metaKey) {
        if (e.key === 'ArrowLeft') {
            e.preventDefault();
            // Go to previous lesson
            const currentLesson = document.querySelector('.lesson-card:hover, .lesson-card:focus-within');
            if (currentLesson) {
                const prevButton = currentLesson.querySelector('button[onclick*="scrollToLesson"][onclick*="- 1"]');
                if (prevButton) prevButton.click();
            }
        } else if (e.key === 'ArrowRight') {
            e.preventDefault();
            // Go to next lesson
            const currentLesson = document.querySelector('.lesson-card:hover, .lesson-card:focus-within');
            if (currentLesson) {
                const nextButton = currentLesson.querySelector('button[onclick*="scrollToLesson"][onclick*="+ 1"]');
                if (nextButton) nextButton.click();
            }
        }
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/student/courseDetails-new.blade.php ENDPATH**/ ?>