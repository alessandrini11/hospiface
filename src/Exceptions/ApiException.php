<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use JsonSerializable;
class ApiException extends HttpException implements JsonSerializable
{
    public function __construct(int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR, string $message = 'Internal Error')
    {
        parent::__construct($statusCode, $message);
    }

    public function jsonSerialize(): array
    {
        return [
            'message' => $this->getMessage(),
            'code' => $this->getStatusCode()
        ];
    }
}