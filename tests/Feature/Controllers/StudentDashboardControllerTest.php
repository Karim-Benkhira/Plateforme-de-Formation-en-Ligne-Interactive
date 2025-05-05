<?php

namespace Tests\Feature\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StudentDashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test student dashboard requires authentication.
     */
    public function test_dashboard_requires_authentication(): void
    {
        // Try to access the dashboard without being authenticated
        $response = $this->get(route('student.dashboard'));

        // Assert the user is redirected to login
        $response->assertRedirect(route('login'));
    }

    /**
     * Test student dashboard displays correctly.
     */
    public function test_dashboard_displays_correctly(): void
    {
        // Create a student
        $student = User::factory()->create(['role' => 'student']);

        // Create courses and enrollments
        $course1 = Course::factory()->create();
        $course2 = Course::factory()->create();

        Enrollment::factory()->create([
            'user_id' => $student->id,
            'course_id' => $course1->id,
            'status' => 'active',
            'progress' => 50
        ]);

        Enrollment::factory()->create([
            'user_id' => $student->id,
            'course_id' => $course2->id,
            'status' => 'active',
            'progress' => 25
        ]);

        // Authenticate as the student
        $this->actingAs($student);

        // Visit the dashboard
        $response = $this->get(route('student.dashboard'));

        // Assert the response is successful
        $response->assertStatus(200);

        // Assert the dashboard displays the enrollments
        $response->assertSee($course1->title);
        $response->assertSee($course2->title);
    }

    /**
     * Test student can view enrolled courses.
     */
    public function test_student_can_view_enrolled_courses(): void
    {
        // Create a student
        $student = User::factory()->create(['role' => 'student']);

        // Create courses and enrollments
        $course1 = Course::factory()->create();
        $course2 = Course::factory()->create();

        Enrollment::factory()->create([
            'user_id' => $student->id,
            'course_id' => $course1->id,
            'status' => 'active'
        ]);

        Enrollment::factory()->create([
            'user_id' => $student->id,
            'course_id' => $course2->id,
            'status' => 'active'
        ]);

        // Authenticate as the student
        $this->actingAs($student);

        // Visit the courses page
        $response = $this->get(route('student.courses'));

        // Assert the response is successful
        $response->assertStatus(200);

        // Assert the courses are displayed
        $response->assertSee($course1->title);
        $response->assertSee($course2->title);
    }

    /**
     * Test student can view course details.
     */
    public function test_student_can_view_course_details(): void
    {
        // Create a student
        $student = User::factory()->create(['role' => 'student']);

        // Create a course with modules and lessons
        $course = Course::factory()->create();
        $module = Module::factory()->create(['course_id' => $course->id]);
        $lesson = Lesson::factory()->create(['module_id' => $module->id]);

        // Create an enrollment
        Enrollment::factory()->create([
            'user_id' => $student->id,
            'course_id' => $course->id,
            'status' => 'active'
        ]);

        // Authenticate as the student
        $this->actingAs($student);

        // Visit the course details page
        $response = $this->get(route('student.courses.show', $course));

        // Assert the response is successful
        $response->assertStatus(200);

        // Assert the course details are displayed
        $response->assertSee($course->title);
        $response->assertSee($module->title);
        $response->assertSee($lesson->title);
    }

    /**
     * Test student can view lesson.
     */
    public function test_student_can_view_lesson(): void
    {
        // Create a student
        $student = User::factory()->create(['role' => 'student']);

        // Create a course with modules and lessons
        $course = Course::factory()->create();
        $module = Module::factory()->create(['course_id' => $course->id]);
        $lesson = Lesson::factory()->create([
            'module_id' => $module->id,
            'content_type' => 'text',
            'content' => 'This is a test lesson content.'
        ]);

        // Create an enrollment
        Enrollment::factory()->create([
            'user_id' => $student->id,
            'course_id' => $course->id,
            'status' => 'active'
        ]);

        // Authenticate as the student
        $this->actingAs($student);

        // Visit the lesson page
        $response = $this->get(route('student.lessons.show', $lesson));

        // Assert the response is successful
        $response->assertStatus(200);

        // Assert the lesson content is displayed
        $response->assertSee($lesson->title);
        $response->assertSee('This is a test lesson content.');
    }

    /**
     * Test student can mark lesson as completed.
     */
    public function test_student_can_mark_lesson_as_completed(): void
    {
        // Create a student
        $student = User::factory()->create(['role' => 'student']);

        // Create a course with modules and lessons
        $course = Course::factory()->create();
        $module = Module::factory()->create(['course_id' => $course->id]);
        $lesson = Lesson::factory()->create(['module_id' => $module->id]);

        // Create an enrollment
        $enrollment = Enrollment::factory()->create([
            'user_id' => $student->id,
            'course_id' => $course->id,
            'status' => 'active',
            'progress' => 0
        ]);

        // Authenticate as the student
        $this->actingAs($student);

        // Mark the lesson as completed
        $response = $this->post(route('student.lessons.complete', $lesson));

        // Assert the user is redirected back
        $response->assertRedirect();

        // Assert the lesson is marked as completed
        $this->assertDatabaseHas('lesson_user', [
            'user_id' => $student->id,
            'lesson_id' => $lesson->id
        ]);

        // Assert the enrollment progress is updated
        $this->assertDatabaseHas('enrollments', [
            'id' => $enrollment->id,
            'progress' => 100 // Since there's only one lesson, progress should be 100%
        ]);
    }

    /**
     * Test student can view quiz.
     */
    public function test_student_can_view_quiz(): void
    {
        // Create a student
        $student = User::factory()->create(['role' => 'student']);

        // Create a course with modules, lessons, and a quiz
        $course = Course::factory()->create();
        $module = Module::factory()->create(['course_id' => $course->id]);
        $lesson = Lesson::factory()->create(['module_id' => $module->id]);
        $quiz = Quiz::factory()->create([
            'lesson_id' => $lesson->id,
            'status' => 'open'
        ]);

        // Create an enrollment
        Enrollment::factory()->create([
            'user_id' => $student->id,
            'course_id' => $course->id,
            'status' => 'active'
        ]);

        // Authenticate as the student
        $this->actingAs($student);

        // Visit the quiz page
        $response = $this->get(route('student.quizzes.show', $quiz));

        // Assert the response is successful
        $response->assertStatus(200);

        // Assert the quiz details are displayed
        $response->assertSee($quiz->title);
    }

    /**
     * Test student can view quiz results.
     */
    public function test_student_can_view_quiz_results(): void
    {
        // Create a student
        $student = User::factory()->create(['role' => 'student']);

        // Create a course with modules, lessons, and a quiz
        $course = Course::factory()->create();
        $module = Module::factory()->create(['course_id' => $course->id]);
        $lesson = Lesson::factory()->create(['module_id' => $module->id]);
        $quiz = Quiz::factory()->create(['lesson_id' => $lesson->id]);

        // Create a quiz result
        $quizResult = QuizResult::factory()->create([
            'user_id' => $student->id,
            'quiz_id' => $quiz->id,
            'score' => 85,
            'passed' => true,
            'status' => 'completed'
        ]);

        // Authenticate as the student
        $this->actingAs($student);

        // Visit the results page
        $response = $this->get(route('student.results'));

        // Assert the response is successful
        $response->assertStatus(200);

        // Assert the quiz result is displayed
        $response->assertSee($quiz->title);
        $response->assertSee('85');
    }

    /**
     * Test student can view specific quiz result.
     */
    public function test_student_can_view_specific_quiz_result(): void
    {
        // Create a student
        $student = User::factory()->create(['role' => 'student']);

        // Create a course with modules, lessons, and a quiz
        $course = Course::factory()->create();
        $module = Module::factory()->create(['course_id' => $course->id]);
        $lesson = Lesson::factory()->create(['module_id' => $module->id]);
        $quiz = Quiz::factory()->create(['lesson_id' => $lesson->id]);

        // Create a quiz result
        $quizResult = QuizResult::factory()->create([
            'user_id' => $student->id,
            'quiz_id' => $quiz->id,
            'score' => 85,
            'passed' => true,
            'status' => 'completed'
        ]);

        // Authenticate as the student
        $this->actingAs($student);

        // Visit the specific result page
        $response = $this->get(route('student.results.show', $quizResult));

        // Assert the response is successful
        $response->assertStatus(200);

        // Assert the quiz result details are displayed
        $response->assertSee($quiz->title);
        $response->assertSee('85%');
        $response->assertSee('PASSED');
    }
}
