<?php

namespace App\Services;

use App\Models\Course;
use App\Models\User;
use App\Models\PracticeQuestion;
use App\Models\Content;
use App\Services\GeminiAIService;
use Illuminate\Support\Facades\Log;
use Exception;

class StudentPracticeService
{
    protected $geminiService;

    public function __construct(GeminiAIService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    /**
     * Check if student has completed the course and can generate practice questions
     */
    public function canGeneratePracticeQuestions(User $student, Course $course): array
    {
        // Check if student is enrolled in the course
        $isEnrolled = $student->enrolledCourses()->where('course_id', $course->id)->exists();

        if (!$isEnrolled) {
            return [
                'can_generate' => false,
                'reason' => 'not_enrolled',
                'message' => 'You must be enrolled in this course first'
            ];
        }

        // Check if student has completed at least one quiz in the course
        $hasCompletedQuiz = $student->quizResults()
            ->whereHas('quiz', function($query) use ($course) {
                $query->where('course_id', $course->id);
            })
            ->exists();

        if (!$hasCompletedQuiz) {
            return [
                'can_generate' => false,
                'reason' => 'no_quiz_completed',
                'message' => 'You must complete at least one quiz in this course to generate practice questions'
            ];
        }

        // Check if course has content
        $hasContent = $course->contents()->exists();

        if (!$hasContent) {
            return [
                'can_generate' => false,
                'reason' => 'no_content',
                'message' => 'This course does not have enough content to generate questions'
            ];
        }

        return [
            'can_generate' => true,
            'reason' => 'eligible',
            'message' => 'You can generate practice questions for this course'
        ];
    }

    /**
     * Generate practice questions for a student based on course content
     */
    public function generatePracticeQuestions(
        User $student,
        Course $course,
        array $options = []
    ): array {
        try {
            // Check eligibility first
            $eligibility = $this->canGeneratePracticeQuestions($student, $course);
            if (!$eligibility['can_generate']) {
                return [
                    'success' => false,
                    'message' => $eligibility['message'],
                    'reason' => $eligibility['reason']
                ];
            }

            // Set default options
            $options = array_merge([
                'num_questions' => 10,
                'difficulty' => 'medium',
                'question_type' => 'mixed',
                'language' => 'en'
            ], $options);

            // Get course content
            $courseContent = $this->extractCourseContent($course);

            if (empty($courseContent)) {
                return [
                    'success' => false,
                    'message' => 'Cannot extract sufficient content from the course',
                    'reason' => 'insufficient_content'
                ];
            }

            // Generate questions using Gemini AI
            $generatedQuestions = $this->geminiService->generatePracticeQuestions(
                $courseContent,
                $options['num_questions'],
                $options['difficulty'],
                $options['question_type'],
                $options['language']
            );

            if (empty($generatedQuestions)) {
                return [
                    'success' => false,
                    'message' => 'Failed to generate questions. Please try again.',
                    'reason' => 'generation_failed'
                ];
            }

            // Save questions to database
            $savedQuestions = $this->savePracticeQuestions(
                $student,
                $course,
                $generatedQuestions,
                $options
            );

            return [
                'success' => true,
                'message' => 'Practice questions generated successfully',
                'questions_count' => count($savedQuestions),
                'questions' => $savedQuestions
            ];

        } catch (Exception $e) {
            Log::error('Error generating practice questions: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'An error occurred while generating questions. Please try again.',
                'reason' => 'system_error'
            ];
        }
    }

    /**
     * Extract content from course for AI processing
     */
    protected function extractCourseContent(Course $course): string
    {
        $content = [];

        // Add course title and description
        $content[] = "عنوان الكورس: " . $course->title;
        if ($course->description) {
            $content[] = "وصف الكورس: " . $course->description;
        }

        // Get course contents
        $courseContents = $course->contents;

        foreach ($courseContents as $courseContent) {
            if ($courseContent->content) {
                $content[] = $courseContent->content;
            }
        }

        // Combine all content
        $fullContent = implode("\n\n", $content);

        // Limit content length to avoid API limits (max 8000 characters)
        if (strlen($fullContent) > 8000) {
            $fullContent = substr($fullContent, 0, 8000) . "...";
        }

        return $fullContent;
    }

    /**
     * Save generated questions to database
     */
    protected function savePracticeQuestions(
        User $student,
        Course $course,
        array $questions,
        array $options
    ): array {
        $savedQuestions = [];

        foreach ($questions as $questionData) {
            try {
                $practiceQuestion = PracticeQuestion::create([
                    'user_id' => $student->id,
                    'course_id' => $course->id,
                    'type' => $questionData['type'],
                    'question' => $questionData['question'],
                    'options' => $questionData['options'] ?? null,
                    'correct_answer' => $questionData['correct_answer'] ?? null,
                    'explanation' => $questionData['explanation'] ?? null,
                    'sample_answer' => $questionData['sample_answer'] ?? null,
                    'key_points' => $questionData['key_points'] ?? null,
                    'difficulty' => $questionData['difficulty'] ?? $options['difficulty'],
                    'language' => $options['language'],
                    'is_ai_generated' => true,
                    'ai_service' => 'gemini'
                ]);

                $savedQuestions[] = $practiceQuestion;

            } catch (Exception $e) {
                Log::error('Error saving practice question: ' . $e->getMessage());
                continue;
            }
        }

        return $savedQuestions;
    }

    /**
     * Get existing practice questions for a student and course
     */
    public function getPracticeQuestions(User $student, Course $course, array $filters = []): array
    {
        $query = PracticeQuestion::forUserAndCourse($student->id, $course->id);

        // Apply filters
        if (isset($filters['type'])) {
            $query->byType($filters['type']);
        }

        if (isset($filters['difficulty'])) {
            $query->byDifficulty($filters['difficulty']);
        }

        if (isset($filters['answered'])) {
            if ($filters['answered']) {
                $query->answered();
            } else {
                $query->unanswered();
            }
        }

        $questions = $query->orderBy('created_at', 'desc')->get();

        return [
            'questions' => $questions,
            'statistics' => PracticeQuestion::getStatistics($student->id, $course->id)
        ];
    }

    /**
     * Answer a practice question
     */
    public function answerQuestion(PracticeQuestion $question, string $userAnswer): array
    {
        try {
            $isCorrect = $question->answer($userAnswer);

            return [
                'success' => true,
                'is_correct' => $isCorrect,
                'correct_answer' => $question->correct_answer,
                'explanation' => $question->explanation,
                'message' => $isCorrect ? 'Correct answer! Well done.' : 'Incorrect answer. Please review the explanation.'
            ];

        } catch (Exception $e) {
            Log::error('Error answering practice question: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'An error occurred while saving the answer'
            ];
        }
    }

    /**
     * Get practice session recommendations for a student
     */
    public function getRecommendations(User $student, Course $course): array
    {
        $statistics = PracticeQuestion::getStatistics($student->id, $course->id);

        $recommendations = [];

        // If no questions generated yet
        if ($statistics['total'] === 0) {
            $recommendations[] = [
                'type' => 'generate',
                'title' => 'Start Practice',
                'description' => 'Generate practice questions for this course',
                'action' => 'generate_questions'
            ];
        }

        // If there are unanswered questions
        if ($statistics['unanswered'] > 0) {
            $recommendations[] = [
                'type' => 'practice',
                'title' => 'Continue Practice',
                'description' => "You have {$statistics['unanswered']} unanswered questions",
                'action' => 'continue_practice'
            ];
        }

        // If accuracy is low
        if ($statistics['answered'] > 0 && $statistics['accuracy'] < 70) {
            $recommendations[] = [
                'type' => 'review',
                'title' => 'Review Mistakes',
                'description' => "Your accuracy is {$statistics['accuracy']}%. Review incorrect questions",
                'action' => 'review_mistakes'
            ];
        }

        // If doing well, suggest more questions
        if ($statistics['answered'] > 0 && $statistics['accuracy'] >= 80) {
            $recommendations[] = [
                'type' => 'advance',
                'title' => 'Try Harder Challenge',
                'description' => 'Great performance! Try more difficult questions',
                'action' => 'generate_harder'
            ];
        }

        return $recommendations;
    }
}
