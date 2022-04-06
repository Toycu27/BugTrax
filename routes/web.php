<?php

use App\Http\Controllers\BugsController;
use App\Http\Controllers\MilestonesController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Project;
use App\Models\Milestone;
use App\Models\Bug;
//use App\Models\File;
//use App\Models\Comment;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


//User Routes
Route::get('users', [UsersController::class, 'getUsers']);
Route::get('user/{user}', [UsersController::class, 'getUser']);


//Project Routes
Route::get('projects', [ProjectsController::class, 'getProjects']);
Route::get('project/{project}', [ProjectsController::class, 'getProject']);
Route::post('project', [ProjectsController::class, 'postProject']);
Route::patch('project/{project}', [ProjectsController::class, 'patchProject']);
Route::delete('project/{project}', [ProjectsController::class, 'deleteProject']);

//Milestone Routes
Route::get('milestones', [MilestonesController::class, 'getMilestones']);
Route::get('milestone/{milestone:slug}', [MilestonesController::class, 'getMilestone']);


//Bug Routes
Route::get('bugs', [BugsController::class, 'getBugs']);
Route::get('bug/{bug}', [BugsController::class, 'getBug']);