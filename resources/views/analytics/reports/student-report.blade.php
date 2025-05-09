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
        <p>{{ $student->username }} ({{ $student->email }})</p>
        <p>Generated on: {{ $generated_at }}</p>
    </div>
    
    <div class="section">
        <h2>Overall Performance</h2>
        <div class="stats-grid">
            <div class="stat-box">
                <div class="label">Total Quizzes</div>
                <div class="value">{{ $analytics['overall']['total_quizzes'] }}</div>
            </div>
            <div class="stat-box">
                <div class="label">Average Score</div>
                <div class="value">{{ $analytics['overall']['average_score'] }}%</div>
            </div>
            <div class="stat-box">
                <div class="label">Highest Score</div>
                <div class="value">{{ $analytics['overall']['highest_score'] }}%</div>
            </div>
            <div class="stat-box">
                <div class="label">Lowest Score</div>
                <div class="value">{{ $analytics['overall']['lowest_score'] }}%</div>
            </div>
        </div>
    </div>
    
    <div class="section">
        <h2>Performance by Course</h2>
        @if(count($analytics['course_performance']) > 0)
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
                    @foreach($analytics['course_performance'] as $course)
                        <tr>
                            <td>{{ $course['course_name'] }}</td>
                            <td>
                                {{ $course['average_score'] }}%
                                <div class="progress-bar">
                                    <div class="progress-bar-fill" style="width: {{ $course['average_score'] }}%"></div>
                                </div>
                            </td>
                            <td>{{ $course['highest_score'] }}%</td>
                            <td>{{ $course['quiz_count'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No course data available.</p>
        @endif
    </div>
    
    <div class="section">
        <h2>Strengths & Weaknesses</h2>
        <div style="display: flex;">
            <div style="flex: 1; margin-right: 20px;">
                <h3>Strengths</h3>
                @if(count($analytics['strengths_weaknesses']['strengths']) > 0)
                    <ul>
                        @foreach($analytics['strengths_weaknesses']['strengths'] as $strength)
                            <li class="strength">{{ $strength['category_name'] }} ({{ $strength['average_score'] }}%)</li>
                        @endforeach
                    </ul>
                @else
                    <p>Not enough data to determine strengths.</p>
                @endif
            </div>
            <div style="flex: 1;">
                <h3>Areas for Improvement</h3>
                @if(count($analytics['strengths_weaknesses']['weaknesses']) > 0)
                    <ul>
                        @foreach($analytics['strengths_weaknesses']['weaknesses'] as $weakness)
                            <li class="weakness">{{ $weakness['category_name'] }} ({{ $weakness['average_score'] }}%)</li>
                        @endforeach
                    </ul>
                @else
                    <p>Not enough data to determine areas for improvement.</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="section">
        <h2>Recent Activity</h2>
        @if(count($analytics['recent_activity']) > 0)
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
                    @foreach($analytics['recent_activity'] as $activity)
                        <tr>
                            <td>{{ $activity['quiz_name'] }}</td>
                            <td>{{ $activity['course_name'] }}</td>
                            <td>
                                {{ $activity['score'] }}% ({{ $activity['correct_answers'] }}/{{ $activity['total_questions'] }})
                                <div class="progress-bar">
                                    <div class="progress-bar-fill" style="width: {{ $activity['score'] }}%"></div>
                                </div>
                            </td>
                            <td>{{ $activity['date'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No recent activity.</p>
        @endif
    </div>
    
    <div class="footer">
        <p>This report was automatically generated by BrightPath Learning Platform.</p>
        <p>&copy; {{ date('Y') }} BrightPath. All rights reserved.</p>
    </div>
</body>
</html>
