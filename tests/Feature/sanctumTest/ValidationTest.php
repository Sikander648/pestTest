<?php
//        // test sanctum
//        use App\Models\Project;
//        use App\Models\User;
//        use Illuminate\Http\Response;
//        use Laravel\Sanctum\Sanctum;
//
//        test('can test data types', function () {
//            (new loginAsSanctumUser())->loginWithSanctum();
//            $project = Project::factory()->create();
//            $response = $this->postJson('/api/create-project', ['title' => $project->title, 'description' => $project->description, 'owner_id' => $project->owner_id]);
//            $response->assertJson(fn(AssertableJson $json) => $json->whereAllType([
//                'title' => 'string',
//                'owner_id' => 'integer',
//                'description' => 'string'
//            ]));
//        });
//
//
//        test('can store a task with missing attributes', function () {
//            (new loginAsSanctumUser())->loginWithSanctum();
//            $project = Project::factory()->create();
//            $response = $this->postJson('/api/create-project', ['description' => $project->id]);
//            $response->assertJson(fn(AssertableJson $json) => $json->whereAllType([
//                'description' => 'string',
//
//            ]))
//                ->assertStatus(Response::HTTP_OK)
//                ->assertJson([
//                    'description' => $project->description,
//                ]);
//        });
//
