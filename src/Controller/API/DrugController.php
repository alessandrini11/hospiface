<?php

namespace App\Controller\API;

use App\DTO\DrugRequest;
use App\DTO\DrugResponse;
use App\DTO\MedicalExamRequest;
use App\Entity\Drug;
use App\model\PaginationModel;
use App\Repository\DrugRepository;
use App\Service\DrugService;
use App\Service\PaginationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/drugs')]
class DrugController extends ApiController
{
    public function __construct(
        readonly private DrugService $drugService,
        readonly private PaginationService $paginationService
    )
    {
    }

    #[Route('', name: 'api_drug_create', methods: 'POST')]
    public function create(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $drugRequest = new DrugRequest($request);
        $validationError = $validator->validate($drugRequest);
        $this->checkValidationError($validationError);
        $drugResponse = $this->drugService->create($drugRequest, $this->getUser());
        return $this->response($drugResponse, Response::HTTP_CREATED);
    }
    #[Route('', name: 'api_drug_getall', methods: 'GET')]
    public function getAll(Request $request, DrugRepository $drugRepository): JsonResponse
    {
        $paginationModel = new PaginationModel($request);
        $array = $this->paginationService->getPaginatedItems($paginationModel, $drugRepository, Drug::class);
        return $this->response($array);
    }
    #[Route('/{id}', name: 'api_drug_getone', methods: 'GET')]
    public function getOne(int $id): JsonResponse
    {
        $drug = $this->drugService->findOrFail($id);
        return $this->response(new DrugResponse($drug));
    }
    #[Route('/{id}', name: 'api_drug_update', methods: 'PUT')]
    public function update(int $id, Request $request, ValidatorInterface $validator): JsonResponse
    {
        $drug = $this->drugService->findOrFail($id);
        $drugRequest = new DrugRequest($request);
        $validationError = $validator->validate($drugRequest);
        $this->checkValidationError($validationError);
        $drugResponse = $this->drugService->update($drugRequest, $drug, $this->getUser());
        return $this->response($drugResponse);
    }
    #[Route('/{id}', name: 'api_drug_delete', methods: 'DELETE')]
    public function delete(int $id): JsonResponse
    {
        $this->drugService->delete($id);
        return $this->response([], Response::HTTP_NO_CONTENT);
    }
}