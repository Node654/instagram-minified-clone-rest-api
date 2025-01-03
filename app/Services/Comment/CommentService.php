<?php

namespace App\Services\Comment;

use App\Models\Comment;
use App\Models\Post;
use App\Services\Comment\Data\StoreCommentData;

class CommentService
{
    public function store(StoreCommentData $data, Post $post): Comment
    {
        return $post->comments()->create($data->toArray());
    }
}
