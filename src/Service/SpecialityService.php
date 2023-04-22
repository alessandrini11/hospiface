<?php

namespace App\Service;

use App\DTO\SpecialityRequest;
use App\Entity\Speciality;
use App\Exceptions\NotFoundException;
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

    public function findOrFail(int $id): Speciality
    {
        $speciality = $this->specialityRepository->find($id);
        if (!$speciality) throw new NotFoundException('Speciality Not Found');
        return $speciality;
    }

    public function update($entityRequest, $entity, $loggedUser = null): Speciality
    {
        $speciality = $this->setFields($entityRequest, $entity);
        $speciality->setUpdatedBy($loggedUser);
        $this->specialityRepository->save($speciality, true);
        return $speciality;
    }

    public function delete(int $id): void
    {
        $speciality = $this->findOrFail($id);
        $this->specialityRepository->remove($speciality, true);
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