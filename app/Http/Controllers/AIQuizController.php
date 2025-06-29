<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\PracticeSession;
use App\Models\PracticeQuestion;
use App\Services\GeminiAIService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AIQuizController extends Controller
{
    protected $geminiService;

    public function __construct(GeminiAIService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    /**
     * Show AI Practice dashboard with all available courses
     */
    public function showAIPractice()
    {
        return view('student.ai-practice');
    }

    /**
     * Show AI Quiz page for a specific course
     */
    public function showAIQuiz($courseId)
    {
        $course = Course::findOrFail($courseId);

        // Check if user is enrolled and approved for this course
        $user = Auth::user();
        $enrollment = $user->enrolledCourses()->where('course_id', $courseId)->first();

        if (!$enrollment || $enrollment->pivot->status !== 'approved') {
            return redirect()->route('student.ai.practice')
                ->with('error', 'You must be enrolled and approved for this course to access AI practice questions.');
        }

        return view('student.ai-quiz', compact('course'));
    }

    /**
     * Generate AI quiz questions via AJAX
     */
    public function generateQuiz(Request $request, $courseId)
    {
        $request->validate([
            'num_questions' => 'required|integer|min:5|max:20',
            'difficulty' => 'required|in:easy,medium,hard',
            'question_type' => 'required|in:multiple_choice,true_false,mixed',
            'language' => 'required|in:ar,en,fr'
        ]);

        try {
            $course = Course::findOrFail($courseId);
            
            // Extract course content
            $courseContent = $this->extractCourseContent($course);
            
            if (empty($courseContent)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No content available to generate quiz'
                ]);
            }

            // Try to generate questions using Gemini AI first
            $questions = [];

            try {
                $questions = $this->geminiService->generatePracticeQuestions(
                    $courseContent,
                    $request->num_questions,
                    $request->difficulty,
                    $request->question_type,
                    $request->language
                );
            } catch (\Exception $e) {
                Log::error('Gemini service failed: ' . $e->getMessage());
                $questions = [];
            }

            if (empty($questions)) {
                Log::info('Gemini returned empty questions, using controller fallback');
                // Use our enhanced fallback system
                $questions = $this->generateFallbackQuestions(
                    $courseContent,
                    $request->num_questions,
                    $request->difficulty,
                    $request->question_type,
                    $request->language
                );
            }

            Log::info('Final questions to return: ' . json_encode($questions));

            // Create practice session and save questions to database
            $sessionData = $this->savePracticeSession($course, $request, $questions, $courseContent, !empty($questions));

            return response()->json([
                'success' => true,
                'questions' => $questions,
                'session_id' => $sessionData['session_id']
            ]);

        } catch (\Exception $e) {
            Log::error('Error generating AI quiz: ' . $e->getMessage());

            // Return fallback questions
            $fallbackQuestions = $this->generateFallbackQuestions(
                'General course content',
                $request->num_questions,
                $request->difficulty,
                $request->question_type,
                $request->language
            );

            Log::info('Generated fallback questions: ' . json_encode($fallbackQuestions));

            // Create practice session for fallback questions
            $sessionData = $this->savePracticeSession($course, $request, $fallbackQuestions, 'General course content', false);

            return response()->json([
                'success' => true,
                'questions' => $fallbackQuestions,
                'session_id' => $sessionData['session_id'],
                'message' => 'Generated using fallback system'
            ]);
        }
    }

    /**
     * Extract comprehensive content from course for AI analysis
     */
    protected function extractCourseContent(Course $course)
    {
        $content = [];

        // Add course basic information
        $content[] = "Course Title: " . $course->title;
        $content[] = "Course Description: " . $course->description;
        $content[] = "Course Level: " . ucfirst($course->level ?? 'beginner');

        if ($course->category) {
            $content[] = "Course Category: " . $course->category->name;
        }

        // Extract content from legacy Contents table
        $legacyContent = $this->extractLegacyContent($course);
        if (!empty($legacyContent)) {
            $content[] = "Course Materials:";
            $content[] = $legacyContent;
        }

        // Extract content from Sections and Lessons (newer structure)
        $sectionsContent = $this->extractSectionsContent($course);
        if (!empty($sectionsContent)) {
            $content[] = "Course Lessons:";
            $content[] = $sectionsContent;
        }

        // Combine all content
        $fullContent = implode("\n\n", array_filter($content));

        // If still no substantial content, create a meaningful fallback
        if (strlen($fullContent) < 200) {
            $fallbackContent = $this->generateFallbackContent($course);
            $fullContent .= "\n\n" . $fallbackContent;
        }

        // Limit content length for API efficiency (max 12000 characters)
        if (strlen($fullContent) > 12000) {
            $fullContent = substr($fullContent, 0, 12000) . "\n\n[Content truncated for processing efficiency]";
        }

        return $fullContent;
    }

    /**
     * Extract content from legacy Contents table
     */
    protected function extractLegacyContent(Course $course)
    {
        $contentParts = [];

        if ($course->contents) {
            foreach ($course->contents as $courseContent) {
                switch ($courseContent->type) {
                    case 'text':
                        if (!empty($courseContent->content)) {
                            $contentParts[] = "Text Content: " . $courseContent->content;
                        } elseif (!empty($courseContent->file)) {
                            $contentParts[] = "Text File: " . $courseContent->file;
                        }
                        break;

                    case 'youtube':
                        $videoInfo = $this->extractYouTubeInfo($courseContent->file);
                        $contentParts[] = "YouTube Video: " . $videoInfo;
                        break;

                    case 'video':
                        $contentParts[] = "Video Content: " . ($courseContent->title ?? 'Course Video');
                        break;

                    case 'pdf':
                        $pdfContent = $this->extractPDFContent($courseContent->file);
                        if (!empty($pdfContent)) {
                            $contentParts[] = "PDF Content: " . $pdfContent;
                        } else {
                            $contentParts[] = "PDF Document: " . ($courseContent->title ?? 'Course Document');
                        }
                        break;
                }
            }
        }

        return implode("\n\n", $contentParts);
    }

    /**
     * Extract content from Sections and Lessons
     */
    protected function extractSectionsContent(Course $course)
    {
        $contentParts = [];

        $sections = $course->publishedSections()->with('publishedLessons')->get();

        foreach ($sections as $section) {
            $sectionContent = [];
            $sectionContent[] = "Section: " . $section->title;

            if (!empty($section->description)) {
                $sectionContent[] = "Section Description: " . $section->description;
            }

            foreach ($section->publishedLessons as $lesson) {
                $lessonContent = $this->extractLessonContent($lesson);
                if (!empty($lessonContent)) {
                    $sectionContent[] = $lessonContent;
                }
            }

            if (count($sectionContent) > 1) { // More than just section title
                $contentParts[] = implode("\n", $sectionContent);
            }
        }

        return implode("\n\n", $contentParts);
    }

    /**
     * Extract content from individual lesson
     */
    protected function extractLessonContent($lesson)
    {
        $lessonParts = [];
        $lessonParts[] = "Lesson: " . $lesson->title;

        if (!empty($lesson->description)) {
            $lessonParts[] = "Description: " . $lesson->description;
        }

        switch ($lesson->content_type) {
            case 'text':
                if (!empty($lesson->content_text)) {
                    $lessonParts[] = "Content: " . $lesson->content_text;
                }
                break;

            case 'video':
                $videoInfo = $this->extractVideoInfo($lesson);
                $lessonParts[] = $videoInfo;
                break;

            case 'pdf':
                if (!empty($lesson->content_file)) {
                    $pdfContent = $this->extractPDFContent($lesson->content_file);
                    if (!empty($pdfContent)) {
                        $lessonParts[] = "PDF Content: " . $pdfContent;
                    } else {
                        $lessonParts[] = "PDF Document: " . $lesson->title;
                    }
                }
                break;
        }

        return implode("\n", $lessonParts);
    }

    /**
     * Extract information from YouTube videos
     */
    protected function extractYouTubeInfo($url)
    {
        if (empty($url)) {
            return "YouTube Video Content";
        }

        // Extract video ID for potential future transcript extraction
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches);
        $videoId = $matches[1] ?? null;

        if ($videoId) {
            return "YouTube Video (ID: $videoId) - Educational content related to " . $this->course->title ?? 'course topic';
        }

        return "YouTube Video - Educational content";
    }

    /**
     * Extract video information from lesson
     */
    protected function extractVideoInfo($lesson)
    {
        $info = "Video Content: " . $lesson->title;

        if ($lesson->video_provider === 'youtube' && !empty($lesson->video_id)) {
            $info .= " (YouTube Video ID: " . $lesson->video_id . ")";
        } elseif (!empty($lesson->content_url)) {
            $info .= " (Video URL: " . $lesson->content_url . ")";
        }

        if ($lesson->duration) {
            $info .= " - Duration: " . $lesson->duration . " minutes";
        }

        return $info;
    }

    /**
     * Extract text content from PDF files (placeholder for future implementation)
     */
    protected function extractPDFContent($filePath)
    {
        // TODO: Implement PDF text extraction using libraries like:
        // - spatie/pdf-to-text
        // - smalot/pdfparser
        // For now, return empty to avoid errors

        // Placeholder logic - in a real implementation, you would:
        // 1. Check if file exists in storage
        // 2. Use PDF parsing library to extract text
        // 3. Clean and format the extracted text
        // 4. Return the text content

        return '';
    }

    /**
     * Generate meaningful fallback content when no content is available
     */
    protected function generateFallbackContent(Course $course)
    {
        $fallback = [];

        $fallback[] = "This course covers comprehensive topics related to " . $course->title . ".";

        // Generate content based on course title keywords
        $titleWords = explode(' ', strtolower($course->title));
        $relevantTopics = [];

        // Map common educational keywords to topics
        $topicMap = [
            'programming' => ['algorithms', 'data structures', 'coding best practices', 'debugging techniques'],
            'web' => ['HTML', 'CSS', 'JavaScript', 'responsive design', 'web development'],
            'development' => ['software engineering', 'project management', 'testing', 'deployment'],
            'database' => ['SQL', 'data modeling', 'database design', 'queries'],
            'security' => ['cybersecurity', 'encryption', 'authentication', 'network security'],
            'design' => ['user interface', 'user experience', 'visual design', 'prototyping'],
            'marketing' => ['digital marketing', 'social media', 'content strategy', 'analytics'],
            'business' => ['management', 'strategy', 'operations', 'leadership'],
            'data' => ['data analysis', 'statistics', 'visualization', 'machine learning'],
            'mobile' => ['app development', 'iOS', 'Android', 'mobile UI/UX']
        ];

        foreach ($titleWords as $word) {
            if (isset($topicMap[$word])) {
                $relevantTopics = array_merge($relevantTopics, $topicMap[$word]);
            }
        }

        if (!empty($relevantTopics)) {
            $fallback[] = "Key topics include: " . implode(', ', array_slice($relevantTopics, 0, 4)) . ".";
        } else {
            $fallback[] = "Key concepts include theoretical foundations and practical applications.";
        }

        $fallback[] = "Students will learn essential skills and gain hands-on experience in this subject area.";
        $fallback[] = "The course is designed for " . ($course->level ?? 'beginner') . " level learners.";

        return implode(" ", $fallback);
    }

    /**
     * Generate intelligent fallback questions when AI fails
     */
    protected function generateFallbackQuestions($courseContent, $numQuestions, $difficulty, $questionType, $language)
    {
        $questions = [];

        // Analyze course content to extract key information
        $contentAnalysis = $this->analyzeContentForQuestions($courseContent);

        // Generate content-specific questions first
        $contentSpecificQuestions = $this->generateContentSpecificQuestions(
            $contentAnalysis,
            $numQuestions,
            $difficulty,
            $questionType,
            $language
        );

        // If we have enough content-specific questions, use them
        if (count($contentSpecificQuestions) >= $numQuestions) {
            return array_slice($contentSpecificQuestions, 0, $numQuestions);
        }

        // Otherwise, supplement with template-based questions
        $templateQuestions = $this->generateTemplateQuestions(
            $courseContent,
            $numQuestions - count($contentSpecificQuestions),
            $difficulty,
            $questionType,
            $language
        );

        return array_merge($contentSpecificQuestions, $templateQuestions);
    }

    /**
     * Analyze course content to extract key information for question generation
     */
    protected function analyzeContentForQuestions($courseContent)
    {
        $analysis = [
            'key_terms' => [],
            'concepts' => [],
            'topics' => [],
            'definitions' => [],
            'examples' => [],
            'processes' => [],
            'domain' => 'general'
        ];

        // Extract course title and determine domain
        if (preg_match('/Course Title:\s*(.+?)(?:\n|$)/i', $courseContent, $matches)) {
            $title = strtolower($matches[1]);
            $analysis['domain'] = $this->identifyCourseDomain($title);
            $analysis['topics'][] = $matches[1];
        }

        // Extract key terms (capitalized words, technical terms)
        preg_match_all('/\b[A-Z][a-z]+(?:\s+[A-Z][a-z]+)*\b/', $courseContent, $matches);
        $analysis['key_terms'] = array_unique(array_slice($matches[0], 0, 20));

        // Extract potential definitions (patterns like "X is", "X refers to", etc.)
        preg_match_all('/([A-Za-z\s]+)\s+(?:is|are|refers?\s+to|means?|defined?\s+as)\s+([^.!?]+)/i', $courseContent, $matches);
        for ($i = 0; $i < min(count($matches[1]), 10); $i++) {
            $analysis['definitions'][] = [
                'term' => trim($matches[1][$i]),
                'definition' => trim($matches[2][$i])
            ];
        }

        // Extract section titles and lesson titles
        preg_match_all('/(?:Section|Lesson|Chapter):\s*(.+?)(?:\n|$)/i', $courseContent, $matches);
        $analysis['topics'] = array_merge($analysis['topics'], $matches[1]);

        // Extract numbered lists or bullet points (potential concepts)
        preg_match_all('/(?:^|\n)\s*[-•*]\s*(.+?)(?:\n|$)/m', $courseContent, $matches);
        $analysis['concepts'] = array_slice($matches[1], 0, 15);

        return $analysis;
    }

    /**
     * Identify the course domain based on title keywords
     */
    protected function identifyCourseDomain($title)
    {
        $domainKeywords = [
            'programming' => ['programming', 'coding', 'software', 'development', 'python', 'java', 'javascript', 'php', 'laravel'],
            'web' => ['web', 'html', 'css', 'frontend', 'backend', 'website', 'responsive'],
            'database' => ['database', 'sql', 'mysql', 'postgresql', 'mongodb', 'data'],
            'security' => ['security', 'cybersecurity', 'encryption', 'authentication', 'firewall'],
            'design' => ['design', 'ui', 'ux', 'graphic', 'visual', 'photoshop', 'illustrator'],
            'marketing' => ['marketing', 'digital', 'social media', 'seo', 'advertising', 'branding'],
            'business' => ['business', 'management', 'strategy', 'leadership', 'entrepreneurship'],
            'data_science' => ['data science', 'machine learning', 'ai', 'analytics', 'statistics'],
            'mobile' => ['mobile', 'android', 'ios', 'app development', 'react native']
        ];

        foreach ($domainKeywords as $domain => $keywords) {
            foreach ($keywords as $keyword) {
                if (strpos($title, $keyword) !== false) {
                    return $domain;
                }
            }
        }

        return 'general';
    }

    /**
     * Generate content-specific questions based on analysis
     */
    protected function generateContentSpecificQuestions($analysis, $numQuestions, $difficulty, $questionType, $language)
    {
        $questions = [];
        $questionCount = 0;

        // Generate questions from definitions
        foreach ($analysis['definitions'] as $def) {
            if ($questionCount >= $numQuestions) break;

            $question = $this->createDefinitionQuestion($def, $difficulty, $questionType, $language);
            if ($question) {
                $questions[] = $question;
                $questionCount++;
            }
        }

        // Generate questions from key terms
        foreach ($analysis['key_terms'] as $term) {
            if ($questionCount >= $numQuestions) break;

            $question = $this->createTermQuestion($term, $analysis['domain'], $difficulty, $questionType, $language);
            if ($question) {
                $questions[] = $question;
                $questionCount++;
            }
        }

        // Generate questions from concepts
        foreach ($analysis['concepts'] as $concept) {
            if ($questionCount >= $numQuestions) break;

            $question = $this->createConceptQuestion($concept, $analysis['domain'], $difficulty, $questionType, $language);
            if ($question) {
                $questions[] = $question;
                $questionCount++;
            }
        }

        return $questions;
    }

    /**
     * Generate template-based questions as fallback
     */
    protected function generateTemplateQuestions($courseContent, $numQuestions, $difficulty, $questionType, $language)
    {
        $questions = [];

        // Enhanced question templates with more variety
        $questionTemplates = [
            'en' => [
                'easy' => [
                    'What is the main topic covered in this course?',
                    'Which of the following is a key concept in this subject?',
                    'What should students learn first in this course?',
                    'What is the fundamental principle discussed?',
                    'Which statement best describes the course content?',
                    'What is the primary focus of this learning material?',
                    'Which concept forms the foundation of this subject?',
                    'What is the basic definition used in this course?',
                    'Which approach is introduced first?',
                    'What is the starting point for understanding this topic?',
                    'Which element is most essential to grasp?',
                    'What is the core idea presented?',
                    'Which principle guides the entire course?',
                    'What is the main objective of this learning?',
                    'Which concept appears most frequently?',
                    'What is the central theme discussed?',
                    'Which idea connects all the topics?',
                    'What is the underlying theory?',
                    'Which method is emphasized throughout?',
                    'What is the key takeaway from this course?'
                ],
                'medium' => [
                    'How do the different concepts in this course relate to each other?',
                    'What is the practical application of the theories discussed?',
                    'Which approach would be most effective in real-world scenarios?',
                    'How can the knowledge from this course be implemented?',
                    'What are the main differences between the methods presented?',
                    'How does this subject connect to other fields of study?',
                    'What are the advantages and disadvantages of each approach?',
                    'How can students apply these concepts in practice?',
                    'What factors influence the effectiveness of these methods?',
                    'How do the theoretical concepts translate to practical use?',
                    'What are the common challenges in implementing these ideas?',
                    'How can the course material be adapted to different situations?',
                    'What are the best practices recommended in this field?',
                    'How do experts typically approach problems in this area?',
                    'What are the current trends in this subject matter?',
                    'How has this field evolved over time?',
                    'What are the future implications of these concepts?',
                    'How can technology enhance the application of these ideas?',
                    'What are the ethical considerations in this field?',
                    'How can continuous improvement be achieved?'
                ],
                'hard' => [
                    'Analyze the complex relationships between multiple concepts in this course',
                    'Evaluate the effectiveness of different methodologies presented',
                    'Compare and contrast various approaches to problem-solving',
                    'Synthesize information from different parts of the course',
                    'Apply critical thinking to assess the validity of theories',
                    'Design a comprehensive solution using course principles',
                    'Critique the limitations of current approaches',
                    'Develop innovative applications of the learned concepts',
                    'Assess the long-term impact of implementing these methods',
                    'Create a framework for evaluating different strategies',
                    'Analyze case studies and extract key insights',
                    'Formulate hypotheses based on the course material',
                    'Evaluate the research methodology used in this field',
                    'Propose improvements to existing systems or processes',
                    'Analyze the cost-benefit ratio of different approaches',
                    'Develop metrics for measuring success in this domain',
                    'Create a decision-making framework for complex scenarios',
                    'Assess the scalability of proposed solutions',
                    'Evaluate the sustainability of different practices',
                    'Design experiments to test theoretical concepts'
                ]
            ],
            'ar' => [
                'easy' => [
                    'ما هو الموضوع الرئيسي المغطى في هذا الكورس؟',
                    'أي من التالي يعتبر مفهوماً أساسياً في هذا الموضوع؟',
                    'ماذا يجب أن يتعلم الطلاب أولاً في هذا الكورس؟',
                    'ما هو المبدأ الأساسي المناقش؟',
                    'أي عبارة تصف محتوى الكورس بشكل أفضل؟',
                    'ما هو التركيز الأساسي لهذه المادة التعليمية؟',
                    'أي مفهوم يشكل أساس هذا الموضوع؟',
                    'ما هو التعريف الأساسي المستخدم في هذا الكورس؟',
                    'أي نهج يتم تقديمه أولاً؟',
                    'ما هي نقطة البداية لفهم هذا الموضوع؟',
                    'أي عنصر هو الأكثر أهمية للفهم؟',
                    'ما هي الفكرة الأساسية المقدمة؟',
                    'أي مبدأ يوجه الكورس بأكمله؟',
                    'ما هو الهدف الرئيسي من هذا التعلم؟',
                    'أي مفهوم يظهر بشكل أكثر تكراراً؟',
                    'ما هو الموضوع المركزي المناقش؟',
                    'أي فكرة تربط جميع المواضيع؟',
                    'ما هي النظرية الأساسية؟',
                    'أي طريقة يتم التأكيد عليها؟',
                    'ما هي النقطة الأساسية من هذا الكورس؟'
                ]
            ]
        ];

        // Enhanced options with more realistic content
        $optionTemplates = [
            'en' => [
                'programming' => [
                    ['Variables and data types', 'Functions and methods', 'Object-oriented programming', 'All of the above'],
                    ['Syntax and semantics', 'Debugging techniques', 'Code optimization', 'All programming concepts'],
                    ['Basic algorithms', 'Data structures', 'Design patterns', 'Complete programming foundation'],
                    ['Input/output operations', 'Control structures', 'Error handling', 'Fundamental programming skills']
                ],
                'general' => [
                    ['Theoretical foundations', 'Practical applications', 'Advanced concepts', 'Comprehensive understanding'],
                    ['Basic principles', 'Implementation methods', 'Best practices', 'Complete knowledge base'],
                    ['Core concepts', 'Real-world examples', 'Expert techniques', 'Full mastery'],
                    ['Fundamental ideas', 'Practical skills', 'Advanced strategies', 'Total competency']
                ]
            ],
            'ar' => [
                'general' => [
                    ['الأسس النظرية', 'التطبيقات العملية', 'المفاهيم المتقدمة', 'الفهم الشامل'],
                    ['المبادئ الأساسية', 'طرق التنفيذ', 'أفضل الممارسات', 'قاعدة المعرفة الكاملة'],
                    ['المفاهيم الأساسية', 'أمثلة من الواقع', 'تقنيات الخبراء', 'الإتقان الكامل'],
                    ['الأفكار الأساسية', 'المهارات العملية', 'الاستراتيجيات المتقدمة', 'الكفاءة الكاملة']
                ]
            ]
        ];

        $questionPool = $questionTemplates[$language][$difficulty] ?? $questionTemplates['en']['medium'];
        $optionPool = $optionTemplates[$language]['general'] ?? $optionTemplates['en']['general'];

        // Generate the requested number of questions
        for ($i = 0; $i < $numQuestions; $i++) {
            $questionText = $questionPool[$i % count($questionPool)];

            if ($questionType === 'multiple_choice' || $questionType === 'mixed') {
                $options = $optionPool[$i % count($optionPool)];

                $questions[] = [
                    'id' => $i + 1,
                    'type' => 'multiple_choice',
                    'question' => $questionText,
                    'options' => $options,
                    'correct_answer' => $options[3], // Last option is usually correct
                    'explanation' => $language === 'ar' ?
                        'هذا سؤال تم إنشاؤه تلقائياً بناءً على محتوى الكورس للمراجعة والتدريب.' :
                        'This is an automatically generated question based on course content for review and practice.'
                ];
            } elseif ($questionType === 'true_false') {
                $tfQuestions = $language === 'ar' ? [
                    'هذا المفهوم صحيح ومهم في الكورس',
                    'هذه الطريقة فعالة في التطبيق العملي',
                    'هذا المبدأ أساسي في فهم الموضوع'
                ] : [
                    'This concept is fundamental to understanding the course material',
                    'This method is effective in practical applications',
                    'This principle is essential for mastering the subject'
                ];

                $questions[] = [
                    'id' => $i + 1,
                    'type' => 'true_false',
                    'question' => $tfQuestions[$i % count($tfQuestions)],
                    'options' => $language === 'ar' ? ['صحيح', 'خطأ'] : ['True', 'False'],
                    'correct_answer' => $language === 'ar' ? 'صحيح' : 'True',
                    'explanation' => $language === 'ar' ?
                        'هذا سؤال صح/خطأ تم إنشاؤه للتدريب.' :
                        'This is a true/false question generated for practice.'
                ];
            }
        }

        return $questions;
    }

    /**
     * Submit quiz and calculate score
     */
    public function submitQuiz(Request $request, $courseId)
    {
        $answers = $request->input('answers', []);
        $questions = $request->input('questions', []);
        
        $score = 0;
        $total = count($questions);
        
        foreach ($questions as $index => $question) {
            $userAnswer = $answers[$index] ?? null;
            $correctAnswer = $question['correct_answer'] ?? null;
            
            if ($userAnswer === $correctAnswer) {
                $score++;
            }
        }
        
        $percentage = $total > 0 ? round(($score / $total) * 100) : 0;
        
        return response()->json([
            'success' => true,
            'score' => $score,
            'total' => $total,
            'percentage' => $percentage
        ]);
    }

    /**
     * Create a question from a definition
     */
    protected function createDefinitionQuestion($definition, $difficulty, $questionType, $language)
    {
        if (empty($definition['term']) || empty($definition['definition'])) {
            return null;
        }

        $term = $definition['term'];
        $def = $definition['definition'];

        if ($questionType === 'multiple_choice' || $questionType === 'mixed') {
            return [
                'id' => uniqid(),
                'type' => 'multiple_choice',
                'question' => $language === 'ar' ?
                    "ما هو تعريف {$term}؟" :
                    "What is the definition of {$term}?",
                'options' => $this->generateDefinitionOptions($def, $language),
                'correct_answer' => 0,
                'explanation' => $language === 'ar' ?
                    "التعريف الصحيح هو: {$def}" :
                    "The correct definition is: {$def}"
            ];
        } elseif ($questionType === 'true_false') {
            return [
                'id' => uniqid(),
                'type' => 'true_false',
                'question' => $language === 'ar' ?
                    "{$term} يُعرف بأنه: {$def}" :
                    "{$term} is defined as: {$def}",
                'correct_answer' => $language === 'ar' ? 'صح' : 'true',
                'explanation' => $language === 'ar' ?
                    "هذا التعريف صحيح" :
                    "This definition is correct"
            ];
        }

        return null;
    }

    /**
     * Create a question from a key term
     */
    protected function createTermQuestion($term, $domain, $difficulty, $questionType, $language)
    {
        if (empty($term)) {
            return null;
        }

        $domainContext = $this->getDomainContext($domain, $language);

        if ($questionType === 'multiple_choice' || $questionType === 'mixed') {
            return [
                'id' => uniqid(),
                'type' => 'multiple_choice',
                'question' => $language === 'ar' ?
                    "في سياق {$domainContext}، ما هو الغرض الأساسي من {$term}؟" :
                    "In the context of {$domainContext}, what is the primary purpose of {$term}?",
                'options' => $this->generateTermOptions($term, $domain, $language),
                'correct_answer' => 0,
                'explanation' => $language === 'ar' ?
                    "{$term} هو مفهوم مهم في {$domainContext}" :
                    "{$term} is an important concept in {$domainContext}"
            ];
        }

        return null;
    }

    /**
     * Create a question from a concept
     */
    protected function createConceptQuestion($concept, $domain, $difficulty, $questionType, $language)
    {
        if (empty($concept)) {
            return null;
        }

        $domainContext = $this->getDomainContext($domain, $language);

        if ($questionType === 'multiple_choice' || $questionType === 'mixed') {
            return [
                'id' => uniqid(),
                'type' => 'multiple_choice',
                'question' => $language === 'ar' ?
                    "بناءً على محتوى الكورس، أي من التالي يصف بشكل أفضل: {$concept}؟" :
                    "Based on the course content, which of the following best describes: {$concept}?",
                'options' => $this->generateConceptOptions($concept, $domain, $language),
                'correct_answer' => 0,
                'explanation' => $language === 'ar' ?
                    "هذا المفهوم مهم لفهم {$domainContext}" :
                    "This concept is important for understanding {$domainContext}"
            ];
        }

        return null;
    }

    /**
     * Generate options for definition questions
     */
    protected function generateDefinitionOptions($correctDefinition, $language)
    {
        $options = [substr($correctDefinition, 0, 100)]; // Correct answer first

        // Generate plausible but incorrect options
        $incorrectOptions = $language === 'ar' ? [
            'مفهوم غير مرتبط بالموضوع الأساسي',
            'تعريف عام لا يتعلق بالسياق المحدد',
            'وصف مختلف تماماً عن المطلوب'
        ] : [
            'A concept unrelated to the main topic',
            'A general definition not specific to this context',
            'A completely different description'
        ];

        $options = array_merge($options, array_slice($incorrectOptions, 0, 3));
        return $options;
    }

    /**
     * Generate options for term questions
     */
    protected function generateTermOptions($term, $domain, $language)
    {
        $domainSpecificOptions = $this->getDomainSpecificOptions($domain, $language);

        // First option is always the most relevant/correct
        $options = [$domainSpecificOptions[0]];

        // Add other plausible options
        $options = array_merge($options, array_slice($domainSpecificOptions, 1, 3));

        return $options;
    }

    /**
     * Generate options for concept questions
     */
    protected function generateConceptOptions($concept, $domain, $language)
    {
        $options = [];

        // Create a relevant first option based on the concept
        $options[] = $language === 'ar' ?
            "مفهوم أساسي يساعد في فهم الموضوع" :
            "A fundamental concept that helps understand the topic";

        // Add generic but plausible options
        $genericOptions = $language === 'ar' ? [
            'أداة مساعدة في التطبيق العملي',
            'مبدأ نظري مهم للدراسة',
            'عنصر تكميلي في المنهج'
        ] : [
            'A practical tool for implementation',
            'An important theoretical principle',
            'A supplementary element in the curriculum'
        ];

        $options = array_merge($options, $genericOptions);
        return $options;
    }

    /**
     * Get domain context description
     */
    protected function getDomainContext($domain, $language)
    {
        $contexts = [
            'ar' => [
                'programming' => 'البرمجة',
                'web' => 'تطوير الويب',
                'database' => 'قواعد البيانات',
                'security' => 'الأمن السيبراني',
                'design' => 'التصميم',
                'marketing' => 'التسويق',
                'business' => 'إدارة الأعمال',
                'data_science' => 'علم البيانات',
                'mobile' => 'تطوير التطبيقات',
                'general' => 'التعليم العام'
            ],
            'en' => [
                'programming' => 'programming',
                'web' => 'web development',
                'database' => 'database management',
                'security' => 'cybersecurity',
                'design' => 'design',
                'marketing' => 'marketing',
                'business' => 'business management',
                'data_science' => 'data science',
                'mobile' => 'mobile development',
                'general' => 'general education'
            ]
        ];

        return $contexts[$language][$domain] ?? $contexts[$language]['general'];
    }

    /**
     * Get domain-specific options for questions
     */
    protected function getDomainSpecificOptions($domain, $language)
    {
        $domainOptions = [
            'programming' => [
                'ar' => [
                    'أداة لكتابة وتنفيذ الكود البرمجي',
                    'مكتبة للرسوميات والتصميم',
                    'نظام لإدارة قواعد البيانات',
                    'برنامج لتحرير النصوص'
                ],
                'en' => [
                    'A tool for writing and executing code',
                    'A graphics and design library',
                    'A database management system',
                    'A text editing program'
                ]
            ],
            'web' => [
                'ar' => [
                    'تقنية لبناء مواقع الويب التفاعلية',
                    'أداة لتصميم الجرافيك',
                    'نظام لإدارة الملفات',
                    'برنامج لتحليل البيانات'
                ],
                'en' => [
                    'A technology for building interactive websites',
                    'A graphic design tool',
                    'A file management system',
                    'A data analysis program'
                ]
            ],
            'general' => [
                'ar' => [
                    'مفهوم مهم في هذا المجال',
                    'أداة مساعدة في التعلم',
                    'مبدأ أساسي في الموضوع',
                    'عنصر تكميلي في الدراسة'
                ],
                'en' => [
                    'An important concept in this field',
                    'A helpful learning tool',
                    'A fundamental principle in the subject',
                    'A supplementary element in study'
                ]
            ]
        ];

        return $domainOptions[$domain][$language] ?? $domainOptions['general'][$language];
    }

    /**
     * Save practice session and questions to database
     */
    protected function savePracticeSession(Course $course, Request $request, array $questions, string $courseContent, bool $usedAI)
    {
        $user = Auth::user();
        $sessionId = Str::uuid();

        // Create practice session
        $session = PracticeSession::create([
            'session_id' => $sessionId,
            'user_id' => $user->id,
            'course_id' => $course->id,
            'total_questions' => count($questions),
            'difficulty' => $request->difficulty,
            'question_type' => $request->question_type,
            'language' => $request->language ?? 'en',
            'ai_service_used' => $usedAI ? 'gemini' : 'fallback',
            'used_fallback' => !$usedAI,
            'content_summary' => Str::limit($courseContent, 500),
            'status' => 'active',
        ]);

        // Save individual questions
        foreach ($questions as $index => $question) {
            $contentAnalysis = $this->analyzeContentForQuestions($courseContent);

            PracticeQuestion::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'session_id' => $sessionId,
                'type' => $question['type'] ?? 'multiple_choice',
                'question' => $question['question'],
                'options' => $question['options'] ?? null,
                'correct_answer' => $question['correct_answer'],
                'explanation' => $question['explanation'] ?? null,
                'sample_answer' => $question['sample_answer'] ?? null,
                'key_points' => $question['key_points'] ?? null,
                'difficulty' => $request->difficulty,
                'language' => $request->language ?? 'en',
                'is_ai_generated' => $usedAI,
                'ai_service' => $usedAI ? 'gemini' : 'fallback',
                'content_context' => Str::limit($courseContent, 1000),
                'content_keywords' => $contentAnalysis['key_terms'] ?? [],
                'generation_method' => $usedAI ? 'ai' : 'fallback',
                'generation_metadata' => [
                    'question_index' => $index,
                    'domain' => $contentAnalysis['domain'] ?? 'general',
                    'generated_at' => now()->toISOString(),
                    'content_length' => strlen($courseContent),
                ],
            ]);
        }

        return [
            'session_id' => $sessionId,
            'session' => $session,
            'questions_saved' => count($questions)
        ];
    }
}
