<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->boolean(70) ? fake()->paragraph() : null,
            'status' => fake()->randomElement(['todo', 'in-progress', 'done']),
        ];
    }

    public function todo(): static
    {
        return $this->state(['status' => 'todo']);
    }

    public function inProgress(): static
    {
        return $this->state(['status' => 'in-progress']);
    }

    public function done(): static
    {
        return $this->state(['status' => 'done']);
    }
}
