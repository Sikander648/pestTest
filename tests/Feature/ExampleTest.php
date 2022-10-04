<?php

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
    if(! is_string($project->description)){
        throw new Exception('The test failed');
    }
});

test('a project requires a title', function () {

    $project = Project::latest()->first();
    if (!is_string($project->title)) {
        throw new Exception('The test failed');
    }

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
    $project = Project::factory()->create();
    $response = $this->deleteJson(route('projects.destroy', $project->uuid));
    $response->assertStatus(Response::HTTP_OK)
        ->assertJson(['message' => 'The project is deleted successfully.']);
});
