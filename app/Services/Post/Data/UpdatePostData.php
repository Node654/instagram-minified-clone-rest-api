<?php

namespace App\Services\Post\Data;


use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class UpdatePostData extends Data
{
    public function __construct(
        #[MapInputName('description')]
        public string|Optional $description,
    ) {}
}
