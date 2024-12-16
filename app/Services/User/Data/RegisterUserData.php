<?php

namespace App\Services\User\Data;

use Illuminate\Support\Facades\Hash;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class RegisterUserData extends Data
{
    public function __construct(
        #[MapInputName('name')]
        public string $name,
        #[MapInputName('email')]
        public string $email,
        #[MapInputName('login')]
        public string $login,
        #[MapInputName('about')]
        public ?string $about,
        #[MapInputName('password')]
        public string $password,
    ) {
        $this->password = Hash::make($this->password);
    }
}
