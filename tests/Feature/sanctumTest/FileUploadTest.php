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
        (new loginAsSanctumUser())->loginWithSanctum();
        $response = $this->post('/api/avatar/store', [
            'avatar' => $file,
        ]);
        Storage::disk('local')->assertExists('/');
    });
