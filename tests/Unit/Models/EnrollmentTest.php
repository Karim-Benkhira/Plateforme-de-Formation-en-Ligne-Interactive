<?php

namespace Tests\Unit\Models;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnrollmentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test enrollment belongs to a user.
     */
    public function test_enrollment_belongs_to_user(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create();
        $enrollment = Enrollment::factory()->create([
            'user_id' => $student->id,
            'course_id' => $course->id
        ]);

        $this->assertInstanceOf(User::class, $enrollment->user);
        $this->assertEquals($student->id, $enrollment->user->id);
    }

    /**
     * Test enrollment belongs to a course.
     */
    public function test_enrollment_belongs_to_course(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create();
        $enrollment = Enrollment::factory()->create([
            'user_id' => $student->id,
            'course_id' => $course->id
        ]);

        $this->assertInstanceOf(Course::class, $enrollment->course);
        $this->assertEquals($course->id, $enrollment->course->id);
    }

    /**
     * Test enrollment has last accessed lesson relationship.
     */
    public function test_enrollment_belongs_to_last_accessed_lesson(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create();
        $module = Module::factory()->create(['course_id' => $course->id]);
        $lesson = Lesson::factory()->create(['module_id' => $module->id]);

        $enrollment = Enrollment::factory()->create([
            'user_id' => $student->id,
            'course_id' => $course->id,
            'last_accessed_lesson_id' => $lesson->id
        ]);

        $this->assertInstanceOf(Lesson::class, $enrollment->lastAccessedLesson);
        $this->assertEquals($lesson->id, $enrollment->lastAccessedLesson->id);
    }

    /**
     * Test enrollment progress calculation.
     */
    public function test_enrollment_progress_calculation(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create();

        $enrollment = Enrollment::factory()->create([
            'user_id' => $student->id,
            'course_id' => $course->id,
            'progress' => 50
        ]);

        $this->assertEquals(50, $enrollment->progress);

        $enrollment->progress = 75;
        $enrollment->save();

        $this->assertEquals(75, $enrollment->fresh()->progress);
    }

    /**
     * Test enrollment status attribute.
     */
    public function test_enrollment_status_attribute(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create();

        $enrollment = Enrollment::factory()->create([
            'user_id' => $student->id,
            'course_id' => $course->id,
            'status' => 'active'
        ]);

        $this->assertEquals('active', $enrollment->status);

        $enrollment->status = 'completed';
        $enrollment->completed_at = now();
        $enrollment->save();

        $this->assertEquals('completed', $enrollment->fresh()->status);
        $this->assertNotNull($enrollment->fresh()->completed_at);
    }
}
