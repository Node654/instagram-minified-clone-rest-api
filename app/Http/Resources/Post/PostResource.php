<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\Comment\CommentWithUserResource;
use App\Http\Resources\User\MinifiedUserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'photo' => $this->photo,
            'user' => MinifiedUserResource::make($this->user),
            'description' => $this->description,
            'likes' => $this->totalLikes(),
            'isLiked' => $this->isLiked(),
            'comments' => [
                'total' => $this->totalComments(),
                'list' => CommentWithUserResource::collection($this->comments),
            ],
            'createdAt' => $this->created_at->diffForHumans(),
        ];
    }
}
