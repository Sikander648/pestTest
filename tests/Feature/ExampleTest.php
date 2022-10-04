<?php

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);



test('a user can view a project', function () {
    Project::factory()->create([
        'title' => 'title',
        'description' => 'description'
    ]);
});

test('a project requires a description', function () {
    $project = Project::latest()->first();
    expect($project->description)->not->toBeEmpty();
});

test('a project requires a title', function () {

    $project = Project::latest()->first();
    expect($project->description)->not->toBeEmpty();

});

test('a user can create a project', function () {
    $project = Project::factory()->create();
    $response = $this->getJson(route('projects.show', $project->uuid));
    $response->assertStatus(Response::HTTP_OK);
});

test('a user can delete a project', function () {
    $project = Project::factory()->create();
    $response = $this->deleteJson(route('projects.destroy', $project->uuid));
    $response->assertStatus(Response::HTTP_OK)
        ->assertJson(['message' => 'The project is deleted successfully.']);
});

test('a project has an owner', function () {
    $project = Project::latest()->first();
    expect($project->owner_id)->not->toBeEmpty();
});

test('a project has an owner', function () {
    $project = Project::latest()->first();
    expect($project->owner_id)->not->toBeEmpty();
});

test('scope user projects', function () {
    $user = Auth::user()->id;
    $response = $this->getJson(route('projects.showProjects', $user->uuid));
    $response->assertStatus(Response::HTTP_OK);
});

