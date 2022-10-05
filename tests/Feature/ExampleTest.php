<?php

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Testing\AssertableInertia as Assert;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);


test('a user can make a project', function () {
    Project::factory()->create([
        'title' => 'title',
        'description' => 'description',
        'owner_id' => 1
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
    $project = Project::factory()->create([
        'title' => 'title',
        'description' => 'description',
        'owner_id' => 1
    ]);
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


test('scope user projects', function () {
    $user = Auth::user()->id;
    $response = $this->getJson(route('projects.showProjects', $user->uuid));
    $response->assertStatus(Response::HTTP_OK);
});


// test sanctum

test('sanctum-csrf-cookie', function () {

    $this->get('/sanctum/csrf-cookie');

});

test('register a user', function () {
    $user = User::factory()->create();

    $response = $this->postJson('/api/register-user',$user);

    $response->assertDatabaseHas('user', $user);
});

test('login a user', function () {
    $user = User::factory()->create();

    $response = $this->postJson('/api/login-test', ['email' => $user->email, 'password' => $user->password]);
    $response->assertStatus(201)->assertJson(['message' => 'User is Loged In']);
});

test('test senctum', function () {
    Sanctum::actingAs(
        User::factory()->create(),
        ['view-tasks']
    );

    $response = $this->get('/api/task');
    $response->assertOk();
});


