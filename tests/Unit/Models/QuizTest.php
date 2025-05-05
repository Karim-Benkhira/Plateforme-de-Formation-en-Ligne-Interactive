<?php

namespace Tests\Unit\Models;

use App\Models\Lesson;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuizTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test quiz belongs to a lesson.
     */
    public function test_quiz_belongs_to_lesson(): void
    {
        $lesson = Lesson::factory()->create();
        $quiz = Quiz::factory()->create(['lesson_id' => $lesson->id]);

        $this->assertInstanceOf(Lesson::class, $quiz->lesson);
        $this->assertEquals($lesson->id, $quiz->lesson->id);
    }

    /**
     * Test quiz has many questions.
     */
    public function test_quiz_has_many_questions(): void
    {
        $quiz = Quiz::factory()->create();
        $questions = Question::factory()->count(3)->create(['quiz_id' => $quiz->id]);

        $this->assertCount(3, $quiz->questions);
        $this->assertInstanceOf(Question::class, $quiz->questions->first());
    }

    /**
     * Test quiz has many results.
     */
    public function test_quiz_has_many_results(): void
    {
        $quiz = Quiz::factory()->create();
        $students = User::factory()->count(3)->create(['role' => 'student']);

        foreach ($students as $student) {
            QuizResult::factory()->create([
                'user_id' => $student->id,
                'quiz_id' => $quiz->id
            ]);
        }

        $this->assertCount(3, $quiz->results);
        $this->assertInstanceOf(QuizResult::class, $quiz->results->first());
    }

    /**
     * Test quiz duration attribute.
     */
    public function test_quiz_duration_attribute(): void
    {
        $quiz = Quiz::factory()->create(['duration' => 30]);
        $this->assertEquals(30, $quiz->duration);

        $quiz->duration = 45;
        $quiz->save();

        $this->assertEquals(45, $quiz->fresh()->duration);
    }

    /**
     * Test quiz type attribute.
     */
    public function test_quiz_type_attribute(): void
    {
        $quiz = Quiz::factory()->create(['type' => 'practice']);
        $this->assertEquals('practice', $quiz->type);

        $quiz->type = 'exam';
        $quiz->save();

        $this->assertEquals('exam', $quiz->fresh()->type);
    }

    /**
     * Test quiz status attribute.
     */
    public function test_quiz_status_attribute(): void
    {
        $quiz = Quiz::factory()->create(['status' => 'closed']);
        $this->assertEquals('closed', $quiz->status);

        $quiz->status = 'open';
        $quiz->save();

        $this->assertEquals('open', $quiz->fresh()->status);
    }

    /**
     * Test quiz total points calculation.
     */
    public function test_quiz_total_points_calculation(): void
    {
        $quiz = Quiz::factory()->create();

        // Create questions with different point values
        Question::factory()->create(['quiz_id' => $quiz->id, 'points' => 1.0]);
        Question::factory()->create(['quiz_id' => $quiz->id, 'points' => 2.0]);
        Question::factory()->create(['quiz_id' => $quiz->id, 'points' => 3.0]);

        // Total points should be 6.0
        $this->assertEquals(6.0, $quiz->getTotalPointsAttribute());
    }
}
