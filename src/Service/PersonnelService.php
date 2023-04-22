<?php

namespace App\Service;

use App\DTO\PersonnelRequest;
use App\Entity\Personnel;
use App\Interface\EntityServiceInterface;
use App\Repository\PersonnelRepository;

class PersonnelService implements EntityServiceInterface
{
    public function __construct(
        readonly private PersonnelRepository $personnelRepository,
        readonly private SpecialityService $specialityService
    )
    {
    }

    public function create($entityRequest, $loggedUser = null): Personnel
    {
        $personnel = $this->setFields($entityRequest, new Personnel());
        $personnel->setCreatedBy($loggedUser);
        $this->personnelRepository->save($personnel, true);
        return $personnel;
    }

    public function findOrFail(int $id)
    {
        // TODO: Implement findOrFail() method.
    }

    public function update($entityRequest, $entity, $loggedUser = null)
    {
        // TODO: Implement update() method.
    }

    public function delete(int $id): void
    {
        // TODO: Implement delete() method.
    }

    public function setFields($entityRequest, $entity): ?Personnel
    {
        if (!$entityRequest instanceof PersonnelRequest && !$entity instanceof Personnel) return null;
        if ($entityRequest->firstName){
            $entity->setFirstname($entityRequest->firstName);
        }
        if ($entityRequest->lastName){
            $entity->setLastname($entityRequest->lastName);
        }
        if ($entityRequest->email){
            $entity->setEmail($entityRequest->email);
        }
        if ($entityRequest->phoneNumber){
            $entity->setPhonenumber($entityRequest->phoneNumber);
        }
        if ($entityRequest->sex){
            $entity->setSex($entityRequest->sex);
        }
        if ($entityRequest->bloodGroup){
            $entity->setBloodGroup($entityRequest->bloodGroup);
        }
        if ($entityRequest->birthDate){
            $entity->setBirthDate($entityRequest->birthDate);
        }
        if ($entityRequest->type){
            $entity->setType($entityRequest->type);
        }
        if ($entityRequest->subType){
            $entity->setSubType($entityRequest->subType);
        }
        if ($entityRequest->speciality){
            $speciality = $this->specialityService->findOrFail($entityRequest->speciality);
            $entity->setSpeciality($speciality);
        }
        if ($entityRequest->title){
            $entity->setTitle($entityRequest->title);
        }
        if ($entityRequest->positionHeld){
            $entity->setPositionHeld($entityRequest->positionHeld);
        }
        if ($entityRequest->status){
            $entity->setStatus($entityRequest->status);
        }
        return $entity;
    }
}