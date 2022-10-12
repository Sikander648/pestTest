<?php
//
//use App\Models\Project;
//use App\Models\User;
//use Illuminate\Foundation\Testing\RefreshDatabase;
//use Illuminate\Http\Response;
//use Illuminate\Support\Facades\Auth;
//use Illuminate\Testing\Fluent\AssertableJson;
//use Inertia\Testing\AssertableInertia as Assert;
//use Laravel\Sanctum\Sanctum;
//use Symfony\Component\HttpFoundation\Response as ResponseAlias;
//
//uses(RefreshDatabase::class);
//
//
//
//    it('can make a project', function () {
//        Project::factory()->create();
//    });
//
//    it('checks a project requires a description', function () {
//        $project = Project::factory()->create();
//        expect($project->description)->not->toBeEmpty();
//    });
//
//    it('a project requires a title', function () {
//        $project = Project::factory()->create();
//        expect($project->title)->not->toBeEmpty();
//    });
//
//    it('creates a project and test api', function () {
//        $project = Project::factory()->create();
//        $response = $this->getJson(route('projects.show', $project->id));
//        $response->assertStatus(Response::HTTP_OK);
//    });
//
//    it('a user can delete a project', function () {
//        $project = Project::factory()->create();
//        $response = $this->deleteJson(route('projects.destroy', $project->id));
//        $response->assertStatus(Response::HTTP_OK)
//            ->assertJson(['message' => 'The project is deleted successfully.']);
//    });
//
//    it('a project has an owner', function () {
//        $project = Project::factory()->create();
//        expect($project->owner_id)->not->toBeEmpty();
//    });
//
//
//    it('can scope user projects', function () {
//        $user = Auth::user()->id;
//        $response = $this->getJson(route('projects.showProjects', $user->id));
//        $response->assertStatus(Response::HTTP_OK);
//    });
//
//
//
//
//
//
