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
        User::truncate();
        Comment::truncate();

        User::factory(3)->create();

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
            'user_id' => 1,
            'bug_id' => $bug->id,
            'message' => 'My First Comment',
        ]);
    }
}
