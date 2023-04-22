<?php

namespace App\Controller\API;

use App\DTO\PersonnelRequest;
use App\model\PaginationModel;
use App\Repository\PersonnelRepository;
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

    #[Route('', name: 'api_personnel_getAll', methods: 'GET')]
    public function getAll(Request $request, PersonnelRepository $personnelRepository): JsonResponse
    {
        $paginationModel = new PaginationModel($request);
        $array = $this->paginationService->getPaginatedItems($paginationModel, $personnelRepository);
        return $this->response($array);
    }

    #[Route('/{id}', name: 'api_personnel_getOne', methods: 'GET')]
    public function getOne(int $id,PersonnelRepository $personnelRepository): JsonResponse
    {
        $personnel = $this->personnelService->findOrFail($id);
        return $this->response($personnel);
    }
}