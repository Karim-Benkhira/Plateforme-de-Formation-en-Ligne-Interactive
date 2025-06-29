# AI Quiz Generation System - Customization Guide

## 📋 Overview

This guide explains how to customize and modify the AI quiz generation system, including prompt engineering, content analysis, and API integration.

## 🏗️ System Architecture

### Core Components

1. **GeminiAIService** (`app/Services/GeminiAIService.php`) - Main AI service for Gemini API integration
2. **AIQuizController** (`app/Http/Controllers/AIQuizController.php`) - Main controller handling quiz generation
3. **PracticeSession & PracticeQuestion Models** - Database models for storing AI-generated content

### Data Flow

```
Student Request → AIQuizController → Course Content Extraction → GeminiAIService → AI API → Response Processing → Database Storage
```

## 🎯 Prompt Customization

### 1. Main Prompt Generation Location

**File:** `app/Services/GeminiAIService.php`
**Method:** `buildPracticePrompt()`
**Lines:** ~55-150

```php
protected function buildPracticePrompt(
    string $courseContent,
    int $numQuestions,
    string $difficulty,
    string $questionType,
    string $language
): string
```

### 2. Current Prompt Structure

The current prompt includes:
- **System Role Definition**: Defines AI as educational assistant
- **Content Analysis Instructions**: How to analyze course content
- **Task Specification**: Number and type of questions to generate
- **Quality Requirements**: Specific requirements for question quality
- **Difficulty Instructions**: Level-specific guidance
- **Format Instructions**: Output format requirements

### 3. Sample Current Prompt

```text
You are an intelligent educational assistant specialized in analyzing educational content and creating customized practice questions.

First, carefully analyze the provided educational content to understand:
- The main topic and core concepts
- Important learning points and key details
- Domain-specific terminology and definitions
- Relationships between different concepts
- Practical applications and examples

Task: Based on your content analysis, generate 5 customized practice questions at Easy - Basic recall and comprehension questions level of type Multiple choice with 4 options.

Educational Content for Analysis:
[COURSE CONTENT HERE]

Specific Question Requirements:
- Questions must be directly related to the provided content
- Questions should cover different aspects of the topic (not just the first points)
- Questions should test student understanding of core concepts
- Questions should be diverse and avoid repetition
- Questions should use terminology and examples from the content
- Questions should be clear, understandable, and appropriate for the difficulty level

[DIFFICULTY-SPECIFIC INSTRUCTIONS]
[FORMAT INSTRUCTIONS]
```

## 🔧 Customization Examples

### 1. Adding New Question Types

**Location:** `app/Services/GeminiAIService.php` - `getFormatInstructions()` method

```php
// Add to the method around line 200
case 'fill_in_blank':
    if ($language === 'ar') {
        $instructions .= "نوع السؤال: املأ الفراغ\n";
        $instructions .= "قم بإنشاء جمل مع فراغات يجب ملؤها\n";
    } else {
        $instructions .= "Question Type: Fill in the blank\n";
        $instructions .= "Create sentences with blanks to be filled\n";
    }
    break;
```

### 2. Modifying Difficulty Levels

**Location:** `app/Services/GeminiAIService.php` - `getDifficultySpecificInstructions()` method

```php
// Add new difficulty level around line 180
case 'expert':
    if ($language === 'ar') {
        $instructions .= "- ركز على التحليل المتقدم والتطبيق المعقد\n";
        $instructions .= "- استخدم سيناريوهات متعددة الطبقات\n";
    } else {
        $instructions .= "- Focus on advanced analysis and complex application\n";
        $instructions .= "- Use multi-layered scenarios\n";
    }
    break;
```

### 3. Adding Domain-Specific Prompts

**Location:** `app/Services/GeminiAIService.php` - `buildPracticePrompt()` method

```php
// Add after content analysis instructions (around line 85)
$domainSpecificInstructions = $this->getDomainSpecificInstructions($courseContent, $language);
$prompt .= $domainSpecificInstructions;

// Then add the new method:
protected function getDomainSpecificInstructions(string $content, string $language): string
{
    $domain = $this->detectCourseDomain($content);
    
    $instructions = [
        'programming' => [
            'en' => "Focus on code examples, syntax, debugging, and best practices.\n",
            'ar' => "ركز على أمثلة الكود والصيغة وإصلاح الأخطاء وأفضل الممارسات.\n"
        ],
        'mathematics' => [
            'en' => "Include step-by-step problem solving and formula applications.\n",
            'ar' => "اشمل حل المشاكل خطوة بخطوة وتطبيقات الصيغ.\n"
        ]
    ];
    
    return $instructions[$domain][$language] ?? '';
}
```

## 📊 Course Content Analysis Customization

### 1. Content Extraction Location

**File:** `app/Http/Controllers/AIQuizController.php`
**Method:** `extractCourseContent()`
**Lines:** ~140-200

### 2. Adding New Content Sources

```php
// Add to extractCourseContent method around line 160
// Extract from external APIs
$externalContent = $this->extractExternalContent($course);
if (!empty($externalContent)) {
    $content[] = "External Resources:";
    $content[] = $externalContent;
}

// Add new method:
protected function extractExternalContent(Course $course): string
{
    // Custom logic to fetch content from external sources
    // e.g., Wikipedia API, educational databases, etc.
    return '';
}
```

### 3. Enhanced Content Analysis

**Location:** `app/Http/Controllers/AIQuizController.php` - `analyzeContentForQuestions()` method

```php
// Add around line 450
// Extract learning objectives
preg_match_all('/(?:objective|goal|aim):\s*(.+?)(?:\n|$)/i', $courseContent, $matches);
$analysis['learning_objectives'] = $matches[1];

// Extract prerequisites
preg_match_all('/(?:prerequisite|requirement):\s*(.+?)(?:\n|$)/i', $courseContent, $matches);
$analysis['prerequisites'] = $matches[1];
```

## 🔌 API Integration Customization

### 1. Gemini API Configuration

**Location:** `app/Services/GeminiAIService.php` - `makeRequest()` method

```php
// Modify API parameters around line 330
'generationConfig' => [
    'temperature' => 0.3,        // Lower = more focused
    'topK' => 20,               // Reduced for consistency
    'topP' => 0.8,              // Lower for deterministic responses
    'maxOutputTokens' => 3072,  // Increased for detailed questions
    'candidateCount' => 1,      // Single response
    'stopSequences' => ['END'], // Custom stop sequences
]
```

### 2. Adding Alternative AI Providers

Create new service: `app/Services/OpenAIService.php`

```php
<?php
namespace App\Services;

class OpenAIService
{
    public function generatePracticeQuestions(string $content, int $numQuestions, string $difficulty, string $questionType, string $language): array
    {
        // OpenAI implementation
        $prompt = $this->buildOpenAIPrompt($content, $numQuestions, $difficulty, $questionType, $language);
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.openai.api_key'),
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'system', 'content' => 'You are an educational assistant.'],
                ['role' => 'user', 'content' => $prompt]
            ],
            'temperature' => 0.3,
            'max_tokens' => 3000,
        ]);
        
        return $this->parseResponse($response->json());
    }
}
```

Then modify `AIQuizController.php` to use multiple providers:

```php
// In generateQuiz method around line 80
$providers = ['gemini', 'openai', 'claude'];
$questions = [];

foreach ($providers as $provider) {
    try {
        $service = app("App\\Services\\" . ucfirst($provider) . "Service");
        $questions = $service->generatePracticeQuestions(/*...*/);
        if (!empty($questions)) break;
    } catch (\Exception $e) {
        Log::warning("Provider {$provider} failed: " . $e->getMessage());
        continue;
    }
}
```

## 🎨 Fallback System Customization

### 1. Enhanced Fallback Questions

**Location:** `app/Http/Controllers/AIQuizController.php` - `generateFallbackQuestions()` method

```php
// Add around line 420
// Generate questions from course structure
$structureQuestions = $this->generateStructureBasedQuestions($contentAnalysis, $numQuestions, $difficulty, $questionType, $language);

// Generate questions from glossary terms
$glossaryQuestions = $this->generateGlossaryQuestions($contentAnalysis, $numQuestions, $difficulty, $questionType, $language);

// Combine different fallback strategies
$allFallbackQuestions = array_merge($contentSpecificQuestions, $structureQuestions, $glossaryQuestions);
```

### 2. Domain-Specific Fallback Templates

```php
protected function getDomainSpecificTemplates(string $domain, string $language): array
{
    $templates = [
        'programming' => [
            'en' => [
                'What is the purpose of {concept} in {domain}?',
                'Which of the following is a characteristic of {concept}?',
                'How would you implement {concept} in a real project?'
            ]
        ],
        'science' => [
            'en' => [
                'What happens when {process} occurs?',
                'Which factor affects {phenomenon}?',
                'Explain the relationship between {concept1} and {concept2}'
            ]
        ]
    ];
    
    return $templates[$domain][$language] ?? $templates['general'][$language];
}
```

## 📈 Performance Optimization

### 1. Caching Strategies

```php
// Add to GeminiAIService
use Illuminate\Support\Facades\Cache;

public function generatePracticeQuestions(/*...*/)
{
    $cacheKey = "quiz_" . md5($courseContent . $numQuestions . $difficulty . $questionType);
    
    return Cache::remember($cacheKey, 3600, function() use (/*...*/) {
        return $this->callGeminiAPI(/*...*/);
    });
}
```

### 2. Rate Limiting

```php
// Add to GeminiAIService
use Illuminate\Support\Facades\RateLimiter;

protected function makeRequest(/*...*/)
{
    $key = 'gemini_api_' . request()->ip();
    
    if (RateLimiter::tooManyAttempts($key, 10)) {
        throw new \Exception('Too many API requests. Please try again later.');
    }
    
    RateLimiter::hit($key, 60); // 10 requests per minute
    
    // Make API call...
}
```

## 🔍 Debugging and Monitoring

### 1. Enhanced Logging

```php
// Add to AIQuizController
Log::info('AI Quiz Generation Started', [
    'user_id' => Auth::id(),
    'course_id' => $courseId,
    'content_length' => strlen($courseContent),
    'request_params' => $request->all()
]);

Log::info('AI Quiz Generation Completed', [
    'questions_generated' => count($questions),
    'generation_method' => $usedAI ? 'ai' : 'fallback',
    'session_id' => $sessionData['session_id']
]);
```

### 2. Performance Metrics

```php
// Add timing metrics
$startTime = microtime(true);

// ... generation logic ...

$endTime = microtime(true);
$generationTime = ($endTime - $startTime) * 1000; // milliseconds

Log::info('AI Generation Performance', [
    'generation_time_ms' => $generationTime,
    'content_analysis_time' => $analysisTime,
    'api_call_time' => $apiTime
]);
```

## 🚀 Next Steps

1. **Test Your Customizations**: Always test in a development environment first
2. **Monitor Performance**: Watch API usage and response times
3. **Gather Feedback**: Collect user feedback on question quality
4. **Iterate**: Continuously improve prompts based on results

## 📞 Support

For technical support or questions about customization:
- Check the application logs in `storage/logs/laravel.log`
- Review the database for session and question data
- Test API connectivity using the provided test scripts

---

**Last Updated:** June 29, 2025
**Version:** 2.0.0
