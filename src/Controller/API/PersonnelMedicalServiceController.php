<?php

namespace App\Controller\API;

use App\DTO\PersonnelMedicalServiceRequest;
use App\model\PaginationModel;
use App\Repository\PersonnelServiceRepository;
use App\Service\PaginationService;
use App\Service\PersonnelMedicalServiceService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/personnel_services')]
class PersonnelMedicalServiceController extends ApiController
{
    public function __construct(
        readonly private PersonnelMedicalServiceService $personnelMedicalServiceService,
        readonly private PaginationService $paginationService
    )
    {
    }

    #[Route('', name: 'api_personnelMedicalService_create', methods: 'POST')]
    public function create(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $personnelServiceRequest = new PersonnelMedicalServiceRequest($request);
        $validationError = $validator->validate($personnelServiceRequest);
        $this->checkValidationError($validationError);
        $personnelService = $this->personnelMedicalServiceService->create($personnelServiceRequest, $this->getUser());
        return $this->response($personnelService, Response::HTTP_CREATED);
    }
    #[Route('', name: 'api_personnelMedicalService_getAll', methods: 'GET')]
    public function getAll(Request $request, PersonnelServiceRepository $personnelServiceRepository): JsonResponse
    {
        $paginationModel = new PaginationModel($request);
        $array = $this->paginationService->getPaginatedItems($paginationModel, $personnelServiceRepository);
        return $this->response($array);
    }
    #[Route('/{id}', name: 'api_personnelmedicalservice_update', methods: 'PUT')]
    public function update(int $id, Request $request, ValidatorInterface $validator): JsonResponse
    {
        $personnelService = $this->personnelMedicalServiceService->findOrFail($id);
        $personnelServiceRequest = new PersonnelMedicalServiceRequest($request);
        $validationError = $validator->validate($personnelServiceRequest);
        $this->checkValidationError($validationError);
        $updatedPersonnelService = $this->personnelMedicalServiceService->create($personnelServiceRequest, $this->getUser());
        return $this->response($updatedPersonnelService, Response::HTTP_CREATED);
    }
}