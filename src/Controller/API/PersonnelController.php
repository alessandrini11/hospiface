<?php

namespace App\Controller\API;

use App\DTO\PersonnelRequest;
use App\DTO\PersonnelResponse;
use App\Entity\Personnel;
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
        $personnelResponse = $this->personnelService->create($personnelRequest, $this->getUser());
        return $this->response($personnelResponse, Response::HTTP_CREATED);
    }

    #[Route('', name: 'api_personnel_getAll', methods: 'GET')]
    public function getAll(Request $request, PersonnelRepository $personnelRepository): JsonResponse
    {
        $paginationModel = new PaginationModel($request);
        $array = $this->paginationService->getPaginatedItems($paginationModel, $personnelRepository, Personnel::class);
        return $this->response($array);
    }

    #[Route('/{id}', name: 'api_personnel_getOne', methods: 'GET')]
    public function getOne(int $id): JsonResponse
    {
        $personnel = $this->personnelService->findOrFail($id);
        return $this->response(new PersonnelResponse($personnel));
    }

    #[Route('/{id}', name: 'api_personnel_updateOne', methods: 'PUT')]
    public function updateOne(int $id, Request $request, ValidatorInterface $validator): JsonResponse
    {
        $personnel = $this->personnelService->findOrFail($id);
        $personnelRequest = new PersonnelRequest($request);
        $validationError = $validator->validate($personnelRequest);
        $this->checkValidationError($validationError);
        $personnelResponse = $this->personnelService->update($personnelRequest, $personnel, $this->getUser());
        return $this->response($personnelResponse);
    }

    #[Route('/{id}', name: 'api_personnel_delete', methods: 'DELETE')]
    public function delete(int $id): JsonResponse
    {
        $this->personnelService->delete($id);
        return $this->response([], Response::HTTP_NO_CONTENT);
    }

    #[Route('/attr/types', name: 'api_personnel_types', methods: 'GET')]
    public function types(): JsonResponse
    {
        return $this->response(Personnel::TYPES);
    }
    #[Route('/attr/status', name: 'api_personnel_status', methods: 'GET')]
    public function status(): JsonResponse
    {
        return $this->response(array_flip(Personnel::STATUSES));
    }
    #[Route('/attr/titles', name: 'api_personnel_titles', methods: 'GET')]
    public function titles(): JsonResponse
    {
        return $this->response(Personnel::TITLES);
    }
    #[Route('/attr/positions', name: 'api_personnel_position', methods: 'GET')]
    public function positions(): JsonResponse
    {
        return $this->response(Personnel::POSITIONS);
    }
}