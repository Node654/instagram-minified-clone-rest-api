<?php

namespace App\Http\Controllers\Api\Post;

use App\Facades\Comment;
use App\Facades\Post as PostFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreRequest as CommentStoreRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostController extends Controller
{
    public function index()
    {
        //
    }

    public function store(StoreRequest $request): JsonResource
    {
        $post = PostFacade::store($request->postData());

        return PostResource::make($post);
    }

    public function show(Post $post): JsonResource
    {
        return PostResource::make($post);
    }

    public function update(Request $request, Post $post)
    {
        //
    }

    public function destroy(Post $post)
    {
        //
    }

    public function storeComment(CommentStoreRequest $request, Post $post)
    {
        $comment = Comment::store($request->commentData(), $post);

        return CommentResource::make($comment);
    }
}
