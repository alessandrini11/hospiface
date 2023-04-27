<?php

namespace App\Controller\API;

use App\DTO\HospitalisationRequest;
use App\model\PaginationModel;
use App\Repository\HospitilizationRepository;
use App\Service\HospitalizationService;
use App\Service\PaginationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/hospitalizations')]
class HospitalizationController extends ApiController
{
    public function __construct(
        readonly private HospitalizationService $hospitalizationService,
        readonly private PaginationService $paginationService
    )
    {
    }

    #[Route('', name: 'api_hospitalization_create', methods: 'POST')]
    public function create(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $hospitRequest = new HospitalisationRequest($request);
        $validationErrors = $validator->validate($hospitRequest);
        $this->checkValidationError($validationErrors);
        $hospitalization = $this->hospitalizationService->create($hospitRequest, $this->getUser());
        return $this->response($hospitalization, Response::HTTP_CREATED);
    }

    #[Route('', name: 'api_hospitalization_all', methods: 'GET')]
    public function all(Request $request, HospitilizationRepository $hospitilizationRepository): JsonResponse
    {
        $paginationModel = new PaginationModel($request);
        $array = $this->paginationService->getPaginatedItems($paginationModel, $hospitilizationRepository);
        return $this->response($array);
    }
}