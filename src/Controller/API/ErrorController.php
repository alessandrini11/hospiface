<?php

namespace App\Controller\API;

use App\Exceptions\ApiException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ErrorController extends ApiController
{
    public function show(\Throwable $exception): JsonResponse
    {
        if($exception instanceof ApiException)
        {
            return $this->response(
                null,
                $exception->getStatusCode(),
                false,
                $exception
            );
        }

        if($exception instanceof HttpException)
        {
            return $this->response(
                null,
                $exception->getStatusCode(),
                false,
                new ApiException($exception->getStatusCode(), $exception->getMessage())
            );
        }
        return $this->response(
            null,
            Response::HTTP_INTERNAL_SERVER_ERROR,
            false,
            new ApiException()
        );
    }
}