<?php

namespace App\Services\Post;

use App\Models\Post;
use App\Services\Post\Data\StorePostData;
use Illuminate\Support\Arr;

class PostService
{
    public function store(StorePostData $data): Post
    {
        $pathImage = uploadedImage($data->photo);
        return auth()->user()->posts()->create([
            'photo' => $pathImage,
            'description' => $data->description
        ]);
    }
}
