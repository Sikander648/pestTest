<?php

namespace Tests\Feature\sanctumTest;

use App\Models\User;
use Laravel\Sanctum\Sanctum;

class loginAsSanctumUser
{
    public function loginWithSanctum()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        return $user;
    }
}
