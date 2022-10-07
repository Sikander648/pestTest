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

    $response = $this->postJson('/api/register-user', $user);

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

test('test senctum', function () {
    Sanctum::actingAs(
        User::factory()->create(),
        ['view-tasks']
    );
    $this->getJson('/api/task')
        ->assertOk();
});


    test('a user can view a project', function () {
        Sanctum::actingAs(
            User::factory()->create(),
            ['view-tasks']
        );
        $response = $this->get('/api/show-project/1');
        $response->assertStatus(Response::HTTP_OK);

    });

    test('a user can create a project', function () {
        Sanctum::actingAs(
            User::factory()->create(),
            ['view-tasks']
        );
        $response = $this->postJson('/api/create-project', ['title' => 'Sally', 'description' => 'description', 'owner_id' => 1]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'title' => 'Sally',
                'description' => 'description',
                'owner_id' => 1,
            ]);

    });


    test('a user can create a project test with headers', function () {
        $response = $this->withHeaders([
            'XSRF-TOKEN' => 'eyJpdiI6InpxK3RPaGhCQURZUFdqYjRNVk5qbGc9PSIsInZhbHVlIjoiUE5uZWExaER6T2t6bFFRMkhJeU9EdEhZSlFKTlh1NzZOcnp1bEtuTWtRUW8rc2laaFV4WnRFY1R6bloyM3hwMVBidHIwMCtkaHRCVVFMbnNhTG1UcUEzZ0FRdXM4VGRiOEJpQWZsa2lFeW1zWGJMRjNpc3NPVEdibXBJUFFnVXYiLCJtYWMiOiIzMmJiY2Y3YTNjYmFmNGE4OTE1MmY5N2ViMTc3NTE1MThjMDIxM2Y5ODgzMzFjNzFlMzJkNWUzYzM2NWU0ZmRhIiwidGFnIjoiIn0%3D;',
        ])->post('/api/create-project', [
            'title' => 'Sally',
            'description' => 'description',
            'owner_id' => 1,
        ]);

        $response->assertStatus(201);
    });

    it('can test data types', function () {
        $this->withOutExceptionHandling();
        Sanctum::actingAs(
            User::factory()->create(),
            ['view-tasks']
        );
        $project = Project::factory()->create();
        $response = $this->postJson('/api/create-project', ['title' => $project->title, 'description' => $project->description, 'owner_id' => $project->owner_id]);
        $response->assertJson(fn(AssertableJson $json) => $json->whereAllType([
            'title' => 'string',
            'owner_id' => 'integer',
            'description' => 'string'
        ]));
    });



