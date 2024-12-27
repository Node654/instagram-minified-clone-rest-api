<?php

namespace App\Facades;

use App\Services\Post\Data\StorePostData;
use App\Services\Post\Data\UpdatePostData;
use App\Services\Post\PostService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Models\Post store(StorePostData $data)
 * @method static \App\Models\Post update(UpdatePostData $data, \App\Models\Post $post)
 *
 * @see PostService
 */
class Post extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return PostService::class;
    }
}
