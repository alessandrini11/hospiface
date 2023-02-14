<?php

namespace App\Service;

use App\DTO\UserRequest;
use App\DTO\UserResponse;
use App\Entity\User;

class RegistrationService
{
    private UserService $userService;
    public function __construct(
        UserService $userService
    )
    {
        $this->userService = $userService;
    }

    public function register(UserRequest $userRequest): UserResponse
    {
        return $this->userService->create($userRequest);
    }
}