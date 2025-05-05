<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Option;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuestionGeneratorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:teacher');
    }

    /**
     * Generate questions for a quiz based on lesson content.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generateQuestions(Quiz $quiz)
    {
        // Get the lesson content
        $lesson = $quiz->lesson;

        if (!$lesson) {
            return redirect()->back()->with('error', 'Lesson not found.');
        }

        // Check if the teacher owns this quiz
        if ($lesson->module->course->teacher_id !== auth()->id()) {
            abort(403, 'You are not authorized to generate questions for this quiz.');
        }

        try {
            // Generate questions based on lesson content
            $this->createQuestionsFromContent($quiz, $lesson);

            return redirect()->route('teacher.quizzes.edit', $quiz)
                ->with('success', 'Questions generated successfully.');
        } catch (\Exception $e) {
            Log::error('Error generating questions: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Failed to generate questions. Please try again.');
        }
    }

    /**
     * Create questions from lesson content.
     *
     * @param  \App\Models\Quiz  $quiz
     * @param  \App\Models\Lesson  $lesson
     * @return void
     */
    private function createQuestionsFromContent(Quiz $quiz, Lesson $lesson)
    {
        // Get the lesson content
        $content = $lesson->content;

        if (empty($content)) {
            throw new \Exception('Lesson content is empty.');
        }

        // Split content into paragraphs
        $paragraphs = preg_split('/\r\n|\r|\n/', $content);
        $paragraphs = array_filter($paragraphs, function($paragraph) {
            return strlen(trim($paragraph)) > 50; // Only use paragraphs with substantial content
        });

        if (empty($paragraphs)) {
            throw new \Exception('Not enough content to generate questions.');
        }

        // Limit to 5 questions
        $numQuestions = min(5, count($paragraphs));
        $selectedParagraphs = array_rand(array_flip($paragraphs), $numQuestions);

        foreach ($selectedParagraphs as $index => $paragraph) {
            // Create different types of questions
            switch ($index % 3) {
                case 0:
                    $this->createMultipleChoiceQuestion($quiz, $paragraph);
                    break;
                case 1:
                    $this->createTrueFalseQuestion($quiz, $paragraph);
                    break;
                case 2:
                    $this->createShortAnswerQuestion($quiz, $paragraph);
                    break;
            }
        }
    }

    /**
     * Create a multiple choice question.
     *
     * @param  \App\Models\Quiz  $quiz
     * @param  string  $paragraph
     * @return void
     */
    private function createMultipleChoiceQuestion(Quiz $quiz, $paragraph)
    {
        // Extract key phrases from the paragraph
        $sentences = preg_split('/(?<=[.!?])\s+/', $paragraph);

        if (empty($sentences)) {
            return;
        }

        // Select a random sentence for the question
        $selectedSentence = $sentences[array_rand($sentences)];

        // Extract key terms
        preg_match_all('/\b[A-Z][a-z]{3,}\b|\b[a-z]{5,}\b/', $selectedSentence, $matches);
        $keyTerms = $matches[0] ?? [];

        if (empty($keyTerms)) {
            return;
        }

        // Select a random key term
        $keyTerm = $keyTerms[array_rand($keyTerms)];

        // Create the question
        $questionText = str_replace($keyTerm, '________', $selectedSentence);
        $questionText = 'Complete the following sentence: ' . $questionText;

        $question = Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => $questionText,
            'type' => 'multiple_choice',
            'points' => 1.0,
            'feedback' => 'This question was generated from the lesson content.',
        ]);

        // Create the correct option
        Option::create([
            'question_id' => $question->id,
            'option_text' => $keyTerm,
            'is_correct' => true,
        ]);

        // Create incorrect options
        $otherTerms = array_diff($keyTerms, [$keyTerm]);

        // If we don't have enough other terms, create some variations
        if (count($otherTerms) < 3) {
            $variations = [
                $keyTerm . 's',
                substr($keyTerm, 0, -1),
                strtoupper($keyTerm),
                $keyTerm . 'ing',
            ];

            $otherTerms = array_merge($otherTerms, $variations);
        }

        // Select 3 random incorrect options
        $incorrectOptions = array_slice(array_unique($otherTerms), 0, 3);

        foreach ($incorrectOptions as $option) {
            Option::create([
                'question_id' => $question->id,
                'option_text' => $option,
                'is_correct' => false,
            ]);
        }
    }

    /**
     * Create a true/false question.
     *
     * @param  \App\Models\Quiz  $quiz
     * @param  string  $paragraph
     * @return void
     */
    private function createTrueFalseQuestion(Quiz $quiz, $paragraph)
    {
        // Extract sentences from the paragraph
        $sentences = preg_split('/(?<=[.!?])\s+/', $paragraph);

        if (empty($sentences)) {
            return;
        }

        // Select a random sentence for the question
        $selectedSentence = $sentences[array_rand($sentences)];

        // Decide if we'll use a true or false statement
        $isTrue = (bool) rand(0, 1);

        if ($isTrue) {
            $questionText = 'True or False: ' . $selectedSentence;
        } else {
            // Modify the sentence to make it false
            $words = explode(' ', $selectedSentence);

            if (count($words) > 3) {
                // Swap two words to make the sentence false
                $index1 = rand(0, count($words) - 1);
                $index2 = rand(0, count($words) - 1);

                while ($index1 == $index2) {
                    $index2 = rand(0, count($words) - 1);
                }

                $temp = $words[$index1];
                $words[$index1] = $words[$index2];
                $words[$index2] = $temp;

                $modifiedSentence = implode(' ', $words);
                $questionText = 'True or False: ' . $modifiedSentence;
            } else {
                // If the sentence is too short, just negate it
                $questionText = 'True or False: It is NOT true that ' . $selectedSentence;
            }
        }

        $question = Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => $questionText,
            'type' => 'true_false',
            'points' => 1.0,
            'feedback' => 'This question was generated from the lesson content.',
        ]);

        // Create the options
        Option::create([
            'question_id' => $question->id,
            'option_text' => 'True',
            'is_correct' => $isTrue,
        ]);

        Option::create([
            'question_id' => $question->id,
            'option_text' => 'False',
            'is_correct' => !$isTrue,
        ]);
    }

    /**
     * Create a short answer question.
     *
     * @param  \App\Models\Quiz  $quiz
     * @param  string  $paragraph
     * @return void
     */
    private function createShortAnswerQuestion(Quiz $quiz, $paragraph)
    {
        // Extract key phrases from the paragraph
        $sentences = preg_split('/(?<=[.!?])\s+/', $paragraph);

        if (empty($sentences)) {
            return;
        }

        // Select a random sentence for the question
        $selectedSentence = $sentences[array_rand($sentences)];

        // Extract key terms
        preg_match_all('/\b[A-Z][a-z]{3,}\b|\b[a-z]{5,}\b/', $selectedSentence, $matches);
        $keyTerms = $matches[0] ?? [];

        if (empty($keyTerms)) {
            return;
        }

        // Select a random key term
        $keyTerm = $keyTerms[array_rand($keyTerms)];

        // Create the question
        $questionText = 'Based on the lesson content, what is meant by "' . $keyTerm . '"?';

        $question = Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => $questionText,
            'type' => 'short_answer',
            'points' => 1.0,
            'feedback' => 'This question was generated from the lesson content.',
        ]);

        // Create the correct option (answer)
        Option::create([
            'question_id' => $question->id,
            'option_text' => $keyTerm,
            'is_correct' => true,
        ]);
    }
}
