<?php

namespace App\Services\User\Data;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class LoginUserData extends Data
{
    public function __construct(
        #[MapInputName('email')]
        public string|Optional $email,
        #[MapInputName('login')]
        public string|Optional $login,
        #[MapInputName('password')]
        public string $password,
    ) {}
}
