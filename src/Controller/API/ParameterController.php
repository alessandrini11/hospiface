<?php

namespace App\Controller\API;

use App\DTO\ParameterRequest;
use App\Service\ParameterService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/parameters')]
class ParameterController extends ApiController
{
    public function __construct(
        readonly private ParameterService $parameterService
    )
    {
    }

    #[Route('/{id}', name: 'api_parameter_update', methods: 'PUT')]
    public function update(int $id, Request $request, ValidatorInterface $validator): JsonResponse
    {
        $parameter = $this->parameterService->findOrFail($id);
        $parameterRequest = new ParameterRequest($request);
        $validationError = $validator->validate($parameterRequest);
        $this->checkValidationError($validationError);
        $updatedParameter = $this->parameterService->update($parameterRequest, $this->getUser());
        return $this->response($updatedParameter);
    }
}