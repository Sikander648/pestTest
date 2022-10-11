<?php

        namespace Tests\Feature\sanctumTest;

        // test sanctum

        function loginWithSanctum(): void
        {
            Sanctum::actingAs(
                User::factory()->create(),
                ['*']
            );
        }

        it('sanctum-csrf-cookie', function () {

            $this->get('/sanctum/csrf-cookie');

        });

        it('register a user', function () {
            $user = User::factory()->create();
            $response = $this->postJson('/api/register-user', $user);
            $response->assertDatabaseHas('user', $user);
        });

        it('login a user', function () {
            $user = User::factory()->create();
            $response = $this->postJson('/api/login-test', ['email' => $user->email, 'password' => $user->password]);
            $response->assertStatus(201)->assertJson(['message' => 'User is Loged In']);
        });

        it('test login with senctum', function () {
            Sanctum::actingAs(
                User::factory()->create(),
                ['*']
            );
            $response = $this->get('/api/task');
            $response->assertOk();
        });

        it('a user can view a project', function () {
            $this->loginWithSanctum();
            $response = $this->get('/api/show-project/1');
            $response->assertStatus(Response::HTTP_OK);

        });

        it('a user can create a project', function () {
            $this->loginWithSanctum();
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

        it('a user can create a project test with headers', function () {
            $response = $this->withHeaders([
                'XSRF-TOKEN' => 'eyJpdiI6InpxK3RPaGhCQURZUFdqYjRNVk5qbGc9PSIsInZhbHVlIjoiUE5uZWExaER6T2t6bFFRMkhJeU9EdEhZSlFKTlh1NzZOcnp1bEtuTWtRUW8rc2laaFV4WnRFY1R6bloyM3hwMVBidHIwMCtkaHRCVVFMbnNhTG1UcUEzZ0FRdXM4VGRiOEJpQWZsa2lFeW1zWGJMRjNpc3NPVEdibXBJUFFnVXYiLCJtYWMiOiIzMmJiY2Y3YTNjYmFmNGE4OTE1MmY5N2ViMTc3NTE1MThjMDIxM2Y5ODgzMzFjNzFlMzJkNWUzYzM2NWU0ZmRhIiwidGFnIjoiIn0%3D;',
            ])->post('/api/create-project', [
                'title' => 'Sally',
                'description' => 'description',
                'owner_id' => 1,
            ]);

            $response->assertStatus(Response::HTTP_OK);
        });

        it('can test data types', function () {
            $this->withOutExceptionHandling();
            $this->loginWithSanctum();
            $project = Project::factory()->create();
            $response = $this->postJson('/api/create-project', ['title' => $project->title, 'description' => $project->description, 'owner_id' => $project->owner_id]);
            $response->assertJson(fn(AssertableJson $json) => $json->whereAllType([
                'title' => 'string',
                'owner_id' => 'integer',
                'description' => 'string'
            ]));
        });

        it('can upload a file', function () {
            $this->withOutExceptionHandling();
            Storage::fake('local');
            $file = UploadedFile::fake()->image('avatar.jpg');
            $response = $this->post('/api/avatar/store', [
                'avatar' => $file,
            ]);
            Storage::disk('local')->assertExists('/');
        });

        it('can store a task', function () {
            $this->loginWithSanctum();
            $project = Project::factory()->create();
            $response = $this->postJson('/api/add-task', ['project_id' => $project->id]);
            $response->assertJson(fn(AssertableJson $json) => $json->whereAllType([
                'task' => 'task',

            ]))
                ->assertStatus(Response::HTTP_OK)
                ->assertJson([
                    'task' => 'task',
                ]);
        });


        it('it can update a project using policy', function () {
            $this->withOutExceptionHandling();
            Sanctum::actingAs(
                $user = User::factory()->create(),
                ['*']
            );

            $project = Project::factory()->create();
            $response = $this->putJson("/api/update-project/{$user->id}/{$project->id}");
            $response->assertJson(fn(AssertableJson $json) => $json->whereAllType([
                'title' => 'string',
                'description' => 'string',
                'owner_id' => 'integer',

            ]))
                ->assertStatus(Response::HTTP_OK)
                ->assertJson([
                    'title' => $project->title,
                    'description' => $project->description,
                    'owner_id' => $project->owner_id,
                ]);
        });

        it('can store a task with missing attributes', function () {
            $this->loginWithSanctum();
            $project = Project::factory()->create();
            $response = $this->postJson('/api/create-project', ['description' => $project->id]);
            $response->assertJson(fn(AssertableJson $json) => $json->whereAllType([
                'description' => $project->description,

            ]))
                ->assertStatus(Response::HTTP_OK)
                ->assertJson([
                    'description' => $project->description,
                ]);
        });

