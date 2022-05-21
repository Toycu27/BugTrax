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
        $status = ['New', 'Progress', 'Freeze', 'Testing', 'Solved'];
        $priority = ['Immediate','High','Normal','Low'];
        $difficulty = ['Easy','Normal','Hard','Unknown'];
        $device_type = ['Desktop','Tablet','Mobile'];
        $device_os = ['Windows','Mac','Linux'];

        return [
            'project_id' => Project::factory(),
            'milestone_id' => Milestone::factory(),
            'created_by' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'desc' => $this->faker->paragraph(),
            'status' => $status[$this->faker->numberBetween(0, 4)],
            'priority' => $priority[$this->faker->numberBetween(0, 3)],
            'difficulty' => $difficulty[$this->faker->numberBetween(0, 3)],
            'device_type' => $device_type[$this->faker->numberBetween(0, 2)],
            'device_os' => $device_os[$this->faker->numberBetween(0, 2)],
        ];
    }
}
