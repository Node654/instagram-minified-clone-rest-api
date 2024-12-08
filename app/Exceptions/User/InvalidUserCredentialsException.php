<?php

namespace App\Exceptions\User;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvalidUserCredentialsException extends Exception
{
    public function render(Request $request): JsonResponse
    {
        return responseFailed($this->getMessage(), $this->getCode());
    }
}
