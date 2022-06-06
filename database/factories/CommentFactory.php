<?php

namespace Database\Factories;

use App\Models\Bug;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'bug_id' => null,
            'milestone_id' => null,
            'project_id' => null,
            'message' => $this->faker->paragraph($this->faker->numberBetween(1, 3)),
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
