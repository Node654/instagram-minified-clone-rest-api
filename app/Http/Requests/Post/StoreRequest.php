<?php

namespace App\Http\Requests\Post;

use App\Services\Post\Data\StorePostData;
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
            'photo' => 'required|image',
            'description' => 'nullable|string|max:255',
        ];
    }

    public function storePostData(): StorePostData
    {
        return StorePostData::from($this->validated());
    }
}
