<?php

namespace Database\Factories;

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuizResult>
 */
class QuizResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $score = $this->faker->numberBetween(0, 100);

        return [
            'user_id' => User::factory()->create(['role' => 'student'])->id,
            'quiz_id' => Quiz::factory(),
            'score' => $score,
            'passed' => $score >= 60,
            'points_earned' => $this->faker->randomFloat(1, 0, 10),
            'points_possible' => 10,
            'time_spent' => $this->faker->numberBetween(60, 3600),
            'status' => 'completed',
            'started_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'completed_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
