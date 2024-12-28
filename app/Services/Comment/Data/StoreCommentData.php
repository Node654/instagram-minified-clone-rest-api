<?php

namespace App\Services\Comment\Data;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class StoreCommentData extends Data
{
    public function __construct(
        #[MapInputName('text')]
        public string $text,
        #[MapInputName('user_id')]
        public int $user_id,
    ) {}
}
