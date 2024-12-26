<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\User\MinifiedUserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentWithUserResource extends JsonResource
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
            'user' => MinifiedUserResource::make($this->user),
            'comment' => $this->text,
        ];
    }
}
