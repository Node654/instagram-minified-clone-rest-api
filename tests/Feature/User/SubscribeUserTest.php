<?php

namespace Tests\Feature\User;

use App\Enums\SubscribedState;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscribeUserTest extends TestCase
{
    private User $subscribedUser;
    private User $unsubscribedUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subscribedUser = User::factory()->create();
        $this->unsubscribedUser = User::factory()->create();
        Subscriber::factory()->create([
            'user_id' => $this->unsubscribedUser->id,
            'subscriber_id' => $this->getUserId()
        ]);
    }

    public function test_success_subscribed_user(): void
    {
        $response = $this->post(route('users.subscribe', ['user' => $this->subscribedUser->id]));
        $response->assertOk();
        $response->assertJsonStructure(['state']);
        $response->assertJson(['state' => SubscribedState::Subscribed->value]);
        $this->assertEquals(SubscribedState::Subscribed->value, $response->json('state'));
    }

    public function test_success_unsubscribed_user(): void
    {
        $response = $this->post(route('users.subscribe', ['user' => $this->unsubscribedUser->id]));
        $response->assertOk();
        $response->assertJsonStructure(['state']);
        $response->assertJson(['state' => SubscribedState::Unsubscribed->value]);
        $this->assertEquals(SubscribedState::Unsubscribed->value, $response->json('state'));
    }
}
