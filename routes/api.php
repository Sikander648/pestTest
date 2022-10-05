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
