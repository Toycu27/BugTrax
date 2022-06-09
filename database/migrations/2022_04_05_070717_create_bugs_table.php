<?php

use App\Models\Milestone;
use App\Models\Project;
use App\Models\User;
use App\Models\Status;
use App\Models\Difficulty;
use App\Models\Priority;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->foreignIdFor(Status::class)->nullable();
            $table->foreignIdFor(Priority::class)->nullable();
            $table->foreignIdFor(Difficulty::class)->nullable();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('desc');
            $table->text('solution_desc')->nullable();
            $table->string('url')->nullable();
            $table->set('device_type', ['Desktop', 'Tablet', 'Mobile'])->nullable();
            $table->set('device_os', ['Windows', 'Mac', 'Linux'])->nullable();
            $table->string('browser_info')->nullable();
            $table->json('tags')->nullable();
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
