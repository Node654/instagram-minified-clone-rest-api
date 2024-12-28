<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\User\MinifiedUserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeedPostResource extends JsonResource
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
            'user' => new MinifiedUserResource($this->user),
            'photo' => $this->photo,
            'description' => $this->description,
            'likes' => $this->totalLikes(),
            'comments' => $this->totalComments(),
            'isLiked' => $this->isLiked(),
        ];
    }
}
