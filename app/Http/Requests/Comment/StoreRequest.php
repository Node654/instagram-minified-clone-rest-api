<?php

namespace App\Http\Requests\Comment;

use App\Services\Comment\Data\StoreCommentData;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'text' => 'required|string|min:1|max:255',
        ];
    }

    public function commentData(): StoreCommentData
    {
        $data = $this->validated();
        $data['user_id'] = auth()->id();
        return StoreCommentData::from($data);
    }
}
