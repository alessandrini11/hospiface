<?php

namespace App\Controller\API;

use App\DTO\PersonnelRequest;
use App\Service\PaginationService;
use App\Service\PersonnelService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/personnels')]
class PersonnelController extends ApiController
{
    public function __construct(
        readonly private PersonnelService $personnelService,
        readonly private PaginationService $paginationService
    )
    {
    }

    #[Route('', name: 'api_personnel_create', methods: 'POST')]
    public function create(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $personnelRequest = new PersonnelRequest($request);
        $validationError = $validator->validate($personnelRequest);
        $this->checkValidationError($validationError);
        $patientResponse = $this->personnelService->create($personnelRequest, $this->getUser());
        return $this->response($patientResponse, Response::HTTP_CREATED);
    }
}