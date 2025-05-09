<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Course Analytics Report</title>
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
        .badge {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 9999px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-ai {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .badge-manual {
            background-color: #f3f4f6;
            color: #374151;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Course Analytics Report</h1>
        <p>{{ $analytics['course']->title }}</p>
        <p>Category: {{ $analytics['course']->category->name }}</p>
        <p>Generated on: {{ $analytics['generated_at'] }}</p>
    </div>
    
    <div class="section">
        <h2>Overall Statistics</h2>
        <div class="stats-grid">
            <div class="stat-box">
                <div class="label">Total Students</div>
                <div class="value">{{ $analytics['overall']['total_students'] }}</div>
            </div>
            <div class="stat-box">
                <div class="label">Total Quizzes</div>
                <div class="value">{{ $analytics['overall']['total_quizzes'] }}</div>
            </div>
            <div class="stat-box">
                <div class="label">Total Attempts</div>
                <div class="value">{{ $analytics['overall']['total_attempts'] }}</div>
            </div>
            <div class="stat-box">
                <div class="label">Average Score</div>
                <div class="value">{{ $analytics['overall']['average_score'] }}%</div>
            </div>
        </div>
    </div>
    
    <div class="section">
        <h2>Quiz Performance</h2>
        @if(count($analytics['quiz_performance']) > 0)
            <table>
                <thead>
                    <tr>
                        <th>Quiz</th>
                        <th>Type</th>
                        <th>Average Score</th>
                        <th>Attempts</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($analytics['quiz_performance'] as $quiz)
                        <tr>
                            <td>{{ $quiz['quiz_name'] }}</td>
                            <td>
                                @if(isset($quiz['is_ai_generated']) && $quiz['is_ai_generated'])
                                    <span class="badge badge-ai">AI Generated</span>
                                @else
                                    <span class="badge badge-manual">Manual</span>
                                @endif
                            </td>
                            <td>
                                {{ $quiz['average_score'] }}%
                                <div class="progress-bar">
                                    <div class="progress-bar-fill" style="width: {{ $quiz['average_score'] }}%"></div>
                                </div>
                            </td>
                            <td>{{ $quiz['attempt_count'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No quiz data available.</p>
        @endif
    </div>
    
    <div class="section">
        <h2>Course Content</h2>
        @if(count($analytics['course']->contents) > 0)
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Content</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($analytics['course']->contents as $index => $content)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ ucfirst($content->type) }}</td>
                            <td>{{ $content->file }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No content available for this course.</p>
        @endif
    </div>
    
    <div class="section">
        <h2>Recommendations</h2>
        <ul>
            @if($analytics['overall']['average_score'] < 70)
                <li>The average score is below 70%. Consider reviewing the course content to make it more accessible or providing additional learning resources.</li>
            @endif
            
            @if($analytics['overall']['total_attempts'] / $analytics['overall']['total_students'] < 1.5)
                <li>Students are not taking quizzes multiple times. Consider adding incentives for quiz retakes to improve learning.</li>
            @endif
            
            @if(count($analytics['quiz_performance']) > 0)
                @php
                    $lowestPerformingQuiz = collect($analytics['quiz_performance'])->sortBy('average_score')->first();
                @endphp
                @if($lowestPerformingQuiz && $lowestPerformingQuiz['average_score'] < 60)
                    <li>The quiz "{{ $lowestPerformingQuiz['quiz_name'] }}" has a low average score ({{ $lowestPerformingQuiz['average_score'] }}%). Consider reviewing its difficulty or providing more preparation materials.</li>
                @endif
            @endif
            
            @if(count($analytics['course']->contents) < 5)
                <li>The course has relatively few content items. Consider adding more diverse learning materials.</li>
            @endif
        </ul>
    </div>
    
    <div class="footer">
        <p>This report was automatically generated by BrightPath Learning Platform.</p>
        <p>&copy; {{ date('Y') }} BrightPath. All rights reserved.</p>
    </div>
</body>
</html>
