<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UpdateUserAvatarTest extends TestCase
{
    public function test_update_avatar(): void
    {
        $image = UploadedFile::fake()->image(uniqid().'.png');
        $response = $this->post(route('users.update.current-user.avatar'), [
            'avatar' => $image
        ]);

        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'name',
            'email',
            'login',
            'subscribers',
            'publications',
            'avatar',
            'about',
            'isVerified',
            'registeredAt',
        ]);
        $response->assertJson([
            'id' => $this->getUserId(),
            'name' => $this->getUser()->name,
            'email' => $this->getUser()->email,
            'login' => $this->getUser()->login,
        ]);
        $this->assertIsString($response->json('avatar'));
    }

    public function test_update_avatar_validation_type()
    {
        $image = UploadedFile::fake()->image(uniqid().'.gif');
        $response = $this->post(route('users.update.current-user.avatar'), [
            'avatar' => $image
        ]);
        $response->assertJsonStructure([
            'message',
            'errors',
            'errors' => ['avatar']
        ]);
        $response->assertJsonValidationErrors(['avatar']);
        $response->assertUnprocessable();
    }

    public function test_update_avatar_validation_size()
    {
        $image = UploadedFile::fake()->image(uniqid().'.png')->size(1001);
        $response = $this->post(route('users.update.current-user.avatar'), [
            'avatar' => $image
        ]);
        $response->assertJsonStructure([
            'message',
            'errors',
            'errors' => ['avatar']
        ]);
        $response->assertJsonValidationErrors(['avatar']);
        $response->assertUnprocessable();
    }
}

