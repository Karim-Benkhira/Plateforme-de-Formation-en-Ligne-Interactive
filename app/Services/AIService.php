<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class AIService
{
    protected $apiKey;
    protected $apiUrl;
    protected $model;

    public function __construct()
    {
        $this->apiKey = config('services.huggingface.api_key');
        $this->apiUrl = config('services.huggingface.api_url');
        $this->model = config('services.huggingface.model');
    }

    /**
     * Generate quiz questions based on course content
     *
     * @param string $courseContent The course content to generate questions from
     * @param int $numQuestions Number of questions to generate
     * @param string $difficulty Difficulty level (easy, medium, hard)
     * @param string $questionType Type of questions (multiple_choice, true_false, short_answer)
     * @return array Generated questions
     */
    public function generateQuizQuestions(string $courseContent, int $numQuestions = 5, string $difficulty = 'medium', string $questionType = 'multiple_choice'): array
    {
        try {
            // For long content, we'll summarize it first
            if (strlen($courseContent) > 2000) {
                $courseContent = $this->summarizeContent($courseContent);
            }

            $prompt = $this->buildQuizPrompt($courseContent, $numQuestions, $difficulty, $questionType);
            $response = $this->callAIModel($prompt);

            return $this->parseQuizResponse($response, $questionType);
        } catch (Exception $e) {
            Log::error('Error generating quiz questions: ' . $e->getMessage());
            throw new Exception('Failed to generate quiz questions. Please try again later.');
        }
    }

    /**
     * Summarize long content to fit within token limits
     */
    protected function summarizeContent(string $content): string
    {
        $prompt = "Summarize the following educational content while preserving the key concepts and important details: \n\n" . $content;

        try {
            return $this->callAIModel($prompt);
        } catch (Exception $e) {
            Log::warning('Failed to summarize content: ' . $e->getMessage());
            // If summarization fails, truncate the content
            return substr($content, 0, 1500) . "...";
        }
    }

    /**
     * Build the prompt for quiz generation
     */
    protected function buildQuizPrompt(string $courseContent, int $numQuestions, string $difficulty, string $questionType): string
    {
        $prompt = "Generate {$numQuestions} {$difficulty} {$questionType} questions based on the following course content. ";

        if ($questionType === 'multiple_choice') {
            $prompt .= "For each question, provide 4 options with one correct answer. ";
            $prompt .= "Format the response as a JSON array with each question having: question_text, options (array of 4 options), and correct_answer (the correct option). ";
        } elseif ($questionType === 'true_false') {
            $prompt .= "Format the response as a JSON array with each question having: question_text and correct_answer (true or false). ";
        } elseif ($questionType === 'short_answer') {
            $prompt .= "Format the response as a JSON array with each question having: question_text and sample_answer. ";
        }

        $prompt .= "Here's the course content: \n\n{$courseContent}";

        return $prompt;
    }

    /**
     * Call the AI model API
     */
    protected function callAIModel(string $prompt): string
    {
        // If no valid API key is set or it's the default placeholder, use a local fallback method
        if (empty($this->apiKey) || $this->apiKey === 'hf_your-api-key') {
            return $this->localFallbackGeneration($prompt);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(10)->post($this->apiUrl . $this->model, [
                'inputs' => $prompt,
                'parameters' => [
                    'max_length' => 1024,
                    'temperature' => 0.7,
                ]
            ]);

            if ($response->failed()) {
                Log::error('AI API error: ' . $response->body());
                // If API call fails, fall back to local generation
                return $this->localFallbackGeneration($prompt);
            }

            return $response->body();
        } catch (Exception $e) {
            Log::error('AI API exception: ' . $e->getMessage());
            // If any exception occurs, fall back to local generation
            return $this->localFallbackGeneration($prompt);
        }
    }

    /**
     * Local fallback method for generating quiz questions when no API is available
     * This uses predefined templates and simple logic to create basic questions
     */
    protected function localFallbackGeneration(string $prompt): string
    {
        Log::info('Using local fallback for AI generation');

        // Check if this is a quiz generation request
        if (strpos($prompt, 'Generate') !== false && strpos($prompt, 'questions') !== false) {
            // Extract the course content
            $contentStart = strpos($prompt, "Here's the course content:") + 26;
            $courseContent = trim(substr($prompt, $contentStart));

            // Determine question type
            $isMultipleChoice = strpos($prompt, 'multiple_choice') !== false;
            $isTrueFalse = strpos($prompt, 'true_false') !== false;

            // Generate simple questions based on content
            $sentences = preg_split('/(?<=[.?!])\s+/', $courseContent, -1, PREG_SPLIT_NO_EMPTY);
            $questions = [];

            // Get number of questions requested
            preg_match('/Generate\s+(\d+)/', $prompt, $matches);
            $numQuestions = isset($matches[1]) ? (int)$matches[1] : 3;
            $numQuestions = min($numQuestions, count($sentences), 5); // Cap at 5 or available sentences

            $selectedSentences = array_slice($sentences, 0, $numQuestions * 2);

            for ($i = 0; $i < $numQuestions; $i++) {
                if (isset($selectedSentences[$i])) {
                    $sentence = $selectedSentences[$i];

                    if ($isMultipleChoice) {
                        $questions[] = $this->createMultipleChoiceQuestion($sentence, $i);
                    } elseif ($isTrueFalse) {
                        $questions[] = $this->createTrueFalseQuestion($sentence, $i);
                    } else {
                        $questions[] = $this->createShortAnswerQuestion($sentence, $i);
                    }
                }
            }

            return json_encode($questions, JSON_PRETTY_PRINT);
        }

        // For summarization or other requests, return a simplified version
        return substr($prompt, 0, 500) . "...";
    }

    /**
     * Create a simple multiple choice question from a sentence
     */
    protected function createMultipleChoiceQuestion(string $sentence, int $index): array
    {
        // Different question types based on index to create variety
        $questionType = $index % 4;

        switch ($questionType) {
            case 0:
                // Fill in the blank question
                return $this->createFillInBlankQuestion($sentence);
            case 1:
                // "What is the main idea" question
                return $this->createMainIdeaQuestion($sentence);
            case 2:
                // Definition question
                return $this->createDefinitionQuestion($sentence);
            case 3:
                // Application question
                return $this->createApplicationQuestion($sentence);
            default:
                // Default to fill in blank
                return $this->createFillInBlankQuestion($sentence);
        }
    }

    /**
     * Create a fill-in-the-blank question
     */
    protected function createFillInBlankQuestion(string $sentence): array
    {
        // Extract a keyword from the sentence
        $words = explode(' ', $sentence);

        // Try to find a substantive word (longer than 3 chars)
        $keyword = "concept";
        $keywordIndex = 0;

        for ($i = 0; $i < count($words); $i++) {
            $word = preg_replace('/[^a-zA-Z0-9]/', '', $words[$i]);
            if (strlen($word) > 3 && !in_array(strtolower($word), ['this', 'that', 'then', 'than', 'with', 'from', 'have', 'what', 'when', 'where', 'which', 'there', 'their', 'they'])) {
                $keyword = $word;
                $keywordIndex = $i;
                break;
            }
        }

        // Create the question
        $questionText = str_replace($keyword, "______", $sentence);
        $questionText = "What word fills in the blank? " . $questionText;

        // Create plausible options
        $options = [$keyword];

        // Add similar words or variations
        if (substr($keyword, -1) === 's') {
            $options[] = substr($keyword, 0, -1); // Remove 's'
        } else {
            $options[] = $keyword . "s"; // Add 's'
        }

        // Add opposite or alternative
        $opposites = [
            'increase' => 'decrease',
            'high' => 'low',
            'large' => 'small',
            'big' => 'small',
            'fast' => 'slow',
            'good' => 'bad',
            'positive' => 'negative',
            'true' => 'false',
            'right' => 'wrong',
            'correct' => 'incorrect',
            'important' => 'unimportant',
            'necessary' => 'unnecessary',
            'simple' => 'complex',
            'easy' => 'difficult',
            'clear' => 'unclear',
            'active' => 'passive',
            'direct' => 'indirect',
            'formal' => 'informal',
            'internal' => 'external',
            'major' => 'minor',
            'specific' => 'general',
            'primary' => 'secondary',
            'public' => 'private',
            'open' => 'closed',
            'strong' => 'weak',
            'success' => 'failure',
            'advantage' => 'disadvantage',
            'benefit' => 'drawback',
            'cause' => 'effect',
            'problem' => 'solution'
        ];

        $lowercaseKeyword = strtolower($keyword);
        if (isset($opposites[$lowercaseKeyword])) {
            $options[] = $opposites[$lowercaseKeyword];
        } else {
            // If no opposite found, add a prefix
            $options[] = 'non-' . $keyword;
        }

        // Add one more option
        if (count($words) > $keywordIndex + 1) {
            $nextWord = preg_replace('/[^a-zA-Z0-9]/', '', $words[$keywordIndex + 1]);
            if (!empty($nextWord) && strlen($nextWord) > 3) {
                $options[] = $nextWord;
            } else {
                $options[] = 'other';
            }
        } else {
            $options[] = 'none';
        }

        // Shuffle options but keep track of correct answer
        $correctAnswer = $options[0];
        shuffle($options);

        return [
            'question_text' => $questionText,
            'options' => $options,
            'correct_answer' => $correctAnswer
        ];
    }

    /**
     * Create a main idea question
     */
    protected function createMainIdeaQuestion(string $sentence): array
    {
        $questionText = "What is the main idea of the following statement? \"" . $sentence . "\"";

        // Extract key phrases for options
        $words = explode(' ', $sentence);
        $phrases = [];

        // Create phrases from consecutive words
        if (count($words) >= 6) {
            $phrases[] = implode(' ', array_slice($words, 0, min(count($words), 3)));
            $phrases[] = implode(' ', array_slice($words, min(count($words) - 3, 3), 3));
            $phrases[] = implode(' ', array_slice($words, min(count($words) / 2, 2), 3));
        } else {
            // For short sentences, use the whole sentence as correct answer
            $phrases[] = $sentence;
            $phrases[] = "None of the above";
            $phrases[] = "All of the above";
        }

        // Add one more generic option
        $genericOptions = [
            "The importance of education",
            "The relationship between theory and practice",
            "The development of new concepts",
            "The application of principles"
        ];

        $phrases[] = $genericOptions[array_rand($genericOptions)];

        // The first option is the correct one
        $correctAnswer = $phrases[0];

        // Shuffle options
        shuffle($phrases);

        return [
            'question_text' => $questionText,
            'options' => $phrases,
            'correct_answer' => $correctAnswer
        ];
    }

    /**
     * Create a definition question
     */
    protected function createDefinitionQuestion(string $sentence): array
    {
        // Extract a potential term to define
        $words = explode(' ', $sentence);
        $term = "";

        // Look for capitalized words or words followed by specific patterns
        foreach ($words as $i => $word) {
            $word = trim($word);
            if (empty($word)) continue;

            // Check if word is capitalized (potential proper noun)
            if (ctype_upper($word[0]) && strlen($word) > 1 && !in_array(strtolower($word), ['i', 'a', 'an', 'the', 'in', 'on', 'at', 'by', 'for', 'with', 'about'])) {
                $term = $word;
                break;
            }

            // Check for patterns like "X is" or "X refers to"
            if ($i < count($words) - 2) {
                $nextWord = strtolower($words[$i + 1]);
                if ($nextWord === 'is' || $nextWord === 'refers' || $nextWord === 'means' || $nextWord === 'represents') {
                    $term = $word;
                    break;
                }
            }
        }

        // If no good term found, use a substantive word
        if (empty($term)) {
            foreach ($words as $word) {
                $word = preg_replace('/[^a-zA-Z0-9]/', '', $word);
                if (strlen($word) > 4 && !in_array(strtolower($word), ['this', 'that', 'then', 'than', 'with', 'from', 'have', 'what', 'when', 'where', 'which', 'there', 'their', 'they'])) {
                    $term = $word;
                    break;
                }
            }
        }

        // If still no term, use a default
        if (empty($term)) {
            $term = "This concept";
        }

        $questionText = "What is the best definition of \"" . $term . "\"?";

        // Create options
        $options = [];

        // Correct answer is based on the sentence
        $options[] = $sentence;

        // Create alternative definitions
        $alternatives = [
            "A theoretical framework used in advanced studies",
            "A practical application of fundamental principles",
            "A method for solving complex problems in this field",
            "A historical development in the evolution of this subject",
            "A specialized term with multiple interpretations",
            "A concept that relates to the organization of information",
            "A process that involves systematic analysis"
        ];

        // Add three random alternatives
        shuffle($alternatives);
        for ($i = 0; $i < 3; $i++) {
            if (isset($alternatives[$i])) {
                $options[] = $alternatives[$i];
            }
        }

        // The first option is the correct one
        $correctAnswer = $options[0];

        // Shuffle options
        shuffle($options);

        return [
            'question_text' => $questionText,
            'options' => $options,
            'correct_answer' => $correctAnswer
        ];
    }

    /**
     * Create an application question
     */
    protected function createApplicationQuestion(string $sentence): array
    {
        $questionText = "Which of the following best applies the concept described in this statement? \"" . $sentence . "\"";

        // Create application scenarios
        $applications = [
            "Using this principle to solve a real-world problem",
            "Applying this concept in an educational setting",
            "Implementing this idea in a business context",
            "Utilizing this approach in scientific research",
            "Demonstrating this concept through a practical example",
            "Extending this principle to a new domain",
            "Combining this concept with other related ideas",
            "Analyzing a case study through this theoretical lens",
            "Evaluating the effectiveness of this approach in practice",
            "Developing new methods based on this fundamental concept"
        ];

        // Shuffle and select 4 applications
        shuffle($applications);
        $options = array_slice($applications, 0, 4);

        // The first option is the correct one
        $correctAnswer = $options[0];

        return [
            'question_text' => $questionText,
            'options' => $options,
            'correct_answer' => $correctAnswer
        ];
    }

    /**
     * Create a simple true/false question from a sentence
     */
    protected function createTrueFalseQuestion(string $sentence, int $index): array
    {
        // Determine if we'll make a true or false question
        $isTrue = $index % 2 == 0;

        if ($isTrue) {
            return [
                'question_text' => "True or False: " . $sentence,
                'correct_answer' => "true"
            ];
        } else {
            // Negate the sentence to make it false
            $negations = [
                "is" => "is not",
                "are" => "are not",
                "was" => "was not",
                "were" => "were not",
                "will" => "will not",
                "can" => "cannot",
                "has" => "has not",
                "have" => "have not"
            ];

            $modifiedSentence = $sentence;
            foreach ($negations as $word => $negation) {
                if (strpos($modifiedSentence, " $word ") !== false) {
                    $modifiedSentence = str_replace(" $word ", " $negation ", $modifiedSentence);
                    break;
                }
            }

            return [
                'question_text' => "True or False: " . $modifiedSentence,
                'correct_answer' => "false"
            ];
        }
    }

    /**
     * Create a simple short answer question from a sentence
     */
    protected function createShortAnswerQuestion(string $sentence, int $index): array
    {
        // Extract the main subject or concept
        $words = explode(' ', $sentence);
        $conceptStart = min(count($words) - 1, 1 + $index % 2);
        $conceptEnd = min(count($words) - 1, $conceptStart + 2);

        $concept = implode(' ', array_slice($words, $conceptStart, $conceptEnd - $conceptStart + 1));

        return [
            'question_text' => "Explain the concept of " . $concept . " in your own words.",
            'sample_answer' => "Based on the text, " . $sentence
        ];
    }

    /**
     * Parse the AI response into a structured quiz format
     */
    protected function parseQuizResponse(string $response, string $questionType): array
    {
        try {
            // Try to parse as JSON directly
            $questions = json_decode($response, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                // If JSON parsing fails, try to extract JSON from the response
                preg_match('/\[.*\]/s', $response, $matches);
                $jsonStr = $matches[0] ?? $response;

                $questions = json_decode($jsonStr, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    // If still fails, try to clean the response
                    $cleanedResponse = preg_replace('/```json\s*(.*?)\s*```/s', '$1', $response);
                    $questions = json_decode($cleanedResponse, true);

                    if (json_last_error() !== JSON_ERROR_NONE) {
                        // If all parsing attempts fail, use fallback
                        return $this->fallbackParseQuestions($response, $questionType);
                    }
                }
            }

            return $questions;
        } catch (Exception $e) {
            Log::error('Error parsing quiz response: ' . $e->getMessage() . ' Response: ' . $response);
            return $this->fallbackParseQuestions($response, $questionType);
        }
    }

    /**
     * Fallback method to parse questions when JSON parsing fails
     */
    protected function fallbackParseQuestions(string $response, string $questionType): array
    {
        Log::warning('Using fallback parsing for quiz questions');

        $questions = [];

        // Split by numbered questions (1., 2., etc.)
        $pattern = '/(\d+\.\s*.*?)(?=\d+\.\s*|$)/s';
        preg_match_all($pattern, $response, $matches);

        if (!empty($matches[0])) {
            foreach ($matches[0] as $index => $questionText) {
                if ($questionType === 'multiple_choice') {
                    $questions[] = $this->parseMultipleChoiceQuestion($questionText, $index);
                } elseif ($questionType === 'true_false') {
                    $questions[] = $this->parseTrueFalseQuestion($questionText, $index);
                } else {
                    $questions[] = $this->parseShortAnswerQuestion($questionText, $index);
                }
            }
        } else {
            // If no questions found, create a default question
            $questions[] = [
                'question_text' => 'What is the main topic of this content?',
                'options' => ['Education', 'Technology', 'Science', 'History'],
                'correct_answer' => 'Education'
            ];
        }

        return $questions;
    }

    /**
     * Parse a multiple choice question from text
     */
    protected function parseMultipleChoiceQuestion(string $text, int $index): array
    {
        $lines = explode("\n", $text);
        $questionText = trim($lines[0]);
        $questionText = preg_replace('/^\d+\.\s*/', '', $questionText);

        $options = [];
        $correctAnswer = '';

        // Look for options (a), b), c), d) or A. B. C. D.)
        foreach ($lines as $line) {
            if (preg_match('/^[a-dA-D][\.|\)]?\s+(.*)$/', trim($line), $matches)) {
                $options[] = $matches[1];

                // If this option has "correct" or "*" in it, mark it as correct
                if (strpos(strtolower($line), 'correct') !== false || strpos($line, '*') !== false) {
                    $correctAnswer = $matches[1];
                }
            }
        }

        // If no correct answer was marked, use the first option
        if (empty($correctAnswer) && !empty($options)) {
            $correctAnswer = $options[0];
        }

        // If no options found, create some
        if (empty($options)) {
            $options = ['Option A', 'Option B', 'Option C', 'Option D'];
            $correctAnswer = $options[0];
        }

        return [
            'question_text' => $questionText,
            'options' => $options,
            'correct_answer' => $correctAnswer
        ];
    }

    /**
     * Parse a true/false question from text
     */
    protected function parseTrueFalseQuestion(string $text, int $index): array
    {
        $questionText = trim(preg_replace('/^\d+\.\s*/', '', $text));

        // Look for "true" or "false" in the text
        $correctAnswer = 'true';
        if (preg_match('/correct answer:?\s*(true|false)/i', $text, $matches)) {
            $correctAnswer = strtolower($matches[1]);
        } elseif (strpos(strtolower($text), 'false') !== false && strpos(strtolower($text), 'true') === false) {
            $correctAnswer = 'false';
        }

        return [
            'question_text' => $questionText,
            'correct_answer' => $correctAnswer
        ];
    }

    /**
     * Parse a short answer question from text
     */
    protected function parseShortAnswerQuestion(string $text, int $index): array
    {
        $lines = explode("\n", $text);
        $questionText = trim(preg_replace('/^\d+\.\s*/', '', $lines[0]));

        $sampleAnswer = '';
        foreach ($lines as $i => $line) {
            if ($i > 0 && !empty(trim($line))) {
                $sampleAnswer = trim($line);
                break;
            }
        }

        if (empty($sampleAnswer)) {
            $sampleAnswer = "Sample answer for: " . $questionText;
        }

        return [
            'question_text' => $questionText,
            'sample_answer' => $sampleAnswer
        ];
    }
}
