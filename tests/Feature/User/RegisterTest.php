<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_validation(): void
    {
        $data = [
            'name' => null,
            'email' => null,
            'login' => null,
            'about' => fake()->text,
            'password' => '12345678',
            'password_confirmation' => '123'
        ];

        $response = $this->post(route('users.register'), $data);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['name', 'email', 'login', 'password']);
    }

    public function test_success_register(): void
    {
        $data = [
            'name' => fake()->name,
            'email' => fake()->unique()->email,
            'login' => fake()->unique()->name,
            'about' => fake()->text,
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ];

        $response = $this->post(route('users.register'), $data);
        $response->assertCreated();
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
            'id' => $response->json('id'),
            'name' => Arr::get($data, 'name'),
            'email' => Arr::get($data, 'email'),
            'login' => Arr::get($data, 'login'),
            'subscribers' => 0,
            'publications' => 0,
            'avatar' => null,
            'about' => Arr::get($data, 'about'),
            'isVerified' => false,
            'registeredAt' => $response->json('registeredAt'),
        ]);
        $this->assertDatabaseHas(User::class, [
            'id' => $response->json('id'),
            'name' => Arr::get($data, 'name'),
            'email' => Arr::get($data, 'email'),
            'login' => Arr::get($data, 'login'),
            'about' => Arr::get($data, 'about'),
        ]);
    }
}
