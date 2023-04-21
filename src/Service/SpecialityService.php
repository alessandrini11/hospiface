<?php

namespace App\Service;

use App\DTO\SpecialityRequest;
use App\Entity\Speciality;
use App\Interface\EntityServiceInterface;
use App\Repository\SpecialityRepository;

class SpecialityService implements EntityServiceInterface
{
    public function __construct(
        readonly private SpecialityRepository $specialityRepository
    )
    {
    }

    public function create($entityRequest, $loggedUser = null): Speciality
    {
        $speciality = $this->setFields($entityRequest, new Speciality());
        $speciality->setCreatedBy($loggedUser);
        $this->specialityRepository->save($speciality, true);
        return $speciality;
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

    public function setFields($entityRequest, $entity): ?Speciality
    {
        if (!$entityRequest instanceof SpecialityRequest && !$entity instanceof Speciality) return null;
        if($entityRequest->name){
            $entity->setName($entityRequest->name);
        }
        return $entity;
    }
}