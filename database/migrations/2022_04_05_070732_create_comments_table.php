<?php

use App\Models\Bug;
use App\Models\Milestone;
use App\Models\Project;
use App\Models\User;
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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Bug::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Milestone::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Project::class)->nullable()->constrained()->cascadeOnDelete();
            $table->text('message');
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
        Schema::dropIfExists('comments');
    }
};
