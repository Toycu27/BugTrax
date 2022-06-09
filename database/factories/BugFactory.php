<?php

namespace Database\Factories;

use App\Models\Milestone;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bug>
 */
class BugFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = $this->faker->sentence();
        $device_type = ['Desktop', 'Tablet', 'Mobile'];
        $device_os = ['Windows', 'Mac', 'Linux'];

        return [
            'project_id' => Project::factory(),
            'milestone_id' => Milestone::factory(),
            'created_by' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'desc' => $this->faker->paragraph(),
            'status_id' => $this->faker->numberBetween(1, 4),
            'priority_id' => $this->faker->numberBetween(1, 3),
            'difficulty_id' => $this->faker->numberBetween(1, 3),
            'device_type' => $device_type[$this->faker->numberBetween(0, 2)],
            'device_os' => $device_os[$this->faker->numberBetween(0, 2)],
        ];
    }
}
