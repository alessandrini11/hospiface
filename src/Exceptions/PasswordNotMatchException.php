<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class PasswordNotMatchException extends BadRequestException
{
    public function __construct(int $statusCode = Response::HTTP_BAD_REQUEST, string $message = 'Passwords Do Not Match')
    {
        parent::__construct($statusCode, $message);
    }
}