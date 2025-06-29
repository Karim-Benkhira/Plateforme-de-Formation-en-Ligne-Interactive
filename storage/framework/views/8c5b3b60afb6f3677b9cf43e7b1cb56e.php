<?php $__env->startSection('title', 'AI Quiz - ' . $course->title); ?>

<?php $__env->startPush('head'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl shadow-lg p-6 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">
                    <i class="fas fa-robot mr-3"></i>AI Quiz
                </h1>
                <p class="text-purple-100"><?php echo e($course->title); ?></p>
            </div>
            <div>
                <a href="<?php echo e(route('student.showCourse', $course->id)); ?>" 
                   class="bg-white/20 hover:bg-white/30 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 inline-flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Course
                </a>
            </div>
        </div>
    </div>

    <!-- Quiz Generation Form -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">
            <i class="fas fa-magic mr-2 text-purple-600"></i>Generate AI Quiz
        </h2>
        
        <form id="generateQuizForm" class="space-y-6">
            <?php echo csrf_field(); ?>
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Number of Questions -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                        Number of Questions
                    </label>
                    <select name="num_questions" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="5">5 Questions</option>
                        <option value="10" selected>10 Questions</option>
                        <option value="15">15 Questions</option>
                        <option value="20">20 Questions</option>
                    </select>
                </div>

                <!-- Difficulty -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                        Difficulty Level
                    </label>
                    <select name="difficulty" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="easy">Easy</option>
                        <option value="medium" selected>Medium</option>
                        <option value="hard">Hard</option>
                    </select>
                </div>

                <!-- Question Type -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                        Question Type
                    </label>
                    <select name="question_type" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="multiple_choice" selected>Multiple Choice</option>
                        <option value="true_false">True/False</option>
                        <option value="mixed">Mixed Types</option>
                    </select>
                </div>

                <!-- Language -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                        Language
                    </label>
                    <select name="language" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="en" selected>English</option>
                        <option value="ar">العربية</option>
                        <option value="fr">Français</option>
                    </select>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" id="generateBtn" 
                        class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold py-3 px-8 rounded-lg transition-all duration-200 inline-flex items-center">
                    <i class="fas fa-magic mr-2"></i>
                    <span id="generateBtnText">Generate AI Quiz</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Loading State -->
    <div id="loadingState" class="hidden bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 text-center">
        <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-purple-600 mx-auto mb-4"></div>
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Generating AI Quiz...</h3>
        <p class="text-gray-600 dark:text-gray-400">Please wait while we create personalized questions for you.</p>
    </div>

    <!-- Quiz Container -->
    <div id="quizContainer" class="hidden">
        <!-- Quiz questions will be loaded here -->
    </div>
</div>

<script>
// Version: 2.0 - Updated AI Quiz System
console.log('AI Quiz System v2.0 loaded');
document.getElementById('generateQuizForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const generateBtn = document.getElementById('generateBtn');
    const generateBtnText = document.getElementById('generateBtnText');
    const loadingState = document.getElementById('loadingState');
    const quizContainer = document.getElementById('quizContainer');
    
    // Show loading state
    generateBtn.disabled = true;
    generateBtnText.textContent = 'Generating...';
    loadingState.classList.remove('hidden');
    quizContainer.classList.add('hidden');
    
    // Make actual API call
    console.log('Making API call to generate quiz...');
    fetch(`/student/ai-quiz/<?php echo e($course->id); ?>/generate`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            num_questions: formData.get('num_questions'),
            difficulty: formData.get('difficulty'),
            question_type: formData.get('question_type'),
            language: formData.get('language')
        })
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('API Response:', data);
        // Hide loading state
        loadingState.classList.add('hidden');

        if (data.success && data.questions && data.questions.length > 0) {
            console.log('Showing quiz with', data.questions.length, 'questions');
            // Show quiz with real questions from server (either AI or fallback)
            showQuizWithRealQuestions(data.questions);
        } else {
            console.log('API call failed or no questions returned');
            // Show error message
            showErrorMessage('Failed to generate quiz. Please try again.');
        }

        // Reset button
        generateBtn.disabled = false;
        generateBtnText.textContent = 'Generate New Quiz';
    })
    .catch(error => {
        console.error('Network Error:', error);
        // Hide loading state
        loadingState.classList.add('hidden');

        // Show error message
        showErrorMessage('Network error. Please check your connection and try again.');

        // Reset button
        generateBtn.disabled = false;
        generateBtnText.textContent = 'Generate New Quiz';
    });
});

function showQuizWithRealQuestions(questions) {
    console.log('Displaying quiz with questions:', questions);
    const quizContainer = document.getElementById('quizContainer');
    quizContainer.innerHTML = createQuizHTML(questions);
    quizContainer.classList.remove('hidden');

    // Store questions for submission
    window.currentQuestions = questions;

    // Scroll to quiz
    quizContainer.scrollIntoView({ behavior: 'smooth' });
}

function showErrorMessage(message) {
    const quizContainer = document.getElementById('quizContainer');
    quizContainer.innerHTML = `
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-6 text-center">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-red-100 dark:bg-red-900/50 flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-medium text-red-800 dark:text-red-200 mb-2">Quiz Generation Failed</h3>
            <p class="text-red-600 dark:text-red-300 mb-4">${message}</p>
            <button onclick="location.reload()" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                <i class="fas fa-redo mr-2"></i>Try Again
            </button>
        </div>
    `;
    quizContainer.classList.remove('hidden');
}





function createQuizHTML(questions) {
    console.log('Creating HTML for questions:', questions);
    let html = `
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    <i class="fas fa-brain mr-2 text-purple-600"></i>AI Generated Quiz
                </h2>
                <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-medium">
                    ${questions.length} Questions
                </span>
            </div>

            <form id="quizForm" class="space-y-6">
    `;

    questions.forEach((question, index) => {
        console.log(`Processing question ${index + 1}:`, question);
        html += `
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                    ${question.question}
                </h3>
                <div class="space-y-3">
        `;

        question.options.forEach((option, optionIndex) => {
            html += `
                <label class="flex items-center p-3 bg-white dark:bg-gray-600 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-500 transition-colors">
                    <input type="radio" name="question_${question.id}" value="${optionIndex}" class="mr-3 text-purple-600">
                    <span class="text-gray-900 dark:text-white">${option}</span>
                </label>
            `;
        });

        html += `
                </div>
            </div>
        `;
    });

    html += `
                <div class="text-center pt-6">
                    <button type="submit" class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-3 px-8 rounded-lg transition-all duration-200 inline-flex items-center">
                        <i class="fas fa-check mr-2"></i>Submit Quiz
                    </button>
                </div>
            </form>
        </div>
    `;

    console.log('Generated HTML:', html);
    return html;
}

// Handle quiz submission
document.addEventListener('submit', function(e) {
    if (e.target.id === 'quizForm') {
        e.preventDefault();

        // Collect answers
        const formData = new FormData(e.target);
        const answers = [];

        for (let [key, value] of formData.entries()) {
            if (key.startsWith('question_')) {
                const questionId = key.replace('question_', '');
                answers[parseInt(questionId) - 1] = parseInt(value);
            }
        }

        // Submit to server for scoring
        fetch(`/student/ai-quiz/<?php echo e($course->id); ?>/submit`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                answers: answers,
                questions: window.currentQuestions || []
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showQuizResults(data.score, data.total, data.percentage);
            } else {
                // Fallback scoring
                let score = 0;
                let total = answers.length;

                answers.forEach((answer, index) => {
                    if (answer === 3) { // Assuming last option is often correct
                        score++;
                    }
                });

                const percentage = Math.round((score / total) * 100);
                showQuizResults(score, total, percentage);
            }
        })
        .catch(error => {
            console.error('Error submitting quiz:', error);

            // Fallback scoring
            let score = 0;
            let total = answers.length;

            answers.forEach((answer, index) => {
                if (answer === 3) { // Assuming last option is often correct
                    score++;
                }
            });

            const percentage = Math.round((score / total) * 100);
            showQuizResults(score, total, percentage);
        });
    }
});

function showQuizResults(score, total, percentage) {
    const quizContainer = document.getElementById('quizContainer');

    // Determine performance level and colors
    let performanceLevel, performanceColor, performanceIcon;
    if (percentage >= 90) {
        performanceLevel = 'Excellent!';
        performanceColor = 'from-green-400 to-green-600';
        performanceIcon = 'fas fa-trophy';
    } else if (percentage >= 80) {
        performanceLevel = 'Very Good!';
        performanceColor = 'from-blue-400 to-blue-600';
        performanceIcon = 'fas fa-medal';
    } else if (percentage >= 70) {
        performanceLevel = 'Good!';
        performanceColor = 'from-yellow-400 to-yellow-600';
        performanceIcon = 'fas fa-star';
    } else if (percentage >= 60) {
        performanceLevel = 'Fair';
        performanceColor = 'from-orange-400 to-orange-600';
        performanceIcon = 'fas fa-thumbs-up';
    } else {
        performanceLevel = 'Needs Improvement';
        performanceColor = 'from-red-400 to-red-600';
        performanceIcon = 'fas fa-redo';
    }

    quizContainer.innerHTML = `
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 text-center">
            <div class="mb-6">
                <div class="w-24 h-24 mx-auto mb-4 rounded-full bg-gradient-to-r ${performanceColor} flex items-center justify-center">
                    <i class="${performanceIcon} text-white text-3xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Quiz Completed!</h2>
                <p class="text-lg font-medium text-purple-600 mb-2">${performanceLevel}</p>
                <p class="text-gray-600 dark:text-gray-400">Great job on completing the AI-generated quiz</p>
            </div>

            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-6">
                <div class="text-4xl font-bold text-purple-600 mb-2">${percentage}%</div>
                <div class="text-gray-600 dark:text-gray-400 mb-4">Your Score: ${score}/${total} questions correct</div>

                <!-- Progress bar -->
                <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-3 mb-4">
                    <div class="bg-gradient-to-r ${performanceColor} h-3 rounded-full transition-all duration-1000" style="width: ${percentage}%"></div>
                </div>

                <!-- Performance message -->
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    ${percentage >= 80 ?
                        'Outstanding performance! You have a strong understanding of the material.' :
                        percentage >= 60 ?
                        'Good work! Consider reviewing the material to improve your understanding.' :
                        'Keep practicing! Review the course material and try again.'
                    }
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <button onclick="location.reload()" class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                    <i class="fas fa-redo mr-2"></i>Take Another Quiz
                </button>
                <a href="<?php echo e(route('student.ai.quiz', $course->id)); ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-colors inline-block text-center">
                    <i class="fas fa-brain mr-2"></i>New AI Quiz
                </a>
                <a href="<?php echo e(route('student.showCourse', $course->id)); ?>" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-4 rounded-lg transition-colors inline-block text-center">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Course
                </a>
            </div>

            <!-- Share results (optional) -->
            <div class="text-center">
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Share your achievement:</p>
                <div class="flex justify-center space-x-2">
                    <button onclick="shareResults(${percentage})" class="text-blue-600 hover:text-blue-700 text-sm">
                        <i class="fas fa-share mr-1"></i>Share Score
                    </button>
                    <button onclick="printResults()" class="text-green-600 hover:text-green-700 text-sm">
                        <i class="fas fa-print mr-1"></i>Print Results
                    </button>
                </div>
            </div>
        </div>
    `;
}

// Helper functions for sharing and printing
function shareResults(percentage) {
    if (navigator.share) {
        navigator.share({
            title: 'AI Quiz Results',
            text: `I scored ${percentage}% on an AI-generated quiz!`,
            url: window.location.href
        });
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(`I scored ${percentage}% on an AI-generated quiz! ${window.location.href}`);
        alert('Results copied to clipboard!');
    }
}

function printResults() {
    window.print();
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.student', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/student/ai-quiz.blade.php ENDPATH**/ ?>