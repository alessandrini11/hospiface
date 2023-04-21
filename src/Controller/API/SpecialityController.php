<?php

namespace App\Controller\API;

use App\DTO\SpecialityRequest;
use App\model\PaginationModel;
use App\Repository\SpecialityRepository;
use App\Service\PaginationService;
use App\Service\SpecialityService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/specialities')]
class SpecialityController extends ApiController
{
    public function __construct(
        readonly private SpecialityService $specialityService,
        readonly private PaginationService $paginationService
    )
    {
    }

    #[Route('', name: 'api_speciality_create', methods: 'POST')]
    public function create(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $specialityRequest = new SpecialityRequest($request);
        $validationErrors = $validator->validate($specialityRequest);
        $this->checkValidationError($validationErrors);
        $speciality = $this->specialityService->create($specialityRequest, $this->getUser());
        return $this->response($speciality);
    }

    #[Route('', name: 'api_speciality_getAll', methods: 'GET')]
    public function getAll(Request $request, SpecialityRepository $specialityRepository): JsonResponse
    {
        $paginationModel = new PaginationModel($request);
        $array = $this->paginationService->getPaginatedItems($paginationModel, $specialityRepository);
        return $this->response($array);
    }
}