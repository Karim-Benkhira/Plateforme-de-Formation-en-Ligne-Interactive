# AI Quiz Generation - Prompt Examples & Customization

## 📝 Current Prompt Structure

### Sample Generated Prompt (English, Easy, Multiple Choice)

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
Course Title: HTML & CSS Fundamentals

Course Description: Learn the basics of HTML and CSS for creating beautiful web pages. This course covers semantic HTML, CSS styling, responsive design, and modern web development practices.

Course Level: beginner

Course Category: Web Development

Course Materials:

Text Content: HTML (HyperText Markup Language) is the standard markup language for creating web pages. It uses elements and tags to structure content. Key concepts include: semantic elements like header, nav, main, section, article, and footer; form elements for user input; and proper document structure with DOCTYPE, html, head, and body tags.

Text Content: CSS (Cascading Style Sheets) controls the presentation and layout of HTML elements. Important concepts include: selectors (element, class, ID); the box model (margin, border, padding, content); positioning (static, relative, absolute, fixed); flexbox and grid for layout; and responsive design with media queries.

Specific Question Requirements:
- Questions must be directly related to the provided content
- Questions should cover different aspects of the topic (not just the first points)
- Questions should test student understanding of core concepts
- Questions should be diverse and avoid repetition
- Questions should use terminology and examples from the content
- Questions should be clear, understandable, and appropriate for the difficulty level

Difficulty-Specific Instructions:
- Focus on recall and basic comprehension
- Use direct questions about definitions and facts
- Avoid complex questions requiring deep analysis

Please return the questions in the following JSON format:
[
  {
    "id": "unique_id",
    "type": "multiple_choice",
    "question": "Question text here",
    "options": ["Option A", "Option B", "Option C", "Option D"],
    "correct_answer": 0,
    "explanation": "Explanation of why this is correct"
  }
]

Ensure all questions are in English and follow the specified difficulty level and question type.
```

## 🎯 Customization Examples

### 1. Programming-Focused Prompt Enhancement

**File to modify:** `app/Services/GeminiAIService.php`
**Method:** `buildPracticePrompt()`

```php
// Add after content analysis instructions (around line 85)
if ($this->detectProgrammingContent($courseContent)) {
    $prompt .= $this->getProgrammingSpecificInstructions($language);
}

// Add new method:
protected function getProgrammingSpecificInstructions(string $language): string
{
    return $language === 'ar' ? 
        "\nتعليمات خاصة بالبرمجة:\n- اشمل أمثلة كود قصيرة عند الإمكان\n- ركز على الصيغة والمفاهيم الأساسية\n- اطرح أسئلة حول أفضل الممارسات\n\n" :
        "\nProgramming-Specific Instructions:\n- Include short code examples when possible\n- Focus on syntax and fundamental concepts\n- Ask questions about best practices\n\n";
}
```

### 2. Multi-Language Support Enhancement

```php
// Enhanced language-specific prompts
protected function getLanguageSpecificPrompt(string $language, string $content): string
{
    $prompts = [
        'ar' => "أنت مساعد تعليمي ذكي متخصص في تحليل المحتوى التعليمي باللغة العربية وإنشاء أسئلة تدريبية مخصصة تراعي الثقافة العربية والمصطلحات التقنية المناسبة.",
        'fr' => "Vous êtes un assistant éducatif intelligent spécialisé dans l'analyse de contenu éducatif en français et la création de questions d'entraînement personnalisées.",
        'es' => "Eres un asistente educativo inteligente especializado en analizar contenido educativo en español y crear preguntas de práctica personalizadas.",
        'en' => "You are an intelligent educational assistant specialized in analyzing educational content and creating customized practice questions."
    ];
    
    return $prompts[$language] ?? $prompts['en'];
}
```

### 3. Adaptive Difficulty Prompts

```php
// Enhanced difficulty-specific instructions
protected function getAdvancedDifficultyInstructions(string $difficulty, string $domain, string $language): string
{
    $instructions = [];
    
    switch ($difficulty) {
        case 'adaptive':
            $instructions[$language] = $language === 'ar' ? 
                "- قم بتدرج الصعوبة من السهل إلى الصعب\n- ابدأ بأسئلة أساسية وانتقل للتطبيق\n- اشمل أسئلة تقييم الفهم في المنتصف\n" :
                "- Gradually increase difficulty from easy to hard\n- Start with basic questions and move to application\n- Include comprehension assessment questions in the middle\n";
            break;
            
        case 'scenario_based':
            $instructions[$language] = $language === 'ar' ? 
                "- استخدم سيناريوهات واقعية من مجال {$domain}\n- اطرح أسئلة حول حل المشاكل العملية\n- اشمل دراسات حالة قصيرة\n" :
                "- Use realistic scenarios from {$domain} field\n- Ask questions about practical problem solving\n- Include short case studies\n";
            break;
    }
    
    return $instructions[$language] ?? '';
}
```

### 4. Content-Type Specific Prompts

```php
// Add content-type detection and specific instructions
protected function getContentTypeInstructions(string $courseContent, string $language): string
{
    $contentTypes = $this->detectContentTypes($courseContent);
    $instructions = "";
    
    if (in_array('video', $contentTypes)) {
        $instructions .= $language === 'ar' ? 
            "- اشمل أسئلة حول المحتوى المرئي والمفاهيم المشروحة\n" :
            "- Include questions about visual content and explained concepts\n";
    }
    
    if (in_array('code', $contentTypes)) {
        $instructions .= $language === 'ar' ? 
            "- ركز على فهم الكود وتطبيقه\n- اطرح أسئلة حول الأخطاء الشائعة\n" :
            "- Focus on code understanding and application\n- Ask questions about common errors\n";
    }
    
    if (in_array('mathematical', $contentTypes)) {
        $instructions .= $language === 'ar' ? 
            "- اشمل أسئلة حسابية وتطبيق الصيغ\n- ركز على خطوات الحل\n" :
            "- Include computational questions and formula application\n- Focus on solution steps\n";
    }
    
    return $instructions;
}

protected function detectContentTypes(string $content): array
{
    $types = [];
    
    if (preg_match('/```|<code>|function|class|def |import /', $content)) {
        $types[] = 'code';
    }
    
    if (preg_match('/\$.*\$|\\\[.*\\\]|equation|formula/', $content)) {
        $types[] = 'mathematical';
    }
    
    if (preg_match('/video|watch|youtube|mp4/', $content)) {
        $types[] = 'video';
    }
    
    return $types;
}
```

## 🔧 Advanced Customization Examples

### 1. Industry-Specific Question Templates

```php
// Add to GeminiAIService
protected function getIndustrySpecificTemplates(string $industry, string $language): array
{
    $templates = [
        'healthcare' => [
            'en' => [
                'In a clinical setting, how would you apply {concept}?',
                'What are the safety considerations when using {technique}?',
                'Which protocol should be followed for {procedure}?'
            ],
            'ar' => [
                'في البيئة السريرية، كيف تطبق {concept}؟',
                'ما هي اعتبارات السلامة عند استخدام {technique}؟',
                'أي بروتوكول يجب اتباعه لـ {procedure}؟'
            ]
        ],
        'business' => [
            'en' => [
                'How would {concept} impact business operations?',
                'What ROI considerations apply to {strategy}?',
                'Which stakeholders are affected by {decision}?'
            ]
        ],
        'technology' => [
            'en' => [
                'What are the scalability implications of {technology}?',
                'How does {concept} integrate with existing systems?',
                'What security measures are needed for {implementation}?'
            ]
        ]
    ];
    
    return $templates[$industry][$language] ?? [];
}
```

### 2. Bloom's Taxonomy Integration

```php
// Enhanced difficulty mapping to Bloom's taxonomy
protected function getBloomsTaxonomyInstructions(string $level, string $language): string
{
    $instructions = [
        'remember' => [
            'en' => 'Focus on recall of facts, terms, and basic concepts',
            'ar' => 'ركز على تذكر الحقائق والمصطلحات والمفاهيم الأساسية'
        ],
        'understand' => [
            'en' => 'Test comprehension and explanation of ideas',
            'ar' => 'اختبر الفهم وشرح الأفكار'
        ],
        'apply' => [
            'en' => 'Create questions requiring use of knowledge in new situations',
            'ar' => 'أنشئ أسئلة تتطلب استخدام المعرفة في مواقف جديدة'
        ],
        'analyze' => [
            'en' => 'Focus on breaking down information and finding patterns',
            'ar' => 'ركز على تحليل المعلومات وإيجاد الأنماط'
        ],
        'evaluate' => [
            'en' => 'Create questions requiring judgment and decision making',
            'ar' => 'أنشئ أسئلة تتطلب الحكم واتخاذ القرارات'
        ],
        'create' => [
            'en' => 'Focus on synthesis and creation of new ideas',
            'ar' => 'ركز على التركيب وإنشاء أفكار جديدة'
        ]
    ];
    
    return $instructions[$level][$language] ?? '';
}
```

### 3. Personalized Learning Paths

```php
// Add student performance-based prompt modification
protected function getPersonalizedInstructions(User $student, Course $course, string $language): string
{
    $performance = $this->getStudentPerformance($student, $course);
    $weakAreas = $performance['weak_areas'] ?? [];
    $strongAreas = $performance['strong_areas'] ?? [];
    
    $instructions = "";
    
    if (!empty($weakAreas)) {
        $instructions .= $language === 'ar' ? 
            "ركز بشكل خاص على المواضيع التالية التي يحتاج الطالب لتحسينها: " . implode('، ', $weakAreas) . "\n" :
            "Focus particularly on the following topics where the student needs improvement: " . implode(', ', $weakAreas) . "\n";
    }
    
    if (!empty($strongAreas)) {
        $instructions .= $language === 'ar' ? 
            "يمكن تقليل التركيز على المواضيع التي يتقنها الطالب: " . implode('، ', $strongAreas) . "\n" :
            "Reduce focus on topics the student has mastered: " . implode(', ', $strongAreas) . "\n";
    }
    
    return $instructions;
}
```

## 🎨 Response Format Customization

### 1. Enhanced JSON Schema

```php
// Modify getFormatInstructions method
protected function getEnhancedFormatInstructions(string $questionType, string $language): string
{
    $schema = [
        'multiple_choice' => [
            'en' => 'Return questions in this enhanced JSON format:
[
  {
    "id": "unique_id",
    "type": "multiple_choice",
    "question": "Question text",
    "options": ["A", "B", "C", "D"],
    "correct_answer": 0,
    "explanation": "Why this is correct",
    "difficulty_level": "easy|medium|hard",
    "bloom_level": "remember|understand|apply|analyze|evaluate|create",
    "estimated_time": 60,
    "tags": ["tag1", "tag2"],
    "hint": "Optional hint for students"
  }
]'
        ]
    ];
    
    return $schema[$questionType][$language] ?? '';
}
```

### 2. Validation and Quality Checks

```php
// Add response validation
protected function validateGeneratedQuestions(array $questions): array
{
    $validatedQuestions = [];
    
    foreach ($questions as $question) {
        if ($this->isValidQuestion($question)) {
            $validatedQuestions[] = $this->enhanceQuestion($question);
        }
    }
    
    return $validatedQuestions;
}

protected function isValidQuestion(array $question): bool
{
    // Check required fields
    $required = ['question', 'type', 'correct_answer'];
    foreach ($required as $field) {
        if (empty($question[$field])) {
            return false;
        }
    }
    
    // Validate question length
    if (strlen($question['question']) < 10 || strlen($question['question']) > 500) {
        return false;
    }
    
    // Validate options for multiple choice
    if ($question['type'] === 'multiple_choice') {
        if (!isset($question['options']) || count($question['options']) < 2) {
            return false;
        }
    }
    
    return true;
}
```

## 📊 Usage Examples

### Quick Customization Checklist

1. **Modify Prompt Style**: Edit `buildPracticePrompt()` in `GeminiAIService.php`
2. **Add New Question Types**: Update `getFormatInstructions()` method
3. **Change Difficulty Levels**: Modify `getDifficultySpecificInstructions()`
4. **Enhance Content Analysis**: Update `extractCourseContent()` in `AIQuizController.php`
5. **Add Fallback Logic**: Enhance `generateFallbackQuestions()` method

### Testing Your Customizations

```bash
# Test in Docker environment
docker-compose exec app php artisan tinker

# Test prompt generation
$service = app(App\Services\GeminiAIService::class);
$prompt = $service->buildPracticePrompt("Test content", 3, "medium", "multiple_choice", "en");
echo $prompt;

# Test full generation
$controller = app(App\Http\Controllers\AIQuizController::class);
// Test with your customizations
```

---

**Remember**: Always test customizations in a development environment before deploying to production!
