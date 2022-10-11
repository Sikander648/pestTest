<?php

namespace Tests\Feature\sanctumTest;

use App\Models\User;
use Laravel\Sanctum\Sanctum;

class loginAsSanctumUser
{
    public function loginWithSanctum(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
    }
}
