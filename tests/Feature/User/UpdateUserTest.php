<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Support\Arr;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    public function test_update_success_user(): void
    {
        $password = fake()->unique()->password;
        $data = [
            'name' => fake()->name,
            'email' => fake()->unique()->email,
            'login' => fake()->unique()->userName,
            'about' => fake()->unique()->text(),
            'password' => $password,
            'password_confirmation' => $password,
        ];

        $response = $this->patch(route('users.update'), $data);

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
            'name' => Arr::get($data, 'name'),
            'email' => Arr::get($data, 'email'),
            'login' => Arr::get($data, 'login'),
            'about' => Arr::get($data, 'about'),
        ]);
        $this->assertDatabaseHas(User::class, [
            'id' => $this->getUserId(),
            'name' => Arr::get($data, 'name'),
            'email' => Arr::get($data, 'email'),
            'login' => Arr::get($data, 'login'),
            'about' => Arr::get($data, 'about'),
        ]);
    }

    public function test_validate_password_update_user(): void
    {
        $data = [
            'name' => fake()->name,
            'email' => fake()->unique()->email,
            'login' => fake()->unique()->userName,
            'about' => fake()->unique()->text(),
            'password' => fake()->unique()->password,
        ];

        $response = $this->patch(route('users.update'), $data);

        $response->assertUnprocessable();
        $response->assertJsonStructure([
            'message',
            'errors',
            'errors' => ['password'],
        ]);
        $response->assertJson([
            'message' => 'The password field confirmation does not match.',
            'errors' => [
                'password' => ['The password field confirmation does not match.'],
            ],
        ]);
        $response->assertJsonValidationErrors(['password']);
    }
}
