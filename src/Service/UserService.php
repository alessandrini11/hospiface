<?php

namespace App\Service;

use App\DTO\UserRequest;
use App\DTO\UserResponse;
use App\Entity\User;
use App\Exceptions\NotFoundException;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    private UserPasswordHasherInterface $hasher;
    private UserRepository $userRepository;
    public function __construct(
        UserPasswordHasherInterface $hasher,
        UserRepository $userRepository
    )
    {
        $this->hasher = $hasher;
        $this->userRepository = $userRepository;
    }

    public function create(UserRequest $userRequest): UserResponse
    {
        $user = $this->setFields($userRequest, new User());
        $user->setRoles([User::ROLE_USER]);
        $user->setStatus(User::STATUS_ENABLED);
        $this->userRepository->save($user, true);
        return new UserResponse($user);
    }

    public function update(UserRequest $userRequest, User $user): UserResponse
    {
        $userUpdate = $this->setFields($userRequest, $user);
        $this->userRepository->save($userUpdate, true);
        return new UserResponse($userUpdate);
    }

    public function delete(int $id): void
    {
        $user = $this->findOrFail($id);
        $this->userRepository->remove($user, true);
    }

    public function findOrFail(int $id): User
    {
        $user = $this->userRepository->find($id);
        if(!$user)
        {
            throw new NotFoundException();
        }
        return $user;
    }

    private function setFields(UserRequest $userRequest, User $user): User
    {
        if($userRequest->firstname) {
            $user->setFirstname($userRequest->firstname);
        }
        if($userRequest->lastname) {
            $user->setLastname($userRequest->lastname);
        }
        if($userRequest->sex) {
            $user->setSex($userRequest->sex);
        }
        if($userRequest->email){
            $user->setEmail($userRequest->email);
        }
        if($userRequest->password){
            $user->setPassword($this->hasher->hashPassword($user, $userRequest->password));
        }
        if($userRequest->phonenumber){
            $user->setPhonenumber($userRequest->phonenumber);
        }

        return $user;
    }
}