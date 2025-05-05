<?php

namespace Database\Factories;

use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $contentType = $this->faker->randomElement(['text', 'video', 'file']);

        return [
            'title' => $this->faker->sentence(4),
            'module_id' => Module::factory(),
            'content_type' => $contentType,
            'content' => $contentType === 'text' ? $this->faker->paragraphs(3, true) : null,
            'content_url' => $contentType !== 'text' ? $this->faker->url : null,
            'order' => $this->faker->numberBetween(0, 10),
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
