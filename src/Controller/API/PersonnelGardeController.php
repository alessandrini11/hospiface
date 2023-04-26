<?php

namespace App\Controller\API;

use App\DTO\PersonnelGardeRequest;
use App\model\PaginationModel;
use App\Repository\PersonnelGardeRepository;
use App\Service\PaginationService;
use App\Service\PersonnelGardeService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/personnel_gardes')]
class PersonnelGardeController extends ApiController
{
    public function __construct(
        readonly private PersonnelGardeService $personnelGardeService,
        readonly private PaginationService $paginationService
    )
    {
    }

    #[Route('', name: 'api_personnel_garde_create', methods: 'POST')]
    public function create(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $personnelGardeRequest = new PersonnelGardeRequest($request);
        $validationErrors = $validator->validate($personnelGardeRequest);
        $this->checkValidationError($validationErrors);
        $personnelGarde = $this->personnelGardeService->create($personnelGardeRequest);
        return $this->response($personnelGarde, Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'api_personnel_garde_one', methods: 'GET')]
    public function one(int $id): JsonResponse
    {
        $personnelGarde = $this->personnelGardeService->findOrFail($id);
        return $this->response($personnelGarde);
    }

    #[Route('/{id}', name: 'api_personnel_garde_update', methods: 'PUT')]
    public function update(int $id, Request $request, ValidatorInterface $validator): JsonResponse
    {
        $personnelGarde = $this->personnelGardeService->findOrFail($id);
        $personnelGardeRequest = new PersonnelGardeRequest($request);
        $validationErrors = $validator->validate($personnelGardeRequest);
        $this->checkValidationError($validationErrors);
        $updatedPersonnelGarde = $this->personnelGardeService->update($personnelGardeRequest, $personnelGarde);
        return $this->response($updatedPersonnelGarde);
    }

    #[Route('/{id}', name: 'api_personnel_garde_delete', methods: 'DELETE')]
    public function delete(int $id): JsonResponse
    {
        $this->personnelGardeService->delete($id);
        return $this->response([], Response::HTTP_NO_CONTENT);
    }
}