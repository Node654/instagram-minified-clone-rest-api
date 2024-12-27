<?php

namespace App\Http\Controllers\Api\Post;

use App\Facades\Comment;
use App\Facades\Post as PostFacade;
use App\Http\Controllers\Controller;
use App\Http\Middleware\Post\CheckingRightsToDeletePost;
use App\Http\Requests\Comment\StoreRequest as CommentStoreRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PostController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(CheckingRightsToDeletePost::class, ['destroy', 'update']),
        ];
    }

    public function index()
    {
        //
    }

    public function store(StoreRequest $request): JsonResource
    {
        $post = PostFacade::store($request->storePostData());

        return PostResource::make($post);
    }

    public function show(Post $post): JsonResource
    {
        return PostResource::make($post);
    }

    public function update(UpdateRequest $request, Post $post): JsonResource
    {
        return new PostResource(PostFacade::update($request->updatePostData(), $post));
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return response()->noContent();
    }

    public function storeComment(CommentStoreRequest $request, Post $post)
    {
        $comment = Comment::store($request->commentData(), $post);

        return CommentResource::make($comment);
    }
}
