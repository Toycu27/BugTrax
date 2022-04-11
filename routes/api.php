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
Route::middleware('auth')->group(function () {
    //User Routes
    Route::resource('users', UserController::class)
        ->only('index', 'show');

    //Project Routes
    Route::resource('projects', ProjectController::class)
        ->only('index', 'show', 'store', 'update', 'delete');

    //Milestone Routes
    Route::resource('milestones', MilestoneController::class)
        ->only('index', 'show', 'store', 'update', 'delete');

    //Bug Routes
    Route::resource('bugs', BugController::class)
        ->only('index', 'show', 'store', 'update', 'delete');

    //Comment Routes
    Route::resource('comments', CommentController::class)
        ->only('store', 'update', 'delete');
});