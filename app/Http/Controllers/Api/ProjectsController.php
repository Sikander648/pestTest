<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function show(Project $project)
    {
        return response()->json([
            'project' => $project
        ]);
    }

    public function showProjects(Request $request): \Illuminate\Http\JsonResponse
    {
        $project = project::where('id', $request->user_id)->first();


        $projects = project::where('id', $request->user_id)->get();
        return response()->json([
            'project' => $projects
        ]);
    }


    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json([
            'message' => __('messages.project-delete')
        ]);
    }

    public function uploadFiles(Request $request)
    {


        $imageName = time().'.'.$request->avatar->getClientOriginalExtension();
        $request->avatar->move(public_path('img'), $imageName);

        return response()->json([
            'success'=>'You have successfully upload file.',
            'image_name' => $imageName
        ]);

    }

    public function addTask(Request $request)
    {
        $project =  Project::find($request->project_id);
        $task = $project->addTask(['title' => 'test task']);

        return $task;



    }

    public function updateProject($userId, $project_id, Request $request)
    {
        $user = User::find($userId);
        $project = Project::find($project_id);
        if (request()->user()->can('update', $project)) {
            abort(403);
        }

        return Project::create([
            'title' => '$request->title',
            'description' => '$request->description',
            'owner_id' => 1
        ]);

    }

    public function createProject(Request $request)
    {
        $this->validateRequest();

        return Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'owner_id' => 1
        ]);
    }

    protected function validateRequest() {
        return request()->validate([
            'title' => 'sometimes',
            'description' => 'sometimes',
            'owner_id' => 'sometimes',
        ]);

    }

}
