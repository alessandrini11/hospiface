<?php

namespace App\Controller\API;

use App\DTO\MedicalServiceRequest;
use App\model\PaginationModel;
use App\Repository\ServiceRepository;
use App\Service\MedicalServiceService;
use App\Service\PaginationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/medical_services')]
class MedicalServiceController extends ApiController
{
    public function __construct(
        readonly private MedicalServiceService $medicalServiceService,
        readonly private PaginationService $paginationService
    )
    {
    }

    #[Route('', name: 'api_medical_service_create', methods: 'POST')]
    public function create(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $medicalServiceRequest = new MedicalServiceRequest($request);
        $validationErrors = $validator->validate($medicalServiceRequest);
        $this->checkValidationError($validationErrors);
        $medicalService = $this->medicalServiceService->create($medicalServiceRequest, $this->getUser());
        return $this->response($medicalService);
    }

    #[Route('', name: 'api_medical_service_get_all', methods: 'GET')]
    public function getAll(Request $request, ServiceRepository $serviceRepository): JsonResponse
    {
        $paginationModel = new PaginationModel($request);
        $array = $this->paginationService->getPaginatedItems($paginationModel, $serviceRepository);
        return $this->response($array);
    }
    #[Route('/{id}', name: 'api_get_one_medical_service', methods: 'GET')]
    public function getOne(int $id): JsonResponse
    {
        $medicalService = $this->medicalServiceService->findOrFail($id);
        return $this->response($medicalService);
    }
}