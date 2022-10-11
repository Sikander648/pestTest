<?php

    namespace Tests\Feature\sanctumTest;

    use App\Models\Project;
    use App\Models\User;
    use Illuminate\Http\Response;
    use Laravel\Sanctum\Sanctum;

    test('it can update a project using policy', function () {
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

