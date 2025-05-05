<?php

namespace Tests\Unit\Models;

use App\Models\Course;
use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test course has a teacher relationship.
     */
    public function test_course_belongs_to_teacher(): void
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $course = Course::factory()->create(['teacher_id' => $teacher->id]);

        $this->assertInstanceOf(User::class, $course->teacher);
        $this->assertEquals($teacher->id, $course->teacher->id);
    }

    /**
     * Test course has modules relationship.
     */
    public function test_course_has_many_modules(): void
    {
        $course = Course::factory()->create();
        $modules = Module::factory()->count(3)->create(['course_id' => $course->id]);

        $this->assertCount(3, $course->modules);
        $this->assertInstanceOf(Module::class, $course->modules->first());
    }

    /**
     * Test course has enrollments relationship.
     */
    public function test_course_has_many_enrollments(): void
    {
        $course = Course::factory()->create();
        $students = User::factory()->count(3)->create(['role' => 'student']);

        foreach ($students as $student) {
            $course->enrollments()->create([
                'user_id' => $student->id,
                'status' => 'active',
                'progress' => 0,
                'enrolled_at' => now()
            ]);
        }

        $this->assertCount(3, $course->enrollments);
        $this->assertEquals($students[0]->id, $course->enrollments->first()->user_id);
    }

    /**
     * Test course status attribute.
     */
    public function test_course_status_attribute(): void
    {
        $course = Course::factory()->create(['status' => 'active']);
        $this->assertEquals('active', $course->status);

        $course->status = 'completed';
        $course->save();
        $this->assertEquals('completed', $course->fresh()->status);
    }
}
