<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BugController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;


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
Route::get('users', [UserController::class, 'getUsers']);
Route::get('user/{user}', [UserController::class, 'getUser']);


//Project Routes
Route::get('projects', [ProjectController::class, 'getProjects']);
Route::get('project/{project}', [ProjectController::class, 'getProject']);
Route::post('project', [ProjectController::class, 'postProject']);
Route::patch('project/{project}', [ProjectController::class, 'patchProject']);
Route::delete('project/{project}', [ProjectController::class, 'deleteProject']);

//Milestone Routes
Route::get('milestones', [MilestoneController::class, 'getMilestones']);
Route::get('milestone/{milestone:slug}', [MilestoneController::class, 'getMilestone']);


//Bug Routes
Route::get('bugs', [BugController::class, 'getBugs']);
Route::get('bug/{bug}', [BugController::class, 'getBug']);