<?php

namespace Database\Factories;

use App\Models\Option;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentAnswer>
 */
class StudentAnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $question = Question::factory()->create();
        $option = Option::factory()->create([
            'question_id' => $question->id,
            'is_correct' => $this->faker->boolean(50)
        ]);

        return [
            'user_id' => User::factory()->create(['role' => 'student'])->id,
            'question_id' => $question->id,
            'option_id' => $question->type !== 'short_answer' ? $option->id : null,
            'text_answer' => $question->type === 'short_answer' ? $this->faker->sentence() : null,
            'is_correct' => $option->is_correct,
            'points_earned' => function (array $attributes) use ($question, $option) {
                return $attributes['is_correct'] ? $question->points : 0;
            },
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
