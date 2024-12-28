<?php

namespace Tests\Feature\Post;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class AddCommentToPostTest extends TestCase
{
    use RefreshDatabase;

    private Post $post;

    protected function setUp(): void
    {
        parent::setUp();
        $this->post = Post::factory()->createOne([
            'user_id' => $this->getUserId(),
        ]);
    }

    public function test_success_add_comment_to_post(): void
    {
        $data = [
            'text' => fake()->text
        ];

        $response = $this->post(route('posts.comments-store', ['post' => $this->post->id]), $data);
        $response->assertCreated();
        $response->assertJsonStructure([
            'id',
            'user_id',
            'post_id',
            'text',
        ]);
        $response->assertJson([
            'user_id' => $this->getUserId(),
            'post_id' => $this->post->id,
            'text' => Arr::get($data, 'text'),
        ]);
        $this->assertDatabaseHas(Comment::class, [
            'id' => $response->json('id'),
            'user_id' => $this->getUserId(),
            'post_id' => $this->post->id,
            'text' => Arr::get($data, 'text'),
        ]);
    }

    public function test_validation_add_comment_to_post(): void
    {
        $data = [
            'text' => ''
        ];

        $response = $this->post(route('posts.comments-store', ['post' => $this->post->id]), $data);
        $response->assertUnprocessable();
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'text' => []
            ]
        ]);
        $response->assertJson([
            'message' => 'The text field is required.',
            'errors' => [
                'text' => ['The text field is required.']
            ],
        ]);
        $response->assertJsonValidationErrors(['text']);
    }
}
