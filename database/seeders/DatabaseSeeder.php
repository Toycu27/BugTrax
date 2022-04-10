<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use App\Models\Milestone;
use App\Models\Bug;
use App\Models\File;
use App\Models\Comment;
use Illuminate\Support\Facades\Schema;

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
        $users = User::factory(3)->create();
        $projects = Project::factory(2)->create();
        $milestones_a = Milestone::factory(2)->create(['project_id' => $projects[0]]);
        $milestones_b = Milestone::factory(2)->create(['project_id' => $projects[1]]);
        $bugs_a = Bug::factory(5)->create([
            'project_id' => $projects[0], 
            'milestone_id' => $milestones_a[0], 
            'created_by' => $users[0]
        ]);
        $bugs_b = Bug::factory(5)->create([
            'project_id' => $projects[1], 
            'milestone_id' => $milestones_b[0], 
            'created_by' => $users[1]
        ]);
        Comment::factory(5)->create([
            'user_id' => $users[0], 
            'bug_id' => $bugs_a[0]
        ]);
        Comment::factory(5)->create([
            'user_id' => $users[1], 
            'bug_id' => $bugs_b[0]
        ]);
    }
}
