<?php

namespace Tests\Feature\sanctumTest;

    use App\Models\User;
    use Illuminate\Http\UploadedFile;
    use Illuminate\Support\Facades\Storage;
    use Laravel\Sanctum\Sanctum;

    test('can upload a file', function () {
        $this->withOutExceptionHandling();
        Storage::fake('local');
        $file = UploadedFile::fake()->image('avatar.jpg');
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        $response = $this->post('/api/avatar/store', [
            'avatar' => $file,
        ]);
        Storage::disk('local')->assertExists('/');
    });
