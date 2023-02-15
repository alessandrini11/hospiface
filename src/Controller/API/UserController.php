<?php

namespace App\Controller\API;

use App\DTO\UserRequest;
use App\DTO\UserResponse;
use App\Repository\UserRepository;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends ApiController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    #[Route('/api/users', name: 'api_user_index', methods: 'GET')]
    public function index(UserRepository $userRepository): JsonResponse
    {
        $users = $userRepository->findAll();
        $array = [];
        foreach ($users as $user){
            $array[] = $user->getData();
        }

        return $this->response($array);
    }

    #[Route('/api/users/{id}', name: 'api_user_edit', methods: 'PATCH')]
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

    #[Route('/api/users/{id}', name: 'api_user_show', methods: 'GET')]
    public function show($id): JsonResponse
    {
        $user = $this->userService->findOrFail($id);
        $userResponse = new UserResponse($user);
        return $this->response($userResponse);
    }

    #[Route('/api/users/{id}', name: 'api_user_delete', methods: 'DELETE')]
    public function delete($id): JsonResponse
    {
        $this->userService->delete($id);
        return $this->response(null, Response::HTTP_NO_CONTENT);
    }
}