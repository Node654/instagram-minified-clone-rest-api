<?php

namespace Tests\Feature\Post;

use App\Enums\LikeState;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddLikePostTest extends TestCase
{
    use RefreshDatabase;

    private Post $post;
    private Post $someonePost;

    protected function setUp(): void
    {
        parent::setUp();
        $this->post = Post::factory()->createOne([
            'user_id' => $this->getUserId(),
        ]);
        $this->someonePost = Post::factory()->createOne([
            'user_id' => $this->getUserId(),
        ]);
        Like::query()->create([
            'post_id' => $this->someonePost->id,
            'user_id' => $this->getUserId()
        ]);
    }

    public function test_success_add_like_to_post(): void
    {
        $response = $this->post(route('posts.like', ['post' => $this->post->id]));
        $response->assertOk();
        $response->assertJsonStructure(['state']);
        $response->assertJson(['state' => LikeState::Liked->value]);
        $this->assertDatabaseHas(Like::class, [
            'user_id' => $this->getUserId(),
            'post_id' => $this->post->id
        ]);
    }

    public function test_success_remove_like_from_post(): void
    {
        $response = $this->post(route('posts.like', ['post' => $this->someonePost->id]));
        $response->assertOk();
        $response->assertJsonStructure(['state']);
        $response->assertJson(['state' => LikeState::Unliked->value]);
        $this->assertDatabaseMissing(Like::class, [
            'user_id' => $this->getUserId(),
            'post_id' => $this->someonePost->id
        ]);
    }
}
