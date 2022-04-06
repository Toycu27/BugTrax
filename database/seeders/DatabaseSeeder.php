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
        User::truncate();
        Project::truncate();
        Milestone::truncate();
        Bug::truncate();
        Comment::truncate();
        File::truncate();

        //Seed Database with Faker
        User::factory(3)->create();
        Project::factory(1)->create();
        Milestone::factory(2)->create();
        Bug::factory(5)->create();
        Comment::factory(10)->create();

        //Seed Database without Faker
        $user = User::Create([
            'name' => 'Toycu',
            'email' => 'somerandom@emailclient.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => '1234567890',
        ]);

        $project = Project::Create([
            'title' => 'BugTrax',
            'slug' => 'bugtrax',
            'desc' => 'Bug Tracking Web Application',
        ]);

        $milestone = Milestone::Create([
            'project_id' => $project->id,
            'title' => 'Alpha Release',
            'slug' => 'alpha_release',
        ]);

        $bug = Bug::Create([
            'project_id' => $project->id,
            'milestone_id' => $milestone->id,
            'created_by' => 1,
            'title' => 'My first Bug',
            'slug' => 'my_first_bug',
            'desc' => 'Bug description',
        ]);

        Comment::Create([
            'user_id' => $user->id,
            'bug_id' => $bug->id,
            'message' => 'My First Comment',
        ]);
    }
}
