<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    private User $user;

    public function getUser(): User
    {
        return $this->user;
    }

    public function getUserId(): int
    {
        return $this->user->id;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->createOne();
        Sanctum::actingAs($this->user);

        $this->withHeader('Accept', 'application/json');
    }
}
