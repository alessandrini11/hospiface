<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class ForbiddenException extends ApiException
{
    public function __construct(string $message = 'Forbidden')
    {
        parent::__construct(Response::HTTP_FORBIDDEN, $message);
    }
}