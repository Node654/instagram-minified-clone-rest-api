<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->createOne();
    }

    public function test_success_with_email(): void
    {
        $response = $this->post(route('users.login'), [
            'email' => $this->user->email,
            'password' => 'password',
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'token',
        ]);
    }

    public function test_success_with_login(): void
    {
        $response = $this->post(route('users.login'), [
            'login' => $this->user->login,
            'password' => 'password',
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'token',
        ]);
    }

    public function test_validation_with_email_or_login(): void
    {
        // Единственное отличие, необходимо вместо email передать логин $this->user->login и тест пройдет также!
        $response = $this->post(route('users.login'), [
            'email' => $this->user->email,
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['password']);
        $response->assertJsonStructure([
            'message',
            'errors',
            'errors' => ['password'],
        ]);
        $response->assertJson([
            'message' => 'The password field is required.',
            'errors' => ['password' => ['The password field is required.']],
        ]);
    }
}
