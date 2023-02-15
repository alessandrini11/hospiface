<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class OldPasswordAndNewPasswordNotMatchException extends BadRequestException
{
    public function __construct(int $statusCode = Response::HTTP_BAD_REQUEST, string $message = 'The Old Password And New Password Do Not Match')
    {
        parent::__construct($statusCode, $message);
    }
}