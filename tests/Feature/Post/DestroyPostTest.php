<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyPostTest extends TestCase
{
    use RefreshDatabase;

    private Post $post;

    private Post $someonePost;

    protected function setUp(): void
    {
        parent::setUp();
        $this->post = Post::factory()->createOne(['user_id' => $this->getUserId()]);
        $this->someonePost = Post::factory()->for(User::factory())->createOne();
    }

    public function test_destroy_post(): void
    {
        $response = $this->delete(route('posts.destroy', ['post' => $this->post->id]));

        $response->assertNoContent();
        $this->assertSoftDeleted(Post::class, [
            'id' => $this->post->id,
        ]);
    }

    public function test_destroy_someone_post(): void
    {
        $response = $this->delete(route('posts.destroy', ['post' => $this->someonePost->id]));

        $response->assertForbidden();
        $response->assertJsonStructure([
            'message',
        ]);
        $this->assertNotSoftDeleted(Post::class, [
            'id' => $this->someonePost->id,
        ]);
    }
}
