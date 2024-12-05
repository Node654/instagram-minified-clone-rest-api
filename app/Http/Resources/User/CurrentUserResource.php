<?php

namespace App\Http\Resources\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
class CurrentUserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'login' => $this->login,
            'subscribers' => $this->subscribersCount(),
            'publications' => $this->postsCount(),
            'avatar' => $this->avatar,
            'about' => $this->about,
            'isVerified' => $this->is_verified ?? false,
            'registeredAt' => $this->created_at->format('d-m-Y H:i')
        ];
    }
}