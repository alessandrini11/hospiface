<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends ApiException implements \JsonSerializable
{
    private ConstraintViolationListInterface $list;
    public function __construct(
        ConstraintViolationListInterface $list,
        string $message = 'Bad Request')
    {
        $this->list = $list;
        parent::__construct(Response::HTTP_BAD_REQUEST, $message);
    }

    public function jsonSerialize(): array
    {
        $errors = [];
        foreach ($this->list as $error){
            $errors[] = [
                'propertyPath' => $error->getPropertyPath(),
                'message' => $error->getMessage()
            ];
        }
        return parent::jsonSerialize() + ['validationErrors' => $errors];
    }
}