<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class BadRequestException extends ApiException
{
    public function __construct(string $message = 'Bad Request')
    {
        parent::__construct(Response::HTTP_BAD_REQUEST, $message);
    }
}