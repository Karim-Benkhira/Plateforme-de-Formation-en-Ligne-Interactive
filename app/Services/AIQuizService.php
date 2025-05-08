<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIQuizService
{
    /**
     * The API key for the AI service
     */
    protected $apiKey;

    /**
     * The base URL for the AI service
     */
    protected $baseUrl;

    /**
     * Create a new AI Quiz Service instance
     */
    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key');
        $this->baseUrl = config('services.openai.base_url', 'https://api.openai.com/v1');
    }

    /**
     * Generate a quiz based on course content
     *
     * @param Course $course
     * @param int $numQuestions
     * @param string $difficulty
     * @return array
     */
    public function generateQuiz(Course $course, int $numQuestions = 5, string $difficulty = 'medium')
    {
        try {
            // Get course content
            $content = $this->extractCourseContent($course);
            
            if (empty($content)) {
                return [
                    'success' => false,
                    'message' => 'No content available to generate quiz'
                ];
            }

            // Prepare prompt for AI
            $prompt = $this->preparePrompt($content, $numQuestions, $difficulty);
            
            // Call AI API
            $response = $this->callAIApi($prompt);
            
            if (!$response['success']) {
                return $response;
            }
            
            // Parse AI response into quiz questions
            $questions = $this->parseAIResponse($response['data']);
            
            return [
                'success' => true,
                'data' => $questions
            ];
        } catch (\Exception $e) {
            Log::error('Error generating quiz: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to generate quiz: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Extract content from a course
     *
     * @param Course $course
     * @return string
     */
    protected function extractCourseContent(Course $course)
    {
        $content = '';
        
        // Get course description
        $content .= $course->description . "\n\n";
        
        // Get course contents
        foreach ($course->contents as $courseContent) {
            if ($courseContent->type === 'text') {
                $content .= $courseContent->file . "\n\n";
            }
            // For PDF and other file types, we would need a text extraction service
            // For YouTube links, we might need a transcript service
        }
        
        return $content;
    }

    /**
     * Prepare the prompt for the AI
     *
     * @param string $content
     * @param int $numQuestions
     * @param string $difficulty
     * @return string
     */
    protected function preparePrompt(string $content, int $numQuestions, string $difficulty)
    {
        $prompt = "Based on the following educational content, generate {$numQuestions} multiple-choice questions with 4 options each at {$difficulty} difficulty level. For each question, indicate the correct answer. Format the response as a JSON array where each question object has 'question', 'options' (array of 4 strings), and 'correct_index' (0-based index of correct answer).\n\nContent:\n{$content}";
        
        return $prompt;
    }

    /**
     * Call the AI API
     *
     * @param string $prompt
     * @return array
     */
    protected function callAIApi(string $prompt)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are an educational quiz generator. Generate multiple-choice questions based on the provided content. Return the response in JSON format only.'],
                    ['role' => 'user', 'content' => $prompt]
                ],
                'temperature' => 0.7,
                'max_tokens' => 2000,
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                $content = $data['choices'][0]['message']['content'] ?? '';
                
                return [
                    'success' => true,
                    'data' => $content
                ];
            } else {
                Log::error('AI API error: ' . $response->body());
                return [
                    'success' => false,
                    'message' => 'Error from AI service: ' . $response->status()
                ];
            }
        } catch (\Exception $e) {
            Log::error('Error calling AI API: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to call AI service: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Parse the AI response into quiz questions
     *
     * @param string $aiResponse
     * @return array
     */
    protected function parseAIResponse(string $aiResponse)
    {
        try {
            // Extract JSON from the response (in case there's additional text)
            preg_match('/\[.*\]/s', $aiResponse, $matches);
            $jsonStr = $matches[0] ?? $aiResponse;
            
            // Parse JSON
            $questions = json_decode($jsonStr, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('Error parsing AI response: ' . json_last_error_msg());
                Log::error('AI response: ' . $aiResponse);
                return [];
            }
            
            return $questions;
        } catch (\Exception $e) {
            Log::error('Error parsing AI response: ' . $e->getMessage());
            Log::error('AI response: ' . $aiResponse);
            return [];
        }
    }

    /**
     * Save generated questions to the database
     *
     * @param Quiz $quiz
     * @param array $questions
     * @return bool
     */
    public function saveQuizQuestions(Quiz $quiz, array $questions)
    {
        try {
            foreach ($questions as $questionData) {
                $question = new Question();
                $question->quiz_id = $quiz->id;
                $question->question = $questionData['question'];
                $question->answers = implode(',', $questionData['options']);
                $question->correct = $questionData['correct_index'];
                $question->save();
            }
            
            return true;
        } catch (\Exception $e) {
            Log::error('Error saving quiz questions: ' . $e->getMessage());
            return false;
        }
    }
}
