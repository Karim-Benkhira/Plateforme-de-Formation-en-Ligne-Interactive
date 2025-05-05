<?php

namespace Tests\Feature\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CourseControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test course index page displays courses.
     */
    public function test_index_displays_courses(): void
    {
        // Create some courses
        $courses = Course::factory()->count(3)->create(['status' => 'active']);

        // Visit the courses index page
        $response = $this->get(route('courses.index'));

        // Assert the response is successful
        $response->assertStatus(200);

        // Assert the courses are displayed
        foreach ($courses as $course) {
            $response->assertSee($course->title);
        }
    }

    /**
     * Test course show page displays course details.
     */
    public function test_show_displays_course_details(): void
    {
        // Create a course
        $course = Course::factory()->create();

        // Visit the course show page
        $response = $this->get(route('courses.show', $course));

        // Assert the response is successful
        $response->assertStatus(200);

        // Assert the course details are displayed
        $response->assertSee($course->title);
        $response->assertSee($course->description);
    }

    /**
     * Test course enrollment requires authentication.
     */
    public function test_enroll_requires_authentication(): void
    {
        // Create a course
        $course = Course::factory()->create();

        // Try to enroll without being authenticated
        $response = $this->post(route('courses.enroll', $course));

        // Assert the user is redirected to login
        $response->assertRedirect(route('login'));
    }

    /**
     * Test student can enroll in a course.
     */
    public function test_student_can_enroll_in_course(): void
    {
        // Create a student
        $student = User::factory()->create(['role' => 'student']);

        // Create a course
        $course = Course::factory()->create();

        // Authenticate as the student
        $this->actingAs($student);

        // Enroll in the course
        $response = $this->post(route('courses.enroll', $course));

        // Assert the user is redirected to the course page
        $response->assertRedirect(route('student.courses.show', $course));

        // Assert the enrollment was created
        $this->assertDatabaseHas('enrollments', [
            'user_id' => $student->id,
            'course_id' => $course->id,
            'status' => 'active'
        ]);
    }

    /**
     * Test student cannot enroll in a course twice.
     */
    public function test_student_cannot_enroll_in_course_twice(): void
    {
        // Create a student
        $student = User::factory()->create(['role' => 'student']);

        // Create a course
        $course = Course::factory()->create();

        // Create an existing enrollment
        Enrollment::factory()->create([
            'user_id' => $student->id,
            'course_id' => $course->id,
            'status' => 'active'
        ]);

        // Authenticate as the student
        $this->actingAs($student);

        // Try to enroll again
        $response = $this->post(route('courses.enroll', $course));

        // Assert the user is redirected to the course page
        $response->assertRedirect(route('student.courses.show', $course));

        // Assert there's still only one enrollment
        $this->assertDatabaseCount('enrollments', 1);
    }

    /**
     * Test course search functionality.
     */
    public function test_course_search_functionality(): void
    {
        // Create courses with different titles
        $course1 = Course::factory()->create(['title' => 'PHP Programming', 'status' => 'active']);
        $course2 = Course::factory()->create(['title' => 'JavaScript Basics', 'status' => 'active']);
        $course3 = Course::factory()->create(['title' => 'Advanced PHP', 'status' => 'active']);

        // Search for PHP courses
        $response = $this->get(route('courses.index', ['search' => 'PHP']));

        // Assert the response is successful
        $response->assertStatus(200);

        // Assert PHP courses are displayed
        $response->assertSee($course1->title);
        $response->assertSee($course3->title);

        // Assert JavaScript course is not displayed
        $response->assertDontSee($course2->title);
    }

    /**
     * Test course filter by status.
     */
    public function test_course_filter_by_status(): void
    {
        // Create courses with different statuses
        $activeCourse = Course::factory()->create(['status' => 'active']);
        $upcomingCourse = Course::factory()->create(['status' => 'upcoming']);
        $completedCourse = Course::factory()->create(['status' => 'completed']);

        // Filter by active status
        $response = $this->get(route('courses.index', ['status' => 'active']));

        // Assert the response is successful
        $response->assertStatus(200);

        // Assert active course is displayed
        $response->assertSee($activeCourse->title);

        // Assert other courses are not displayed
        $response->assertDontSee($upcomingCourse->title);
        $response->assertDontSee($completedCourse->title);
    }
}
