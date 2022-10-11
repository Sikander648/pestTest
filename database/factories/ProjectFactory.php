<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{

    public function definition()
    {
        return [
            'title' => fake()->title(),
            'description' => fake()->sentence(),
            'owner_id' => rand(),
        ];
    }
}
