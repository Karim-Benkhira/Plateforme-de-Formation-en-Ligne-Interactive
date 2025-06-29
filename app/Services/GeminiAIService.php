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

            // Return empty array to let the controller handle fallback
            return [];
        }
    }

    /**
     * Build the prompt for practice question generation with enhanced content analysis
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
            'easy' => $language === 'ar' ? 'سهلة - أسئلة أساسية ومباشرة' : 'Easy - Basic recall and comprehension questions',
            'medium' => $language === 'ar' ? 'متوسطة - أسئلة تتطلب فهم وتحليل' : 'Medium - Application and analysis questions',
            'hard' => $language === 'ar' ? 'صعبة - أسئلة تتطلب تفكير نقدي وتطبيق' : 'Hard - Synthesis, evaluation, and critical thinking questions'
        ];

        $typeInstructions = [
            'multiple_choice' => $language === 'ar' ? 'اختيار من متعدد مع 4 خيارات' : 'Multiple choice with 4 options',
            'true_false' => $language === 'ar' ? 'صح أو خطأ مع تفسير' : 'True/False with explanation',
            'short_answer' => $language === 'ar' ? 'إجابة قصيرة (2-3 جمل)' : 'Short answer (2-3 sentences)',
            'mixed' => $language === 'ar' ? 'مزيج من جميع الأنواع' : 'Mix of all question types'
        ];

        // Enhanced system prompt with content analysis instructions
        $prompt = $language === 'ar' ?
            "أنت مساعد تعليمي ذكي متخصص في تحليل المحتوى التعليمي وإنشاء أسئلة تدريبية مخصصة.\n\n" :
            "You are an intelligent educational assistant specialized in analyzing educational content and creating customized practice questions.\n\n";

        // Content analysis instructions
        $prompt .= $language === 'ar' ?
            "أولاً، قم بتحليل المحتوى التعليمي المقدم بعناية لفهم:\n" :
            "First, carefully analyze the provided educational content to understand:\n";

        if ($language === 'ar') {
            $prompt .= "- الموضوع الرئيسي والمفاهيم الأساسية\n";
            $prompt .= "- النقاط التعليمية المهمة والتفاصيل الرئيسية\n";
            $prompt .= "- المصطلحات والتعريفات الخاصة بالمجال\n";
            $prompt .= "- العلاقات بين المفاهيم المختلفة\n";
            $prompt .= "- التطبيقات العملية والأمثلة\n\n";
        } else {
            $prompt .= "- The main topic and core concepts\n";
            $prompt .= "- Important learning points and key details\n";
            $prompt .= "- Domain-specific terminology and definitions\n";
            $prompt .= "- Relationships between different concepts\n";
            $prompt .= "- Practical applications and examples\n\n";
        }

        // Task specification
        $prompt .= $language === 'ar' ?
            "المهمة: بناءً على تحليلك للمحتوى، قم بإنشاء {$numQuestions} سؤال تدريبي مخصص بمستوى {$difficultyDescriptions[$difficulty]} من نوع {$typeInstructions[$questionType]}.\n\n" :
            "Task: Based on your content analysis, generate {$numQuestions} customized practice questions at {$difficultyDescriptions[$difficulty]} level of type {$typeInstructions[$questionType]}.\n\n";

        // Course content
        $prompt .= $language === 'ar' ?
            "المحتوى التعليمي للتحليل:\n{$courseContent}\n\n" :
            "Educational Content for Analysis:\n{$courseContent}\n\n";

        // Enhanced requirements
        $prompt .= $language === 'ar' ?
            "متطلبات الأسئلة المحددة:\n" :
            "Specific Question Requirements:\n";

        if ($language === 'ar') {
            $prompt .= "- يجب أن تكون الأسئلة مرتبطة مباشرة بالمحتوى المقدم\n";
            $prompt .= "- يجب أن تغطي مختلف جوانب الموضوع (ليس فقط النقاط الأولى)\n";
            $prompt .= "- يجب أن تختبر فهم الطالب للمفاهيم الأساسية\n";
            $prompt .= "- يجب أن تكون متنوعة وتتجنب التكرار\n";
            $prompt .= "- يجب أن تستخدم المصطلحات والأمثلة من المحتوى\n";
            $prompt .= "- يجب أن تكون واضحة ومفهومة ومناسبة للمستوى المطلوب\n\n";
        } else {
            $prompt .= "- Questions must be directly related to the provided content\n";
            $prompt .= "- Questions should cover different aspects of the topic (not just the first points)\n";
            $prompt .= "- Questions should test student understanding of core concepts\n";
            $prompt .= "- Questions should be diverse and avoid repetition\n";
            $prompt .= "- Questions should use terminology and examples from the content\n";
            $prompt .= "- Questions should be clear, understandable, and appropriate for the difficulty level\n\n";
        }

        // Add difficulty-specific instructions
        $prompt .= $this->getDifficultySpecificInstructions($difficulty, $language);

        $prompt .= $this->getFormatInstructions($questionType, $language);

        return $prompt;
    }

    /**
     * Get difficulty-specific instructions for question generation
     */
    protected function getDifficultySpecificInstructions(string $difficulty, string $language): string
    {
        $instructions = $language === 'ar' ? "إرشادات خاصة بالمستوى:\n" : "Difficulty-Specific Instructions:\n";

        switch ($difficulty) {
            case 'easy':
                if ($language === 'ar') {
                    $instructions .= "- ركز على التذكر والفهم الأساسي\n";
                    $instructions .= "- استخدم أسئلة مباشرة حول التعريفات والحقائق\n";
                    $instructions .= "- تجنب الأسئلة المعقدة أو التي تتطلب تحليل عميق\n\n";
                } else {
                    $instructions .= "- Focus on recall and basic comprehension\n";
                    $instructions .= "- Use direct questions about definitions and facts\n";
                    $instructions .= "- Avoid complex questions requiring deep analysis\n\n";
                }
                break;

            case 'medium':
                if ($language === 'ar') {
                    $instructions .= "- ركز على التطبيق والتحليل\n";
                    $instructions .= "- اطرح أسئلة حول العلاقات بين المفاهيم\n";
                    $instructions .= "- استخدم سيناريوهات أو أمثلة للتطبيق\n\n";
                } else {
                    $instructions .= "- Focus on application and analysis\n";
                    $instructions .= "- Ask questions about relationships between concepts\n";
                    $instructions .= "- Use scenarios or examples for application\n\n";
                }
                break;

            case 'hard':
                if ($language === 'ar') {
                    $instructions .= "- ركز على التقييم والتفكير النقدي\n";
                    $instructions .= "- اطرح أسئلة تتطلب مقارنة أو تحليل معقد\n";
                    $instructions .= "- استخدم مشاكل تتطلب دمج معلومات من مصادر متعددة\n\n";
                } else {
                    $instructions .= "- Focus on evaluation and critical thinking\n";
                    $instructions .= "- Ask questions requiring comparison or complex analysis\n";
                    $instructions .= "- Use problems requiring synthesis of multiple information sources\n\n";
                }
                break;
        }

        return $instructions;
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
            $response = Http::timeout(30)->post($this->baseUrl . "/models/{$this->model}:generateContent?key=" . $this->apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.3,      // Lower temperature for more focused, consistent responses
                    'topK' => 20,              // Reduced for more focused token selection
                    'topP' => 0.8,             // Slightly lower for more deterministic responses
                    'maxOutputTokens' => 3072, // Increased for more detailed questions and explanations
                    'candidateCount' => 1,     // Single response for consistency
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

            // Return empty array to let the controller handle fallback
            return [];
        }
    }

    /**
     * Validate and format the parsed questions
     */
    protected function validateAndFormatQuestions(array $questions): array
    {
        $validQuestions = [];

        foreach ($questions as $index => $question) {
            if (!isset($question['type']) || !isset($question['question'])) {
                continue;
            }

            $formattedQuestion = [
                'id' => $index + 1,
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
                // Generate better options based on content
                $options = $language === 'ar' ? [
                    'الأسس النظرية والمفاهيم الأساسية',
                    'التطبيقات العملية والأمثلة',
                    'الطرق والتقنيات المتقدمة',
                    'الفهم الشامل لجميع المفاهيم'
                ] : [
                    'Theoretical foundations and basic concepts',
                    'Practical applications and examples',
                    'Advanced methods and techniques',
                    'Comprehensive understanding of all concepts'
                ];

                $questions[] = [
                    'id' => $i + 1,
                    'type' => 'multiple_choice',
                    'question' => $language === 'ar' ?
                        "ما هو المفهوم الرئيسي في: " . substr($sentence, 0, 100) . "...؟" :
                        "What is the main concept in: " . substr($sentence, 0, 100) . "...?",
                    'options' => $options,
                    'correct_answer' => $options[3], // Last option is usually correct
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
                'id' => 1,
                'type' => 'multiple_choice',
                'question' => 'What is the most important thing you learned from this course?',
                'options' => ['Basic concepts', 'Practical applications', 'Examples provided', 'All of the above'],
                'correct_answer' => 'All of the above',
                'explanation' => 'The course aims to teach all these aspects.',
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
