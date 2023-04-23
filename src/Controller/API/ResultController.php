<?php

namespace App\Controller\API;

use App\DTO\ResultRequest;
use App\Service\ResultService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/results')]
class ResultController extends ApiController
{
    public function __construct(
        readonly private ResultService $resultService
    )
    {
    }

    #[Route('/{id}', name: 'api_result_update', methods: 'PUT')]
    public function update(int $id, Request $request, ValidatorInterface $validator): JsonResponse
    {
        $result = $this->resultService->findOrFail($id);
        $resultRequest = new ResultRequest($request);
        $validationErrors = $validator->validate($resultRequest);
        $this->checkValidationError($validationErrors);
        $updatedResult = $this->resultService->update($resultRequest, $result, $this->getUser());
        return $this->response($updatedResult, Response::HTTP_CREATED);
    }
}