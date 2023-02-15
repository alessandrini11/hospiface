<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class BadRequestException extends ApiException
{
    public function __construct(int $statusCode = Response::HTTP_BAD_REQUEST, string $message = 'Bad Request')
    {
        parent::__construct($statusCode, $message);
    }
}