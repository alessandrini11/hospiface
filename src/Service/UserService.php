<?php

namespace App\Service;

use App\DTO\UserRequest;
use App\DTO\UserResponse;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function create(UserRequest $userRequest): UserResponse
    {
        $user = $this->setFields($userRequest, new User());
        $user->setRoles([User::ROLE_USER]);
        $user->setStatus(User::STATUS_ENABLED);
        return new UserResponse($user);
    }

    private function setFields(UserRequest $userRequest, User $user): User
    {
        $user->setFirstname($userRequest->firstname);
        $user->setLastname($userRequest->lastname);
        $user->setSex($userRequest->sex);
        $user->setEmail($userRequest->email);
        $user->setPassword($this->hasher->hashPassword($user, $userRequest->password));
        $user->setPhonenumber($userRequest->phonenumber);

        return $user;
    }
}