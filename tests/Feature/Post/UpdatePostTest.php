<?php

namespace Tests\Feature\Post;

use App\Http\Resources\Comment\CommentWithUserResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Arr;
use Tests\TestCase;

class UpdatePostTest extends TestCase
{
    private Post $post;

    private Post $someonePost;

    protected function setUp(): void
    {
        parent::setUp();

        $this->post = Post::factory()->create(['user_id' => $this->getUserId()]);
        $this->someonePost = Post::factory()->for(User::factory())->create();
    }

    public function test_update_post(): void
    {
        $data = [
            'description' => fake()->text(),
        ];

        $response = $this->patch(route('posts.update', ['post' => $this->post->id]), $data);

        $response->assertJsonStructure([
            'id',
            'photo',
            'user' => [
                'id',
                'name',
                'avatar',
            ],
            'description',
            'likes',
            'isLiked',
            'comments' => [
                'total',
                'list',
            ],
            'createdAt',
        ]);

        $response->assertJson([
            'id' => $this->post->id,
            'photo' => $this->post->photo,
            'user' => [
                'id' => $this->post->user->id,
                'name' => $this->post->user->name,
                'avatar' => $this->post->user->avatar,
            ],
            'description' => Arr::get($data, 'description'),
            'likes' => $this->post->totalLikes(),
            'isLiked' => $this->post->isLiked(),
            'comments' => [
                'total' => $this->post->totalComments(),
                'list' => CommentWithUserResource::collection($this->post->comments)->toArray(request()),
            ],
            'createdAt' => $this->post->created_at->diffForHumans(),
        ]);
        $this->assertDatabaseHas(Post::class, [
            'id' => $this->post->id,
            'description' => Arr::get($data, 'description')
        ]);
    }

    public function test_update_someone_post(): void
    {
        $data = [
            'description' => fake()->text(),
        ];
        $response = $this->patch(route('posts.update', ['post' => $this->someonePost->id]), $data);
        $response->assertForbidden();
        $response->assertJsonStructure(['message']);
        $this->assertDatabaseHas(Post::class, [
            'id' => $this->someonePost->id,
            'description' => $this->someonePost->description,
        ]);
    }
}
