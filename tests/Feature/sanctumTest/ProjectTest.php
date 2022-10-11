<?php

    namespace Tests\Feature\sanctumTest;

    use App\Models\Project;
    use App\Models\User;
    use Illuminate\Http\Response;
    use Laravel\Sanctum\Sanctum;

    test('a user can view a project', function () {
        (new loginAsSanctumUser())->loginWithSanctum();
        $response = $this->get('/api/show-project/1');
        $response->assertStatus(Response::HTTP_OK);

    });

    test('a project requires a title', function () {
        (new loginAsSanctumUser())->loginWithSanctum();
        $attributes = Project::factory()->raw(['title' => '']);
        $response = $this->postJson(route('projects.store'), $attributes);
        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson(['message' => 'The title is required.']);
    });

    test('a project requires a description', function () {
        (new loginAsSanctumUser())->loginWithSanctum();
        $attributes = Project::factory()->raw(['description' => '']);
        $response = $this->postJson(route('projects.store'), $attributes);
        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson(['message' => 'The description is required.']);
    });

    test('a user can create a project', function () {
        (new loginAsSanctumUser())->loginWithSanctum();
        $project = Project::factory()->create();
        $response = $this->postJson('/api/create-project',
            ['title' => $project->title,
                'description' => $project->description,
                'owner_id' => $project->owner_id]
        );

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['title' => $project->title,
                'description' => $project->description,
                'owner_id' => $project->owner_id]);

    });

    test('a user can create a project test with headers', function () {
        $response = $this->withHeaders([
            'XSRF-TOKEN' => 'eyJpdiI6InpxK3RPaGhCQURZUFdqYjRNVk5qbGc9PSIsInZhbHVlIjoiUE5uZWExaER6T2t6bFFRMkhJeU9EdEhZSlFKTlh1NzZOcnp1bEtuTWtRUW8rc2laaFV4WnRFY1R6bloyM3hwMVBidHIwMCtkaHRCVVFMbnNhTG1UcUEzZ0FRdXM4VGRiOEJpQWZsa2lFeW1zWGJMRjNpc3NPVEdibXBJUFFnVXYiLCJtYWMiOiIzMmJiY2Y3YTNjYmFmNGE4OTE1MmY5N2ViMTc3NTE1MThjMDIxM2Y5ODgzMzFjNzFlMzJkNWUzYzM2NWU0ZmRhIiwidGFnIjoiIn0%3D;',
        ])->post('/api/create-project', [
            'title' => 'Sally',
            'description' => 'description',
            'owner_id' => 1,
        ]);

        $response->assertStatus(Response::HTTP_OK);
    });

    test('a user can delete a project', function () {
        (new loginAsSanctumUser())->loginWithSanctum();
        $project = Project::factory()->create(['owner_id' => $user->id]);
        $response = $this->deleteJson(route('projects.destroy', $project->uuid));
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'The project is deleted successfully.']);
    });
