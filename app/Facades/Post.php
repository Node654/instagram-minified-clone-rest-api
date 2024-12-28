<?php

namespace App\Facades;

use App\Services\Post\Data\StorePostData;
use App\Services\Post\Data\UpdatePostData;
use App\Services\Post\PostService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Models\Post store(StorePostData $data)
 * @method static \App\Models\Post update(UpdatePostData $data, \App\Models\Post $post)
 * @method static Collection feed(int $limit = 10, int $offset = 0)
 * @method static int userTotalFeedPosts()
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
