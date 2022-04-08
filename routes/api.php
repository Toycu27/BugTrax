<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BugController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//User Routes
Route::get('users', [UserController::class, 'index']);
Route::get('users/{user}', [UserController::class, 'show']);

//Project Routes
Route::get('projects', [ProjectController::class, 'index']);
Route::get('projects/{project}', [ProjectController::class, 'show']);
Route::post('projects', [ProjectController::class, 'store']);
Route::patch('projects/{project}', [ProjectController::class, 'update']);
Route::delete('projects/{project}', [ProjectController::class, 'delete']);

//Milestone Routes
Route::get('milestones', [MilestoneController::class, 'index']);
Route::get('milestones/{milestone}', [MilestoneController::class, 'show']);
Route::post('milestones', [MilestoneController::class, 'store']);
Route::patch('milestones/{milestone}', [MilestoneController::class, 'update']);
Route::delete('milestones/{milestone}', [MilestoneController::class, 'delete']);

//Bug Routes
Route::get('bugs', [BugController::class, 'index']);
Route::get('bugs/{bug}', [BugController::class, 'show']);
Route::post('bugs', [BugController::class, 'store']);
Route::patch('bugs/{bug}', [BugController::class, 'update']);
Route::delete('bugs/{bug}', [BugController::class, 'delete']);

//Comment Routes
Route::post('comments', [CommentController::class, 'store']);
Route::patch('comments/{comment}', [BugController::class, 'update']);
Route::delete('comments/{comment}', [BugController::class, 'delete']);