<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ProjectsController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('projects', ProjectsController::class)->except('edit');

Route::post('/register-user', [LoginController::class, 'registerUser']);
Route::post('/login-test', [LoginController::class, 'authenticate']);

Route::middleware('auth:sanctum')->get('/task', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/show-project/{id?}', function (Request $request) {
    return Project::find($request->id);
});

Route::middleware('auth:sanctum')->post('/create-project/', [ProjectsController::class, 'createProject']);
Route::post('/avatar/store', [ProjectsController::class, 'uploadFiles'])->middleware('auth:sanctum');
Route::post('/add-task/', [ProjectsController::class, 'addTask'])->middleware('auth:sanctum');

Route::put('/update-project/{user_id}/{project_id}', [ProjectsController::class, 'updateProject'])->middleware('auth:sanctum');
Route::put('/create-activity/{project_id}', [ProjectsController::class, 'createActivity'])->middleware('auth:sanctum');
Route::put('/update-activity/{project_id}', [ProjectsController::class, 'updateActivity'])->middleware('auth:sanctum');

Route::post('/creating-a-project-task-records-activity', [ProjectsController::class, 'creatingATaskRecordsActivity'])->middleware('auth:sanctum');



