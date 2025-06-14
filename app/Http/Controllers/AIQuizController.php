<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Services\GeminiAIService;
use App\Services\StudentPracticeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AIQuizController extends Controller
{
    protected $geminiService;
    protected $practiceService;

    public function __construct(GeminiAIService $geminiService, StudentPracticeService $practiceService)
    {
        $this->geminiService = $geminiService;
        $this->practiceService = $practiceService;
    }

    /**
     * Show AI Quiz page for a course
     */
    public function showAIQuiz($courseId)
    {
        $course = Course::findOrFail($courseId);
        
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

            return response()->json([
                'success' => true,
                'questions' => $questions
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

            return response()->json([
                'success' => true,
                'questions' => $fallbackQuestions,
                'message' => 'Generated using fallback system'
            ]);
        }
    }

    /**
     * Extract content from course
     */
    protected function extractCourseContent(Course $course)
    {
        $content = '';

        // Get course title and description
        $content .= "Course Title: " . $course->title . "\n\n";
        $content .= "Course Description: " . $course->description . "\n\n";

        // Get course contents
        $content .= "Course Content:\n";
        
        if ($course->contents) {
            foreach ($course->contents as $courseContent) {
                if ($courseContent->type === 'text') {
                    $content .= "- " . $courseContent->file . "\n\n";
                } elseif ($courseContent->type === 'youtube') {
                    $content .= "- Video content: " . $courseContent->title . "\n\n";
                } elseif ($courseContent->type === 'video') {
                    $content .= "- Video content: " . $courseContent->title . "\n\n";
                } elseif ($courseContent->type === 'pdf') {
                    $content .= "- PDF document: " . $courseContent->title . "\n\n";
                }
            }
        }

        // If no content was found, add a fallback message
        if (strlen($content) < 100) {
            $content .= "This course covers topics related to " . $course->title . ".\n";
            $content .= "Key concepts include theoretical foundations and practical applications.\n";
        }

        return $content;
    }

    /**
     * Generate fallback questions when AI fails
     */
    protected function generateFallbackQuestions($courseContent, $numQuestions, $difficulty, $questionType, $language)
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
}
