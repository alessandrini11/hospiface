<?php

namespace App\Controller\API;

use App\DTO\DrugRequest;
use App\DTO\GardeRequest;
use App\model\PaginationModel;
use App\Repository\GardeRepository;
use App\Service\GardeService;
use App\Service\PaginationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/gardes')]
class GardeController extends ApiController
{
    public function __construct(
        readonly private GardeService $gardeService,
        readonly private PaginationService $paginationService
    )
    {
    }

    #[Route('', name: 'api_garde_create', methods: 'POST')]
    public function create(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $gardeRequest = new GardeRequest($request);
        $validationError = $validator->validate($gardeRequest);
        $this->checkValidationError($validationError);
        $garde = $this->gardeService->create($gardeRequest, $this->getUser());
        return $this->response($garde, Response::HTTP_CREATED);
    }

    #[Route('', name: 'api_garde_getall', methods: 'GET')]
    public function getAll(Request $request, GardeRepository $gardeRepository): JsonResponse
    {
        $paginationModel = new PaginationModel($request);
        $array = $this->paginationService->getPaginatedItems($paginationModel, $gardeRepository);
        return $this->response($array);
    }
}