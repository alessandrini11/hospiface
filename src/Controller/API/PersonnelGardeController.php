<?php

namespace App\Controller\API;

use App\DTO\PersonnelGardeRequest;
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
        readonly private PersonnelGardeService $personnelGardeService
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
}