<?php

use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;

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

    Route::post('/logout', [LoginController::class, 'logout']);
    Route::post('/get-projects', [ProjectController::class, 'getAllProducts']);
    Route::post('/create-task', [TasksController::class, 'createTask']);
    Route::post('/update-task', [TasksController::class, 'updateTask']);
    Route::post('/delete-task', [TasksController::class, 'deleteTask']);
    Route::post('/tasks-listing', [TasksController::class, 'listAllTasks']);
    Route::post('/project-tasks', [TasksController::class, 'projectTasks']);

// $router->group(['middleware' => 'auth:api', 'auth'], function () use ($router) {
// });
