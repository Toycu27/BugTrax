<?php

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

Route::get('user/{user}', function (User $user) {
    return $user;
});

Route::get('project/{project}', function (Project $project) {
    return $project;
});

Route::get('milestone/{milestone:slug}', function (Milestone $milestone) {
    return $milestone;
});

Route::get('bug/{bug}', function (Bug $bug) {
    return $project;
});