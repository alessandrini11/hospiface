<?php

namespace App\Controller\API;

use App\DTO\UpdatePasswordRequest;
use App\DTO\UserBasicRequest;
use App\DTO\UserRequest;
use App\Service\AuthService;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthController extends ApiController
{
    public function __construct(
        private AuthService $authService,
        private UserService $userService
    )
    {
    }

    #[Route('/api/auth/register', name: 'api_auth_register', methods: 'POST')]
    public function register(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $userRequest = new UserRequest($request);
        $validationErrors = $validator->validate($userRequest);
        $this->checkValidationError($validationErrors);
        $userResponse = $this->authService->register($userRequest);
        return $this->response($userResponse , Response::HTTP_CREATED);
    }

    #[Route('/api/auth/update-password', name: 'api_auth_update_password', methods: 'PUT')]
    public function updatePassword(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $updatePasswordRequest = new UpdatePasswordRequest($request);
        $validationErrors = $validator->validate($updatePasswordRequest);
        $this->checkValidationError($validationErrors);
        $this->userService->updatePassword($updatePasswordRequest, $this->getUser());
        return $this->response();
    }

    #[Route('/api/auth/forget-password', name: 'api_auth_forget_password', methods: 'PUT')]
    public function forgetPassword(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $userBasicRequest = new UserBasicRequest($request);
        $validationError = $validator->validate($userBasicRequest);
        $this->checkValidationError($validationError);
        $this->userService->resetPassword($this->getUser(), $request->get('password'));
        // TODO: implements forget password according to the use case
    }
    #[Route('/api/auth/update', name: 'api_auth_update', methods: 'PATCH')]
    public function update(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $userRequest = new UserRequest($request);
        $validationErrors = $validator->validate($userRequest);
        $this->checkValidationError($validationErrors);
        $userResponse = $this->userService->update($userRequest, $this->getUser());
        return $this->response($userResponse);
    }
}