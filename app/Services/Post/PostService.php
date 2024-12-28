<?php

namespace App\Services\Post;

use App\Models\Post;
use App\Services\Post\Data\StorePostData;
use App\Services\Post\Data\UpdatePostData;
use Illuminate\Database\Eloquent\Collection;

class PostService
{
    public function store(StorePostData $data): Post
    {
        $pathImage = uploadedImage($data->photo);

        return auth()->user()->posts()->create([
            'photo' => $pathImage,
            'description' => $data->description,
        ]);
    }

    public function update(UpdatePostData $data, Post $post): Post
    {
        $post->update($data->toArray());

        return $post;
    }

    public function feed(int $limit = 10, int $offset = 0): Collection
    {
        return auth()->user()
            ->feedPosts()
            ->limit($limit)
            ->offset($offset)
            ->orderByDesc('created_at')
            ->get();
    }

    public function userTotalFeedPosts(): int
    {
        return auth()->user()->feedPosts()->count();
    }
}
