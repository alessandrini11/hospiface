<?php

namespace App\Controller\API;

use App\DTO\MedicalServiceRequest;
use App\DTO\MedicalServiceResponse;
use App\Entity\Service;
use App\model\PaginationModel;
use App\Repository\ServiceRepository;
use App\Service\MedicalServiceService;
use App\Service\PaginationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        $medicalServiceRequest = $this->medicalServiceService->create($medicalServiceRequest, $this->getUser());
        return $this->response($medicalServiceRequest, Response::HTTP_CREATED);
    }

    #[Route('', name: 'api_medical_service_get_all', methods: 'GET')]
    public function getAll(Request $request, ServiceRepository $serviceRepository): JsonResponse
    {
        $paginationModel = new PaginationModel($request);
        $array = $this->paginationService->getPaginatedItems($paginationModel, $serviceRepository, Service::class);
        return $this->response($array);
    }
    #[Route('/{id}', name: 'api_get_one_medical_service', methods: 'GET')]
    public function getOne(int $id): JsonResponse
    {
        $medicalService = $this->medicalServiceService->findOrFail($id);
        return $this->response(new MedicalServiceResponse($medicalService));
    }
    #[Route('/{id}', name: 'api_medical_service_update_one', methods: 'PUT')]
    public function updateOne(int $id, Request $request, ValidatorInterface $validator): JsonResponse
    {
        $medicalService = $this->medicalServiceService->findOrFail($id);
        $medicalServiceRequest = new MedicalServiceRequest($request);
        $validationErrors = $validator->validate($medicalServiceRequest);
        $this->checkValidationError($validationErrors);
        $medicalServiceRequest = $this->medicalServiceService->update($medicalServiceRequest, $medicalService, $this->getUser());
        return $this->response($medicalServiceRequest);
    }

    #[Route('/{id}', name: 'api_delete_one_medical_service', methods: 'DELETE')]
    public function delete(int $id): JsonResponse
    {
        $this->medicalServiceService->delete($id);
        return $this->response([], Response::HTTP_NO_CONTENT);
    }

    #[Route('/attr/status', name: 'api_delete_one_medical_status', methods: 'GET')]
    public function status(): JsonResponse
    {
        return $this->response(array_flip(Service::STATUS));
    }
}