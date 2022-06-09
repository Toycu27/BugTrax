<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Milestone>
 */
class MilestoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = $this->faker->sentence(4);
        $startDate = $this->faker->dateTimeBetween('-1 week', 'now');
        $endDate = (clone $startDate)->modify('+1 week');
        $createdAt = (clone $startDate)->modify('-1 week');

        return [
            'project_id' => Project::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'desc' => $this->faker->paragraph(2),
            'created_at' => $createdAt,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
    }
}
