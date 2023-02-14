<?php

namespace App\Controller\API;

use App\DTO\Response;
use App\Exceptions\ApiException;
use App\Exceptions\ValidationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ApiController extends AbstractController
{
    public function response(
        $data = null,
        int $status = 200,
        bool $success = true,
        ?ApiException $exception = null
    ): JsonResponse
    {
        $response = new Response($data, $success, $exception);
        return parent::json($response, $status);
    }

    public function checkValidationError(ConstraintViolationListInterface $list): void
    {
        if(count($list))
        {
            throw new ValidationException($list);
        }
    }
}