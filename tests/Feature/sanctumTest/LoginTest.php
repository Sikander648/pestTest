<?php

       namespace Tests\Feature\sanctumTest;

        use App\Models\User;
        use Laravel\Sanctum\Sanctum;

        function loginWithSanctum(): void
        {
            Sanctum::actingAs(
                User::factory()->create(),
                ['*']
            );
        }

        test('sanctum-csrf-cookie', function () {

            $this->get('/sanctum/csrf-cookie');

        });

        test('test login with senctum', function () {
            Sanctum::actingAs(
                User::factory()->create(),
                ['*']
            );
            $response = $this->get('/api/task');
            $response->assertOk();
        });
