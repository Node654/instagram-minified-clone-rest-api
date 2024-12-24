<?php

namespace App\Services\Post\Data;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class StorePostData extends Data
{
    public function __construct(
        #[MapInputName('photo')]
        public UploadedFile $photo,
        #[MapInputName('description')]
        public string|Optional $description,
    )
    {
    }
}
