<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class UnauthorizedException extends ApiException
{
    public function __construct(string $message = 'Unauthorized')
    {
        parent::__construct(Response::HTTP_UNAUTHORIZED, $message);
    }
}