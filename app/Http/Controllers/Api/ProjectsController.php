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

}
