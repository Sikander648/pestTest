<?php
        // test sanctum
        use App\Models\Project;
        use App\Models\User;
        use Illuminate\Http\Response;
        use Laravel\Sanctum\Sanctum;

        test('can test data types', function () {
            $user = User::factory()->create();
            Sanctum::actingAs($user, ['*']);
            $project = Project::factory()->create();
            $response = $this->postJson('/api/create-project', ['title' => $project->title, 'description' => $project->description, 'owner_id' => $project->owner_id]);
            $response->assertJson(fn(AssertableJson $json) => $json->whereAllType([
                'title' => 'string',
                'owner_id' => 'integer',
                'description' => 'string'
            ]));
        });

        test('can store a task', function () {
            $user = User::factory()->create();
            Sanctum::actingAs($user, ['*']);
            $project = Project::factory()->create();
            $response = $this->postJson('/api/add-task', ['project_id' => $project->uuid]);
            $response->assertJson(fn(AssertableJson $json) => $json->whereAllType([
                'task' => 'task',

            ]))
                ->assertStatus(Response::HTTP_OK)
                ->assertJson([
                    'task' => 'task',
                ]);
        });

        test('can store a task with missing attributes', function () {
            $user = User::factory()->create();
            Sanctum::actingAs($user, ['*']);
            $project = Project::factory()->create();
            $response = $this->postJson('/api/create-project', ['description' => $project->id]);
            $response->assertJson(fn(AssertableJson $json) => $json->whereAllType([
                'description' => 'string',

            ]))
                ->assertStatus(Response::HTTP_OK)
                ->assertJson([
                    'description' => $project->description,
                ]);
        });

