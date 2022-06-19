<?php

namespace Database\Seeders;

use App\Models\Bug;
use App\Models\Comment;
use App\Models\File;
use App\Models\Milestone;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Faker\Factory AS Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Truncate all Tables
        Schema::disableForeignKeyConstraints();
        Bug::truncate();
        File::truncate();
        Comment::truncate();
        Milestone::truncate();
        Project::truncate();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        //Seed Database with Faker
        $faker = Faker::create();

        $settings = (object) [
            'usersAmount' => 7,
            'projectsAmount' => 3,
        ];

        //Seeds Users, Projects and Milestones
        User::factory(1)->create([
            'timezone' => 'Europe/Berlin',
            'name' => 'demo',
            'email' => 'demo@bugtrax.de',
            'email_verified_at' => $faker->dateTimeBetween('-1 month', 'now'),
            'password' => Hash::make('demo1234'),
        ]);
        $users = User::factory($settings->usersAmount)->create();
        $projects = Project::factory($settings->projectsAmount)->create();
        $milestones_0 = Milestone::factory(2)->create(['project_id' => $projects[0]]);
        $milestones_1 = Milestone::factory(4)->create(['project_id' => $projects[1]]);
        $milestones_2 = Milestone::factory(3)->create(['project_id' => $projects[2]]);
        $milestones = $milestones_0->merge($milestones_1)->merge($milestones_2);

        //Seed Bugs
        $bugs = collect();
        foreach ($milestones AS $milestone) {
            $rounds = $faker->numberBetween(5, 8);
            for ($i = 0; $i < $rounds; $i++) {
                $bugs->add(Bug::factory(1)->create([
                    'project_id' => $milestone->project_id,
                    'milestone_id' => $milestone,
                    'assigned_to' => $users[$faker->numberBetween(0, $settings->usersAmount - 1)],
                    'created_by' => $users[$faker->numberBetween(0, $settings->usersAmount - 1)],
                    'created_at' => $faker->dateTimeBetween(
                        $milestone->created_at, 
                        $milestone->start_date
                    ),
                    'end_date' => $milestone->end_date,
                ])[0]);
            }
        }

        //Seed Comments
        foreach ($bugs AS $bug) {
            $rounds = $faker->numberBetween(0, 4);
            for ($i = 0; $i < $rounds; $i++) {
                Comment::factory(1)->create([
                    'user_id' => $users[$faker->numberBetween(0, $settings->usersAmount - 1)],
                    'bug_id' => $bug,
                    'created_at' => $faker->dateTimeBetween($bug->created_at, 'now'),
                ]);
            }
        }
        foreach ($milestones AS $milestone) {
            $rounds = $faker->numberBetween(0, 3);
            for ($i = 0; $i < $rounds; $i++) {
                Comment::factory(1)->create([
                    'user_id' => $users[$faker->numberBetween(0, $settings->usersAmount - 1)],
                    'milestone_id' => $milestone,
                    'created_at' => $faker->dateTimeBetween($milestone->created_at, 'now'),
                ]);
            }
        }
        foreach ($projects AS $project) {
            $rounds = $faker->numberBetween(0, 2);
            for ($i = 0; $i < $rounds; $i++) {
                Comment::factory(1)->create([
                    'user_id' => $users[$faker->numberBetween(0, $settings->usersAmount - 1)],
                    'project_id' => $project,
                    'created_at' => $faker->dateTimeBetween($project->created_at, 'now'),
                ]);
            }
        }
    
    }
}
