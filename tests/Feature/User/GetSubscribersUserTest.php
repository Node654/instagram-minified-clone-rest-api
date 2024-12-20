<?php

namespace Tests\Feature\User;

use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetSubscribersUserTest extends TestCase
{
    use RefreshDatabase;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_get_subscribers_user(): void
    {
        $response = $this->get(route('users.subscribers', [$this->user->id]));
        $response->assertOk();
        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'login',
                'isSubscribed',
                'avatar',
                'isVerified',
            ]
        ]);
    }
}
