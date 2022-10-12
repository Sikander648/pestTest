<?php

use Illuminate\Support\Facades\Route;

//\App\Models\Project::created(function ($project){
//    \App\Models\Activity::create([
//        'project_id' => $project->id,
//        'description' => $project->description
//    ]);
//});

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
