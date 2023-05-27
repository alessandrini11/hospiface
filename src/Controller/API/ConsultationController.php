<?php

namespace App\Controller\API;

use App\DTO\ConsultationRequest;
use App\DTO\ConsultationResponse;
use App\Entity\Consultation;
use App\model\PaginationModel;
use App\Repository\ConsultationRepository;
use App\Service\ConsultationService;
use App\Service\PaginationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/consultations')]
class ConsultationController extends ApiController
{
    public function __construct(
        readonly private ConsultationService $consultationService,
        readonly private PaginationService $paginationService
    )
    {
    }

    #[Route('', name: 'api_consultation_create', methods: 'POST')]
    public function create(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $consultationRequest = new ConsultationRequest($request);
        $validationError = $validator->validate($consultationRequest);
        $this->checkValidationError($validationError);
        $consultationResponse = $this->consultationService->create($consultationRequest, $this->getUser());
        return $this->response($consultationResponse, Response::HTTP_CREATED);
    }

    #[Route('', name: 'app_api_consultation_getAll', methods: 'GET')]
    public function getAll(Request $request, ConsultationRepository $consultationRepository): JsonResponse
    {
        $paginationModel = new PaginationModel($request);
        $array = $this->paginationService->getPaginatedItems($paginationModel, $consultationRepository, Consultation::class);
        return $this->response($array);
    }

    #[Route('/{id}', name: 'api_consultation_getOne', methods: 'GET')]
    public function getOne(int $id): JsonResponse
    {
        $consultation = $this->consultationService->findOrFail($id);
        return $this->response(new ConsultationResponse($consultation));
    }

    #[Route('/{id}', name: 'api_consultation_updateOne', methods: 'PUT')]
    public function updateOne(int $id, Request $request, ValidatorInterface $validator): JsonResponse
    {
        $consultation = $this->consultationService->findOrFail($id);
        $consultationRequest = new ConsultationRequest($request);
        $validationError = $validator->validate($consultationRequest);
        $this->checkValidationError($validationError);
        $consultationResponse = $this->consultationService->update($consultationRequest, $consultation, $this->getUser());
        return $this->response($consultationResponse);
    }

    #[Route('/{id}', name: 'api_consultation_delete', methods: 'DELETE')]
    public function delete(int $id): JsonResponse
    {
        $this->consultationService->delete($id);
        return $this->response([], Response::HTTP_NO_CONTENT);
    }
}