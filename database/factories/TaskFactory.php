<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'title' => ucfirst(fake()->words(fake()->numberBetween(2, 5), true)),
            'is_done' => fake()->boolean(),
            'due_date' => fake()->boolean(70)
                ? fake()->dateTimeBetween('today', '+30 days')->format('Y-m-d')
                : null,
        ];
    }
}
