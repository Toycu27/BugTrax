<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Project;
use App\Models\Milestone;
use App\Models\User;

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
            $table->foreignIdFor(Project::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Milestone::class)->nullable();
            $table->foreignIdFor(User::class, 'created_by');
            $table->foreignId('modified_by')->nullable();
            $table->foreignId('assigned_to')->nullable();
            $table->boolean('published')->default(0);
            $table->enum('status', ['New', 'Progress', 'Freeze', 'Testet', 'Solved'])->default('New');
            $table->enum('priority', ['Immediate', 'High', 'Normal', 'Low']);
            $table->tinyInteger('progress')->default(0);
            $table->tinyInteger('estimated_hours')->nullable();
            $table->tinyInteger('actual_hours')->nullable();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('desc');
            $table->text('reproduce_desc')->nullable();
            $table->text('solution_desc')->nullable();
            $table->string('url')->nullable();
            $table->set('device_type', ['Desktop', 'Tablet', 'Mobile'])->nullable();
            $table->set('device_os', ['Windows', 'Mac', 'Linux'])->nullable();
            $table->string('browser_info')->nullable();
            $table->json('tags')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
