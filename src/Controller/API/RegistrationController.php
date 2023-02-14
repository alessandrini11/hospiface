<?php

namespace App\Controller\API;

use App\DTO\UserRequest;
use App\Service\RegistrationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationController extends ApiController
{
    public function __construct(
        private RegistrationService $registrationService
    )
    {
    }

    #[Route('/api/register', name: 'api_register', methods: 'POST')]
    public function register(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $userRequest = new UserRequest($request);
        $validationErrors = $validator->validate($userRequest);
        $this->checkValidationError($validationErrors);
        $userResponse = $this->registrationService->register($userRequest);
        return $this->response($userResponse , Response::HTTP_CREATED);
    }
}