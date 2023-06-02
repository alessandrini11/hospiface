<?php

namespace App\Controller\API;

use App\DTO\UserRequest;
use App\DTO\UserResponse;
use App\Entity\User;
use App\model\PaginationModel;
use App\Repository\UserRepository;
use App\Service\PaginationService;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/users')]
class UserController extends ApiController
{
    private UserService $userService;
    private PaginationService $paginationService;

    public function __construct(UserService $userService, PaginationService $paginationService)
    {
        $this->userService = $userService;
        $this->paginationService = $paginationService;
    }
    #[Route('', name: 'api_user_create', methods: 'POST')]
    public function create(
        Request $request,
        ValidatorInterface $validator
    ): JsonResponse
    {
        $userRequest = new UserRequest($request);
        $validationError = $validator->validate($userRequest);
        $this->checkValidationError($validationError);
        $userResponse = $this->userService->create($userRequest);
        return $this->response($userResponse, Response::HTTP_CREATED);
    }
    #[Route('', name: 'api_user_index', methods: 'GET')]
    public function index(Request $request, UserRepository $userRepository): JsonResponse
    {
        $paginationModel = new PaginationModel($request);
        $array = $this->paginationService->getPaginatedItems($paginationModel, $userRepository, User::class);
        return $this->response($array);
    }
    #[Route('/profile', name: 'api_user_profile', methods: 'GET')]
    public function profile(): JsonResponse
    {
        return $this->response($this->getUser()->getData());
    }
    #[Route('/{id}', name: 'api_user_edit', methods: 'PUT')]
    public function edit(
        int $id,
        Request $request,
        ValidatorInterface $validator
    ): JsonResponse
    {
        $user = $this->userService->findOrFail($id);
        $userRequest = new UserRequest($request);
        $validationError = $validator->validate($userRequest);
        $this->checkValidationError($validationError);
        $userResponse = $this->userService->update($userRequest, $user);
        return $this->response($userResponse);
    }

    #[Route('/{id}', name: 'api_user_show', methods: 'GET')]
    public function show($id): JsonResponse
    {
        $user = $this->userService->findOrFail($id);
        $userResponse = new UserResponse($user);
        return $this->response($userResponse);
    }

    #[Route('/{id}', name: 'api_user_delete', methods: 'DELETE')]
    public function delete($id): JsonResponse
    {
        $this->userService->delete($id);
        return $this->response(null, Response::HTTP_NO_CONTENT);
    }
}