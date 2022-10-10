<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
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
        if ($request->user()->cannot('update', $request, $project)) {
            abort(403);
        }

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

}
