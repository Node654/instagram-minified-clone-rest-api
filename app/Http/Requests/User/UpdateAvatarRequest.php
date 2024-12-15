<?php

namespace App\Http\Requests\User;

use App\Services\User\Data\UserAvatarData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class UpdateAvatarRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'avatar' => 'required|image|mimes:png,webp|max:1000'
        ];
    }

    public function avatar(): UploadedFile
    {
        return $this->file('avatar');
    }
}
