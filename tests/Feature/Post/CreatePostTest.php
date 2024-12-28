<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Tests\TestCase;

class CreatePostTest extends TestCase
{
    use RefreshDatabase;

    public function test_success_create_post(): void
    {
        $data = [
            'photo' => UploadedFile::fake()->image('test.png'),
            'description' => fake()->text(),
        ];

        $response = $this->post(route('posts.store'), $data);

        $response->assertCreated();
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
            'user' => [
                'id' => $this->getUserId(),
                'name' => $this->getUser()->name,
                'avatar' => $this->getUser()->avatar,
            ],
            'description' => Arr::get($data, 'description'),
            'likes' => 0,
            'isLiked' => false,
            'comments' => [
                'total' => 0,
                'list' => [],
            ],
        ]);
        $this->assertDatabaseHas(Post::class, [
            'id' => $response->json('id'),
            'photo' => $response->json('photo'),
            'description' => $response->json('description'),
            'user_id' => $this->getUserId(),
        ]);
    }

    public function test_create_validation_post(): void
    {
        $data = [
            'photo' => null,
            'description' => fake()->text(),
        ];

        $response = $this->post(route('posts.store'), $data);

        $response->assertUnprocessable();
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'photo',
            ],
        ]);
        $response->assertJson([
            'message' => 'The photo field is required.',
            'errors' => [
                'photo' => [
                    'The photo field is required.',
                ],
            ],
        ]);
        $response->assertJsonValidationErrors(['photo']);
        $response->assertJsonMissingValidationErrors(['description']);
    }
}
