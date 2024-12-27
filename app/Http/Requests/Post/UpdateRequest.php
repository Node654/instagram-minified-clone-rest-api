<?php

namespace App\Http\Requests\Post;

use App\Services\Post\Data\UpdatePostData;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'description' => 'nullable|string|max:255',
        ];
    }

    public function updatePostData(): UpdatePostData
    {
        return UpdatePostData::from($this->validated());
    }
}
