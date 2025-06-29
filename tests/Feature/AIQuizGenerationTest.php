<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Category;
use App\Models\Content;
use App\Models\PracticeSession;
use App\Models\PracticeQuestion;

class AIQuizGenerationTest extends TestCase
{
    use RefreshDatabase;

    protected $student;
    protected $course;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test student (users with role 'user' are students)
        $this->student = User::factory()->create([
            'role' => 'user',
            'email' => 'student@test.com',
            'username' => 'teststudent'
        ]);

        // Create a test category
        $category = Category::create([
            'name' => 'Programming',
            'description' => 'Programming courses'
        ]);

        // Create a test course with content
        $this->course = Course::create([
            'title' => 'Introduction to Web Development',
            'description' => 'Learn the basics of HTML, CSS, and JavaScript for web development.',
            'level' => 'beginner',
            'category_id' => $category->id,
            'creator_id' => 1,
            'status' => 'published'
        ]);

        // Add some content to the course
        Content::create([
            'course_id' => $this->course->id,
            'type' => 'text',
            'title' => 'HTML Basics',
            'content' => 'HTML (HyperText Markup Language) is the standard markup language for creating web pages. It describes the structure of a web page using elements and tags.',
            'order' => 1
        ]);

        Content::create([
            'course_id' => $this->course->id,
            'type' => 'text',
            'title' => 'CSS Fundamentals',
            'content' => 'CSS (Cascading Style Sheets) is used to style and layout web pages. It controls the presentation, formatting, and layout of HTML elements.',
            'order' => 2
        ]);

        // Enroll the student in the course
        $this->student->enrolledCourses()->attach($this->course->id, [
            'status' => 'approved'
        ]);
    }

    /** @test */
    public function student_can_access_ai_practice_page()
    {
        $response = $this->actingAs($this->student)
            ->get(route('student.ai.practice'));

        $response->assertStatus(200);
        $response->assertViewIs('student.ai-practice');
    }

    /** @test */
    public function student_can_access_ai_quiz_for_enrolled_course()
    {
        $response = $this->actingAs($this->student)
            ->get(route('student.ai.quiz', $this->course->id));

        $response->assertStatus(200);
        $response->assertViewIs('student.ai-quiz');
        $response->assertViewHas('course', $this->course);
    }

    /** @test */
    public function student_cannot_access_ai_quiz_for_unenrolled_course()
    {
        // Create another course
        $otherCourse = Course::create([
            'title' => 'Advanced Programming',
            'description' => 'Advanced programming concepts',
            'level' => 'advanced',
            'category_id' => $this->course->category_id,
            'creator_id' => 1,
            'status' => 'published'
        ]);

        $response = $this->actingAs($this->student)
            ->get(route('student.ai.quiz', $otherCourse->id));

        $response->assertRedirect(route('student.ai.practice'));
        $response->assertSessionHas('error');
    }

    /** @test */
    public function ai_quiz_generation_creates_practice_session_and_questions()
    {
        $requestData = [
            'num_questions' => 3,
            'difficulty' => 'easy',
            'question_type' => 'multiple_choice',
            'language' => 'en'
        ];

        $response = $this->actingAs($this->student)
            ->postJson(route('student.ai.quiz.generate', $this->course->id), $requestData);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'questions',
            'session_id'
        ]);

        $responseData = $response->json();
        $this->assertTrue($responseData['success']);
        $this->assertCount(3, $responseData['questions']);
        $this->assertNotEmpty($responseData['session_id']);

        // Check that practice session was created
        $this->assertDatabaseHas('practice_sessions', [
            'session_id' => $responseData['session_id'],
            'user_id' => $this->student->id,
            'course_id' => $this->course->id,
            'total_questions' => 3,
            'difficulty' => 'easy',
            'question_type' => 'multiple_choice',
            'status' => 'active'
        ]);

        // Check that practice questions were created
        $this->assertEquals(3, PracticeQuestion::where('session_id', $responseData['session_id'])->count());
    }

    /** @test */
    public function fallback_questions_are_generated_when_ai_fails()
    {
        // This test assumes AI will fail (no API key or service unavailable)
        $requestData = [
            'num_questions' => 2,
            'difficulty' => 'medium',
            'question_type' => 'mixed',
            'language' => 'en'
        ];

        $response = $this->actingAs($this->student)
            ->postJson(route('student.ai.quiz.generate', $this->course->id), $requestData);

        $response->assertStatus(200);
        $responseData = $response->json();
        
        $this->assertTrue($responseData['success']);
        $this->assertCount(2, $responseData['questions']);

        // Check that session was created with fallback flag
        $session = PracticeSession::where('session_id', $responseData['session_id'])->first();
        $this->assertNotNull($session);
        $this->assertTrue($session->used_fallback);
        $this->assertEquals('fallback', $session->ai_service_used);
    }

    /** @test */
    public function content_specific_questions_are_generated_from_course_content()
    {
        $requestData = [
            'num_questions' => 2,
            'difficulty' => 'easy',
            'question_type' => 'multiple_choice',
            'language' => 'en'
        ];

        $response = $this->actingAs($this->student)
            ->postJson(route('student.ai.quiz.generate', $this->course->id), $requestData);

        $response->assertStatus(200);
        $responseData = $response->json();
        
        // Check that questions contain course-specific content
        $questions = $responseData['questions'];
        $questionTexts = collect($questions)->pluck('question')->implode(' ');
        
        // Should contain references to web development concepts
        $this->assertTrue(
            str_contains(strtolower($questionTexts), 'html') ||
            str_contains(strtolower($questionTexts), 'css') ||
            str_contains(strtolower($questionTexts), 'web') ||
            str_contains(strtolower($questionTexts), 'development'),
            'Questions should contain course-specific content'
        );
    }

    /** @test */
    public function practice_questions_have_proper_metadata()
    {
        $requestData = [
            'num_questions' => 1,
            'difficulty' => 'hard',
            'question_type' => 'true_false',
            'language' => 'en'
        ];

        $response = $this->actingAs($this->student)
            ->postJson(route('student.ai.quiz.generate', $this->course->id), $requestData);

        $response->assertStatus(200);
        $responseData = $response->json();

        $practiceQuestion = PracticeQuestion::where('session_id', $responseData['session_id'])->first();
        
        $this->assertNotNull($practiceQuestion);
        $this->assertEquals('hard', $practiceQuestion->difficulty);
        $this->assertEquals('true_false', $practiceQuestion->type);
        $this->assertEquals('en', $practiceQuestion->language);
        $this->assertNotNull($practiceQuestion->content_context);
        $this->assertNotNull($practiceQuestion->generation_metadata);
        $this->assertIsArray($practiceQuestion->content_keywords);
    }
}
