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

#[Route("/api/auth/")]
class AuthController extends ApiController
{
    public function __construct(
        private AuthService $authService,
        private UserService $userService
    )
    {
    }

    #[Route('login', 'api_login', methods: 'POST')]
    public function login(): void
    {

    }
    #[Route('register', name: 'api_auth_register', methods: 'POST')]
    public function register(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $userRequest = new UserRequest($request);
        $validationErrors = $validator->validate($userRequest);
        $this->checkValidationError($validationErrors);
        $userResponse = $this->authService->register($userRequest);
        return $this->response($userResponse , Response::HTTP_CREATED);
    }

    #[Route('update-password', name: 'api_auth_update_password', methods: 'PUT')]
    public function updatePassword(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $updatePasswordRequest = new UpdatePasswordRequest($request);
        $validationErrors = $validator->validate($updatePasswordRequest);
        $this->checkValidationError($validationErrors);
        $this->userService->updatePassword($updatePasswordRequest, $this->getUser());
        return $this->response();
    }

    #[Route('forget-password', name: 'api_auth_forget_password', methods: 'PUT')]
    public function forgetPassword(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $userBasicRequest = new UserBasicRequest($request);
        $validationError = $validator->validate($userBasicRequest);
        $this->checkValidationError($validationError);
        $this->userService->resetPassword($this->getUser(), $request->get('password'));
        return $this->response(['message' => 'password updated']);
    }
    #[Route('update', name: 'api_auth_update', methods: 'PATCH')]
    public function update(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $userRequest = new UserRequest($request);
        $validationErrors = $validator->validate($userRequest);
        $this->checkValidationError($validationErrors);
        $userResponse = $this->userService->update($userRequest, $this->getUser());
        return $this->response($userResponse);
    }
    #[Route('logout', name: 'api_logout', methods: 'GET')]
    public function logout(): void {}

}