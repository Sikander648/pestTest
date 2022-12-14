<?php

    use App\Models\Project;
    use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\sanctumTest\loginAsSanctumUser;

uses(RefreshDatabase::class);

    test('creating a project generates activity', function () {
        $this->withOutExceptionHandling();
        (new loginAsSanctumUser())->loginWithSanctum();
        $project = Project::factory()->create();
        $response = $this->putJson("/api/create-activity/{$project->id}");
        $response->assertJson(fn(AssertableJson $json) => $json->whereAllType([
            'id' => 'integer',
            'description' => 'string',
            'project_id' => 'integer',
            'created_at' => 'string',
            'updated_at' => 'string'

        ]))
            ->assertStatus(201)
            ->assertJson([
                'id' => $project->activity[0]->id,
                'project_id' => $project->project_id,
                'description' => 'created',
                'created_at' => $project->activity[0]->created_at,
                'updated_at' => $project->activity[0]->updated_at,
            ], $strict = false);
        $this->assertCount(2, $project->activity);
    });

    test('updating a project generates activity', function () {
        $this->withOutExceptionHandling();
        (new loginAsSanctumUser())->loginWithSanctum();
        $project = Project::factory()->create();
        $response = $this->putJson("/api/update-activity/{$project->id}");
        $response->assertJson(fn(AssertableJson $json) => $json->whereAllType([
            'id' => 'integer',
            'description' => 'string',
            'project_id' => 'integer',
            'created_at' => 'string',
            'updated_at' => 'string'

        ]))
            ->assertStatus(201)
            ->assertJson([
                'id' => $project->activity->last()->id,
                'project_id' => $project->activity->last()->id,
                'description' => 'updated',
                'created_at' => $project->activity->last()->created_at,
                'updated_at' => $project->activity->last()->updated_at,
            ], $strict = false);
        $this->assertCount(1, $project->activity);
    });

    test('updating a project generates activity', function () {
        $this->withOutExceptionHandling();
        (new loginAsSanctumUser())->loginWithSanctum();
        $project = Project::factory()->create();
        $response = $this->postJson('/api/creating-a-project-task-records-activity',
                [
                     'title' => $project->title,
                     'description' => $project->description,
                     'owner_id' => $project->owner_id
                ]
        )->assertStatus(201)
            ->assertJson([
                'id' => $project->activity->last()->id,
                'project_id' => $project->activity->last()->id,
                'description' => 'task_created',
                'created_at' => $project->activity->last()->created_at,
                'updated_at' => $project->activity->last()->updated_at,
            ],false);

    });

    test('test if task is complete', function () {
        $this->withOutExceptionHandling();
        (new loginAsSanctumUser())->loginWithSanctum();
        $project = Project::factory()->create();
        $response = $this->postJson('/api/update-task-status',
            [
                'title' => $project->title,
                'description' => $project->description,
                'owner_id' => $project->owner_id
            ]
        )->assertStatus(201)
            ->assertJson([
                'complete' => true,
            ],false);

    });

    test('a task can be marked as incomplete', function () {
        $this->withOutExceptionHandling();
        (new loginAsSanctumUser())->loginWithSanctum();
        $project = Project::factory()->create();
        $project->addTask([
            'complete' => false
        ]);
        $response = $this->postJson('/api/mark-task-as-incomplete',
            [
                'title' => $project->title,
                'description' => $project->description,
                'owner_id' => $project->owner_id
            ]
        )->assertStatus(201)
            ->assertJson([
                'complete' => false,
            ],false);

    });

    test('a task can be marked as incomplete', function () {
        $this->withOutExceptionHandling();
        (new loginAsSanctumUser())->loginWithSanctum();
        $project = Project::factory()->create();
        $project->addTask([
            'complete' => false
        ]);
        $response = $this->postJson('/api/mark-task-as-incomplete',
            [
                'title' => $project->title,
                'description' => $project->description,
                'owner_id' => $project->owner_id
            ]
        )->assertStatus(201)
            ->assertJson([
                'complete' => false,
            ],false);

    });
