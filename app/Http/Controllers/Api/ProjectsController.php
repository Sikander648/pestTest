<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

}
