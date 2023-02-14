<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class NotFoundException extends ApiException
{
    public function __construct(string $message = 'Not Found')
    {
        parent::__construct(Response::HTTP_NOT_FOUND, $message);
    }
}