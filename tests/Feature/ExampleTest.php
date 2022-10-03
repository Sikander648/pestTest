<?php

use App\User;
use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

beforeEach(function () {
    Project::factory()->create([
        'title' => 'title',
        'description' => 'description'
    ]);
});
