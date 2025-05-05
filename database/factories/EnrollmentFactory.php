<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enrollment>
 */
class EnrollmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create(['role' => 'student'])->id,
            'course_id' => Course::factory(),
            'status' => $this->faker->randomElement(['active', 'completed', 'dropped']),
            'progress' => $this->faker->numberBetween(0, 100),
            'last_accessed_lesson_id' => null,
            'last_accessed_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'enrolled_at' => $this->faker->dateTimeBetween('-6 months', '-1 month'),
            'completed_at' => function (array $attributes) {
                return $attributes['status'] === 'completed' ? $this->faker->dateTimeBetween('-1 month', 'now') : null;
            },
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
