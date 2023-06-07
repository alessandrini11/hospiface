<?php

namespace App\Service;

use App\DTO\UpdatePasswordRequest;
use App\DTO\UserRequest;
use App\DTO\UserResponse;
use App\Entity\User;
use App\Exceptions\NotFoundException;
use App\Exceptions\OldPasswordAndNewPasswordNotMatchException;
use App\Exceptions\PasswordNotMatchException;
use App\Interface\EntityInterface;
use App\Interface\EntityServiceInterface;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService implements EntityServiceInterface
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

    /**
     * @param $entityRequest
     * @param null $loggedUser
     */
    public function create( $entityRequest, $loggedUser = null): UserResponse
    {
        $user = $this->setFields($entityRequest, new User());
        $this->userRepository->save($user, true);
        return new UserResponse($user);
    }

    public function update($entityRequest, $entity, $loggedUser = null): UserResponse
    {
        $userUpdate = $this->setFields($entityRequest, $entity);
        $this->userRepository->save($userUpdate, true);
        return new UserResponse($userUpdate);
    }

    public function resetPassword(User $user, string $password): void
    {
        $this->userRepository->upgradePassword($user, $password);
    }
    public function updatePassword(UpdatePasswordRequest $updatePasswordRequest, User $user): void
    {
        if($updatePasswordRequest->newPassword !== $updatePasswordRequest->repeatedPassword){
            throw new PasswordNotMatchException();
        }
        $isEqual = $this->hasher->isPasswordValid($user, $updatePasswordRequest->oldPassword);
        if(!$isEqual){
            throw new OldPasswordAndNewPasswordNotMatchException();
        }
        $this->userRepository->upgradePassword($user, $updatePasswordRequest->newPassword);
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

    public function setFields( $entityRequest,  $entity): null | User
    {
        if (!$entityRequest instanceof UserRequest && !$entity instanceof User) return null;
        if($entityRequest->firstname) {
            $entity->setFirstname($entityRequest->firstname);
        }
        if($entityRequest->lastname) {
            $entity->setLastname($entityRequest->lastname);
        }
        if($entityRequest->sex) {
            $entity->setSex($entityRequest->sex);
        }
        if($entityRequest->email){
            $entity->setEmail($entityRequest->email);
        }
        if($entityRequest->password){
            $entity->setPassword($this->hasher->hashPassword($entity, $entityRequest->password));
        }
        if($entityRequest->phonenumber){
            $entity->setPhonenumber($entityRequest->phonenumber);
        }
        if($entityRequest->status !== null){
            $entity->setStatus($entityRequest->status);
        }
        if($entityRequest->role){
            $entity->setRoles([$entityRequest->role]);
        }
        return $entity;
    }
}