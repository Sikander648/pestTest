<?php
//
//namespace Tests\Feature\sanctumTest;
//
//
//use App\Models\Project;
//use Illuminate\Http\Response;
//use Illuminate\Http\UploadedFile;
//use Illuminate\Support\Facades\Storage;
//
//test('a user can view a project', function () {
//        (new loginAsSanctumUser())->loginWithSanctum();
//        $response = $this->get('/api/show-project/1');
//        $response->assertStatus(Response::HTTP_OK);
//
//    });
//
//    test('a project requires a title', function () {
//        (new loginAsSanctumUser())->loginWithSanctum();
//        $attributes = Project::factory()->raw(['title' => '']);
//        $response = $this->postJson(route('projects.store'), $attributes);
//        $response->assertStatus(Response::HTTP_BAD_REQUEST)
//            ->assertJson(['message' => 'The title is required.']);
//    });
//
//    test('a project requires a description', function () {
//        (new loginAsSanctumUser())->loginWithSanctum();
//        $attributes = Project::factory()->raw(['description' => '']);
//        $response = $this->postJson(route('projects.store'), $attributes);
//        $response->assertStatus(Response::HTTP_BAD_REQUEST)
//            ->assertJson(['message' => 'The description is required.']);
//    });
//
//    test('a user can create a project', function () {
//        (new loginAsSanctumUser())->loginWithSanctum();
//        $project = Project::factory()->create();
//        $response = $this->postJson('/api/create-project',
//            ['title' => $project->title,
//                'description' => $project->description,
//                'owner_id' => $project->owner_id]
//        );
//
//        $response
//            ->assertStatus(Response::HTTP_OK)
//            ->assertJson(['title' => $project->title,
//                'description' => $project->description,
//                'owner_id' => $project->owner_id]);
//
//    });
//
//    test('a user can create a project test with headers', function () {
//        $response = $this->withHeaders([
//            'XSRF-TOKEN' => 'eyJpdiI6InpxK3RPaGhCQURZUFdqYjRNVk5qbGc9PSIsInZhbHVlIjoiUE5uZWExaER6T2t6bFFRMkhJeU9EdEhZSlFKTlh1NzZOcnp1bEtuTWtRUW8rc2laaFV4WnRFY1R6bloyM3hwMVBidHIwMCtkaHRCVVFMbnNhTG1UcUEzZ0FRdXM4VGRiOEJpQWZsa2lFeW1zWGJMRjNpc3NPVEdibXBJUFFnVXYiLCJtYWMiOiIzMmJiY2Y3YTNjYmFmNGE4OTE1MmY5N2ViMTc3NTE1MThjMDIxM2Y5ODgzMzFjNzFlMzJkNWUzYzM2NWU0ZmRhIiwidGFnIjoiIn0%3D;',
//        ])->post('/api/create-project', [
//            'title' => 'Sally',
//            'description' => 'description',
//            'owner_id' => 1,
//        ]);
//
//        $response->assertStatus(Response::HTTP_OK);
//    });
//
//    test('a user can delete a project', function () {
//        $user = (new loginAsSanctumUser())->loginWithSanctum();
//        $project = Project::factory()->create(['owner_id' => $user->id]);
//        $response = $this->deleteJson(route('projects.destroy', $project->uuid));
//        $response->assertStatus(Response::HTTP_OK)
//            ->assertJson(['message' => 'The project is deleted successfully.']);
//    });
//
//    test('it can update a project using policy', function () {
//        $this->withOutExceptionHandling();
//        $user = (new loginAsSanctumUser())->loginWithSanctum();
//
//        $project = Project::factory()->create();
//        $response = $this->putJson("/api/update-project/{$user->id}/{$project->id}");
//        $response->assertJson(fn(AssertableJson $json) => $json->whereAllType([
//            'title' => 'string',
//            'description' => 'string',
//            'owner_id' => 'integer',
//
//        ]))
//            ->assertStatus(Response::HTTP_OK)
//            ->assertJson([
//                'title' => $project->title,
//                'description' => $project->description,
//                'owner_id' => $project->owner_id,
//            ]);
//    });
//
//    test('can upload a file', function () {
//        $this->withOutExceptionHandling();
//        Storage::fake('local');
//        $file = UploadedFile::fake()->image('avatar.jpg');
//        (new loginAsSanctumUser())->loginWithSanctum();
//        $response = $this->post('/api/avatar/store', [
//            'avatar' => $file,
//        ]);
//        Storage::disk('local')->assertExists('/');
//    });
//
