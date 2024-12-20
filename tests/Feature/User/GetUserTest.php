<?php

namespace Tests\Feature\User;

use App\Models\Subscriber;
use App\Models\User;
use Tests\TestCase;

class GetUserTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->createOne();
        Subscriber::query()->create([
            'user_id' => $this->user->id,
            'subscriber_id' => $this->getUserId(),
        ]);
    }

    public function test_success_get_user(): void
    {
        $response = $this->get(route('users.get-user', ['user' => $this->user->id]));

        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'name',
            'email',
            'login',
            'subscribers',
            'publications',
            'isSubscribed',
            'avatar',
            'about',
            'isVerified',
            'registeredAt',
        ]);
        $response->assertJson([
            'id' => $this->user->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'login' => $this->user->login,
            'subscribers' => $this->user->subscribersCount(),
            'publications' => $this->user->postsCount(),
            'isSubscribed' => $this->user->isSubscribedCurrentUser(),
            'avatar' => $this->user->avatar,
            'about' => $this->user->about,
            'isVerified' => $this->user->is_verified,
            'registeredAt' => $this->user->created_at->format('d-m-Y H:i'),
        ]);
        $this->assertTrue($response->json('isSubscribed'));
    }

    public function test_user_not_found()
    {
        $response = $this->get(route('users.get-user', ['user' => 0]));
        $response->assertNotFound();
        $response->assertJsonStructure([
            'message',
        ]);
        $response->assertJson([
            'message' => 'User not found',
        ]);
    }
}
