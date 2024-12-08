<?php

namespace Tests\Feature\User;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetCurrentUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_success_get_current_user(): void
    {
        $response = $this->get(route('users.current'));

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
            'id' => auth()->id(),
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'login' => auth()->user()->login,
            'subscribers' => auth()->user()->subscribersCount(),
            'publications' => auth()->user()->postsCount(),
            'avatar' => auth()->user()->avatar,
            'about' => auth()->user()->about,
            'isVerified' => auth()->user()->is_verified,
            'registeredAt' => auth()->user()->created_at->format('d-m-Y H:i'),
        ]);
    }
}
