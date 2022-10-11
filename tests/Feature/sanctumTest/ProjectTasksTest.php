<?php

namespace Tests\Feature\sanctumTest;

    use App\Models\Project;

    test('can store a task', function () {
        (new loginAsSanctumUser())->loginWithSanctum();
        $project = Project::factory()->create();
        $response = $this->postJson('/api/add-task', ['project_id' => $project->uuid]);
        $response->assertJson(fn(AssertableJson $json) => $json->whereAllType([
            'task' => $project->task->title,

        ]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'task' => $project->task->title,
            ]);
    });

