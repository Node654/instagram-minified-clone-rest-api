<?php

namespace App\Facades;

use App\Services\Comment\CommentService;
use App\Services\Comment\Data\StoreCommentData;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Models\Comment store(StoreCommentData $data, \App\Models\Post $post)
 *
 * @see CommentService
 */
class Comment extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return CommentService::class;
    }
}
