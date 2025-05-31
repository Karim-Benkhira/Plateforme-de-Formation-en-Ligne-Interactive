<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class GeminiAIService
{
    protected $apiKey;
    protected $baseUrl;
    protected $model;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->baseUrl = config('services.gemini.base_url', 'https://generativelanguage.googleapis.com/v1beta');
        $this->model = config('services.gemini.model', 'gemini-pro');
    }

    /**
     * Generate practice questions for students based on course content
     *
     * @param string $courseContent The course content to generate questions from
     * @param int $numQuestions Number of questions to generate
     * @param string $difficulty Difficulty level (easy, medium, hard)
     * @param string $questionType Type of questions (multiple_choice, true_false, short_answer, mixed)
     * @param string $language Language for questions (ar, en, fr)
     * @return array Generated questions
     */
    public function generatePracticeQuestions(
        string $courseContent,
        int $numQuestions = 10,
        string $difficulty = 'medium',
        string $questionType = 'mixed',
        string $language = 'en'
    ): array {
        try {
            $prompt = $this->buildPracticePrompt($courseContent, $numQuestions, $difficulty, $questionType, $language);
            $response = $this->callGeminiAPI($prompt);

            return $this->parsePracticeResponse($response, $questionType);
        } catch (Exception $e) {
            Log::error('Error generating practice questions with Gemini: ' . $e->getMessage());

            // Fallback to local generation if API fails
            return $this->localFallbackGeneration($courseContent, $numQuestions, $difficulty, $questionType, $language);
        }
    }

    /**
     * Build the prompt for practice question generation
     */
    protected function buildPracticePrompt(
        string $courseContent,
        int $numQuestions,
        string $difficulty,
        string $questionType,
        string $language
    ): string {
        $languageInstructions = [
            'ar' => 'يرجى إنشاء الأسئلة باللغة العربية',
            'en' => 'Please generate questions in English',
            'fr' => 'Veuillez générer les questions en français'
        ];

        $difficultyDescriptions = [
            'easy' => $language === 'ar' ? 'سهلة - أسئلة أساسية ومباشرة' : 'Easy - Basic and straightforward questions',
            'medium' => $language === 'ar' ? 'متوسطة - أسئلة تتطلب فهم وتحليل' : 'Medium - Questions requiring understanding and analysis',
            'hard' => $language === 'ar' ? 'صعبة - أسئلة تتطلب تفكير نقدي وتطبيق' : 'Hard - Questions requiring critical thinking and application'
        ];

        $typeInstructions = [
            'multiple_choice' => $language === 'ar' ? 'اختيار من متعدد مع 4 خيارات' : 'Multiple choice with 4 options',
            'true_false' => $language === 'ar' ? 'صح أو خطأ مع تفسير' : 'True/False with explanation',
            'short_answer' => $language === 'ar' ? 'إجابة قصيرة (2-3 جمل)' : 'Short answer (2-3 sentences)',
            'mixed' => $language === 'ar' ? 'مزيج من جميع الأنواع' : 'Mix of all question types'
        ];

        $prompt = $language === 'ar' ?
            "أنت مساعد تعليمي ذكي متخصص في إنشاء أسئلة تدريبية للطلاب.\n\n" :
            "You are an intelligent educational assistant specialized in creating practice questions for students.\n\n";

        $prompt .= $language === 'ar' ?
            "المهمة: إنشاء {$numQuestions} سؤال تدريبي بمستوى {$difficultyDescriptions[$difficulty]} من نوع {$typeInstructions[$questionType]}.\n\n" :
            "Task: Generate {$numQuestions} practice questions at {$difficultyDescriptions[$difficulty]} level of type {$typeInstructions[$questionType]}.\n\n";

        $prompt .= $language === 'ar' ?
            "المحتوى التعليمي:\n{$courseContent}\n\n" :
            "Course Content:\n{$courseContent}\n\n";

        $prompt .= $language === 'ar' ?
            "متطلبات الأسئلة:\n" :
            "Question Requirements:\n";

        if ($language === 'ar') {
            $prompt .= "- يجب أن تكون الأسئلة مفيدة للمراجعة والتدريب\n";
            $prompt .= "- يجب أن تغطي النقاط الرئيسية في المحتوى\n";
            $prompt .= "- يجب أن تكون واضحة ومفهومة\n";
            $prompt .= "- يجب أن تساعد الطالب على فهم المفاهيم بشكل أفضل\n\n";
        } else {
            $prompt .= "- Questions should be useful for review and practice\n";
            $prompt .= "- Questions should cover key points in the content\n";
            $prompt .= "- Questions should be clear and understandable\n";
            $prompt .= "- Questions should help students better understand concepts\n\n";
        }

        $prompt .= $this->getFormatInstructions($questionType, $language);

        return $prompt;
    }

    /**
     * Get format instructions based on question type and language
     */
    protected function getFormatInstructions(string $questionType, string $language): string
    {
        if ($language === 'ar') {
            $instructions = "تنسيق الإجابة: يرجى إرجاع الأسئلة في تنسيق JSON كما يلي:\n\n";
        } else {
            $instructions = "Response Format: Please return the questions in JSON format as follows:\n\n";
        }

        $instructions .= "```json\n[\n";

        if ($questionType === 'multiple_choice' || $questionType === 'mixed') {
            $instructions .= "  {\n";
            $instructions .= "    \"type\": \"multiple_choice\",\n";
            $instructions .= $language === 'ar' ?
                "    \"question\": \"نص السؤال هنا\",\n" :
                "    \"question\": \"Question text here\",\n";
            $instructions .= "    \"options\": [\"A\", \"B\", \"C\", \"D\"],\n";
            $instructions .= $language === 'ar' ?
                "    \"correct_answer\": \"A\",\n    \"explanation\": \"تفسير الإجابة الصحيحة\"\n" :
                "    \"correct_answer\": \"A\",\n    \"explanation\": \"Explanation of correct answer\"\n";
            $instructions .= "  }";
        }

        if ($questionType === 'true_false' || $questionType === 'mixed') {
            if ($questionType === 'mixed') $instructions .= ",\n";
            $instructions .= "  {\n";
            $instructions .= "    \"type\": \"true_false\",\n";
            $instructions .= $language === 'ar' ?
                "    \"question\": \"نص السؤال هنا\",\n" :
                "    \"question\": \"Question text here\",\n";
            $instructions .= $language === 'ar' ?
                "    \"correct_answer\": \"صح\",\n    \"explanation\": \"تفسير الإجابة\"\n" :
                "    \"correct_answer\": \"true\",\n    \"explanation\": \"Answer explanation\"\n";
            $instructions .= "  }";
        }

        if ($questionType === 'short_answer' || $questionType === 'mixed') {
            if ($questionType === 'mixed') $instructions .= ",\n";
            $instructions .= "  {\n";
            $instructions .= "    \"type\": \"short_answer\",\n";
            $instructions .= $language === 'ar' ?
                "    \"question\": \"نص السؤال هنا\",\n" :
                "    \"question\": \"Question text here\",\n";
            $instructions .= $language === 'ar' ?
                "    \"sample_answer\": \"إجابة نموذجية\",\n    \"key_points\": [\"نقطة 1\", \"نقطة 2\"]\n" :
                "    \"sample_answer\": \"Sample answer\",\n    \"key_points\": [\"Point 1\", \"Point 2\"]\n";
            $instructions .= "  }";
        }

        $instructions .= "\n]\n```";

        return $instructions;
    }

    /**
     * Call the Gemini API
     */
    protected function callGeminiAPI(string $prompt): string
    {
        if (empty($this->apiKey) || $this->apiKey === 'your-gemini-api-key') {
            throw new Exception('Gemini API key not configured');
        }

        try {
            $response = Http::timeout(30)->post($this->baseUrl . "/models/{$this->model}:generateContent", [
                'key' => $this->apiKey,
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 2048,
                ]
            ]);

            if ($response->failed()) {
                Log::error('Gemini API error: ' . $response->body());
                throw new Exception('Failed to communicate with Gemini API: ' . $response->status());
            }

            $data = $response->json();

            if (!isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                throw new Exception('Invalid response format from Gemini API');
            }

            return $data['candidates'][0]['content']['parts'][0]['text'];

        } catch (Exception $e) {
            Log::error('Gemini API exception: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Parse the Gemini response into a structured format
     */
    protected function parsePracticeResponse(string $response, string $questionType): array
    {
        try {
            // Extract JSON from the response
            preg_match('/```json\s*(.*?)\s*```/s', $response, $matches);
            $jsonStr = $matches[1] ?? $response;

            // Clean the JSON string
            $jsonStr = trim($jsonStr);
            $jsonStr = preg_replace('/^\[|\]$/', '', $jsonStr);
            $jsonStr = '[' . $jsonStr . ']';

            $questions = json_decode($jsonStr, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Failed to parse JSON response: ' . json_last_error_msg());
            }

            // Validate and format questions
            return $this->validateAndFormatQuestions($questions);

        } catch (Exception $e) {
            Log::error('Error parsing Gemini response: ' . $e->getMessage());
            Log::error('Response content: ' . $response);

            // Return fallback questions if parsing fails
            return $this->createFallbackQuestions();
        }
    }

    /**
     * Validate and format the parsed questions
     */
    protected function validateAndFormatQuestions(array $questions): array
    {
        $validQuestions = [];

        foreach ($questions as $question) {
            if (!isset($question['type']) || !isset($question['question'])) {
                continue;
            }

            $formattedQuestion = [
                'type' => $question['type'],
                'question' => $question['question'],
                'difficulty' => 'medium', // Default difficulty
                'explanation' => $question['explanation'] ?? '',
            ];

            switch ($question['type']) {
                case 'multiple_choice':
                    if (isset($question['options']) && isset($question['correct_answer'])) {
                        $formattedQuestion['options'] = $question['options'];
                        $formattedQuestion['correct_answer'] = $question['correct_answer'];
                    }
                    break;

                case 'true_false':
                    if (isset($question['correct_answer'])) {
                        $formattedQuestion['correct_answer'] = $question['correct_answer'];
                    }
                    break;

                case 'short_answer':
                    if (isset($question['sample_answer'])) {
                        $formattedQuestion['sample_answer'] = $question['sample_answer'];
                        $formattedQuestion['key_points'] = $question['key_points'] ?? [];
                    }
                    break;
            }

            $validQuestions[] = $formattedQuestion;
        }

        return $validQuestions;
    }

    /**
     * Local fallback generation when API fails
     */
    protected function localFallbackGeneration(
        string $courseContent,
        int $numQuestions,
        string $difficulty,
        string $questionType,
        string $language
    ): array {
        Log::info('Using local fallback for practice question generation');

        // Simple fallback - create basic questions from content
        $sentences = preg_split('/(?<=[.?!])\s+/', $courseContent, -1, PREG_SPLIT_NO_EMPTY);
        $questions = [];

        $questionCount = min($numQuestions, count($sentences), 5); // Limit to 5 fallback questions

        for ($i = 0; $i < $questionCount; $i++) {
            $sentence = $sentences[$i];

            if ($questionType === 'multiple_choice' || $questionType === 'mixed') {
                $questions[] = [
                    'type' => 'multiple_choice',
                    'question' => $language === 'ar' ?
                        "ما هو المفهوم الرئيسي في: " . substr($sentence, 0, 100) . "...؟" :
                        "What is the main concept in: " . substr($sentence, 0, 100) . "...?",
                    'options' => $language === 'ar' ?
                        ['الخيار الأول', 'الخيار الثاني', 'الخيار الثالث', 'الخيار الرابع'] :
                        ['Option A', 'Option B', 'Option C', 'Option D'],
                    'correct_answer' => $language === 'ar' ? 'الخيار الأول' : 'Option A',
                    'explanation' => $language === 'ar' ?
                        'هذا سؤال تم إنشاؤه تلقائياً للمراجعة.' :
                        'This is an automatically generated question for review.',
                    'difficulty' => $difficulty
                ];
            }
        }

        return $questions;
    }

    /**
     * Create fallback questions when all else fails
     */
    protected function createFallbackQuestions(): array
    {
        return [
            [
                'type' => 'multiple_choice',
                'question' => 'ما هو أهم شيء تعلمته من هذا الكورس؟',
                'options' => ['المفاهيم الأساسية', 'التطبيقات العملية', 'الأمثلة المقدمة', 'جميع ما سبق'],
                'correct_answer' => 'جميع ما سبق',
                'explanation' => 'الكورس يهدف إلى تعليم جميع هذه الجوانب.',
                'difficulty' => 'easy'
            ]
        ];
    }

    /**
     * Check if Gemini API is properly configured
     */
    public function isConfigured(): bool
    {
        return !empty($this->apiKey) && $this->apiKey !== 'your-gemini-api-key';
    }

    /**
     * Test the Gemini API connection
     */
    public function testConnection(): array
    {
        try {
            $testPrompt = "Generate a simple test question about mathematics in Arabic.";
            $response = $this->callGeminiAPI($testPrompt);

            return [
                'success' => true,
                'message' => 'Gemini API connection successful',
                'response' => substr($response, 0, 200) . '...'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Gemini API connection failed: ' . $e->getMessage()
            ];
        }
    }
}
