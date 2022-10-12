<?php

namespace App\Observers;

use App\Models\Activity;
use App\Models\Project;

class ProjectObserver
{

    public function created(Project $project)
    {
         Activity::create([
             'description' => 'created',
             'project_id' => $project->id,
         ]);
    }


    public function updated(Project $project)
    {
        Activity::create([
            'description' => 'updated',
            'project_id' => $project->id,
        ]);
    }

    public function deleted(Task $task)
    {
        //
    }


    public function restored(Task $task)
    {
        //
    }


    public function forceDeleted(Task $task)
    {
        //
    }
}
