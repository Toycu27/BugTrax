<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Project;
use App\Models\Milestone;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bugs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Project::Class);
            $table->foreignIdFor(Milestone::Class);
            $table->foreignId('created_by');
            $table->foreignId('modified_by');
            $table->foreignId('assigned_to');
            $table->boolean('published');
            $table->enum('status', ['New', 'Progress', 'Freeze', 'Testet', 'Solved']);
            $table->enum('priority', ['Immediate', 'High', 'Normal', 'Low']);
            $table->tinyInteger('progress');
            $table->tinyInteger('estimated_hours');
            $table->tinyInteger('actual_hours');
            $table->string('title');
            $table->text('desc');
            $table->string('url');
            $table->set('device', ['Desktop', 'Tablet', 'Mobile']);
            $table->set('os', ['Windows', 'Mac', 'Linux']);
            $table->string('browser');
            $table->string('browser_version');
            $table->json('tags');
            $table->enum('reproducible', ['Yes', 'No', 'Depends']);
            $table->text('reproduce_desc');
            $table->text('solution_desc');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bugs');
    }
};
