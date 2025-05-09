<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student Performance Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }
        .header h1 {
            color: #2563eb;
            margin-bottom: 5px;
        }
        .header p {
            color: #666;
            margin: 0;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h2 {
            color: #1e40af;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        .stats-grid {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }
        .stat-box {
            flex: 1;
            min-width: 120px;
            margin: 10px;
            padding: 15px;
            background-color: #f9fafb;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .stat-box .label {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 5px;
        }
        .stat-box .value {
            font-size: 20px;
            font-weight: bold;
            color: #111827;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #f3f4f6;
            font-weight: bold;
            color: #374151;
        }
        .progress-bar {
            height: 10px;
            background-color: #e5e7eb;
            border-radius: 5px;
            overflow: hidden;
            margin-top: 5px;
        }
        .progress-bar-fill {
            height: 100%;
            background-color: #2563eb;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
        }
        .strength {
            color: #059669;
        }
        .weakness {
            color: #dc2626;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Student Performance Report</h1>
        <p><?php echo e($student->username); ?> (<?php echo e($student->email); ?>)</p>
        <p>Generated on: <?php echo e($generated_at); ?></p>
    </div>
    
    <div class="section">
        <h2>Overall Performance</h2>
        <div class="stats-grid">
            <div class="stat-box">
                <div class="label">Total Quizzes</div>
                <div class="value"><?php echo e($analytics['overall']['total_quizzes']); ?></div>
            </div>
            <div class="stat-box">
                <div class="label">Average Score</div>
                <div class="value"><?php echo e($analytics['overall']['average_score']); ?>%</div>
            </div>
            <div class="stat-box">
                <div class="label">Highest Score</div>
                <div class="value"><?php echo e($analytics['overall']['highest_score']); ?>%</div>
            </div>
            <div class="stat-box">
                <div class="label">Lowest Score</div>
                <div class="value"><?php echo e($analytics['overall']['lowest_score']); ?>%</div>
            </div>
        </div>
    </div>
    
    <div class="section">
        <h2>Performance by Course</h2>
        <?php if(count($analytics['course_performance']) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Average Score</th>
                        <th>Highest Score</th>
                        <th>Quizzes Taken</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $analytics['course_performance']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($course['course_name']); ?></td>
                            <td>
                                <?php echo e($course['average_score']); ?>%
                                <div class="progress-bar">
                                    <div class="progress-bar-fill" style="width: <?php echo e($course['average_score']); ?>%"></div>
                                </div>
                            </td>
                            <td><?php echo e($course['highest_score']); ?>%</td>
                            <td><?php echo e($course['quiz_count']); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No course data available.</p>
        <?php endif; ?>
    </div>
    
    <div class="section">
        <h2>Strengths & Weaknesses</h2>
        <div style="display: flex;">
            <div style="flex: 1; margin-right: 20px;">
                <h3>Strengths</h3>
                <?php if(count($analytics['strengths_weaknesses']['strengths']) > 0): ?>
                    <ul>
                        <?php $__currentLoopData = $analytics['strengths_weaknesses']['strengths']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $strength): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="strength"><?php echo e($strength['category_name']); ?> (<?php echo e($strength['average_score']); ?>%)</li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php else: ?>
                    <p>Not enough data to determine strengths.</p>
                <?php endif; ?>
            </div>
            <div style="flex: 1;">
                <h3>Areas for Improvement</h3>
                <?php if(count($analytics['strengths_weaknesses']['weaknesses']) > 0): ?>
                    <ul>
                        <?php $__currentLoopData = $analytics['strengths_weaknesses']['weaknesses']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $weakness): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="weakness"><?php echo e($weakness['category_name']); ?> (<?php echo e($weakness['average_score']); ?>%)</li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php else: ?>
                    <p>Not enough data to determine areas for improvement.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="section">
        <h2>Recent Activity</h2>
        <?php if(count($analytics['recent_activity']) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Quiz</th>
                        <th>Course</th>
                        <th>Score</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $analytics['recent_activity']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($activity['quiz_name']); ?></td>
                            <td><?php echo e($activity['course_name']); ?></td>
                            <td>
                                <?php echo e($activity['score']); ?>% (<?php echo e($activity['correct_answers']); ?>/<?php echo e($activity['total_questions']); ?>)
                                <div class="progress-bar">
                                    <div class="progress-bar-fill" style="width: <?php echo e($activity['score']); ?>%"></div>
                                </div>
                            </td>
                            <td><?php echo e($activity['date']); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No recent activity.</p>
        <?php endif; ?>
    </div>
    
    <div class="footer">
        <p>This report was automatically generated by BrightPath Learning Platform.</p>
        <p>&copy; <?php echo e(date('Y')); ?> BrightPath. All rights reserved.</p>
    </div>
</body>
</html>
<?php /**PATH /home/karim/Plateforme-de-Formation-en-Ligne-Interactive/resources/views/analytics/reports/student-report.blade.php ENDPATH**/ ?>