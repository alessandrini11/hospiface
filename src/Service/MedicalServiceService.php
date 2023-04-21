<?php

namespace App\Service;

use App\DTO\MedicalServiceRequest;
use App\Entity\Service;
use App\Interface\EntityServiceInterface;
use App\Repository\ServiceRepository;

class MedicalServiceService implements EntityServiceInterface
{
    public function __construct(
        readonly private ServiceRepository $medicalServiceRepository
    )
    {
    }

    public function create($entityRequest, $loggedUser = null): Service
    {
        $medicalService = $this->setFields($entityRequest, new Service());
        $medicalService->setCreatedBy($loggedUser);
        $this->medicalServiceRepository->save($medicalService, true);
        return $medicalService;
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

    public function setFields($entityRequest, $entity): ?Service
    {
        if (!$entityRequest instanceof MedicalServiceRequest && !$entity instanceof Service) return null;
        if ($entityRequest->name){
            $entity->setName($entityRequest->name);
        }
        if ($entityRequest->status){
            $entity->setStatus($entityRequest->status);
        }
        return $entity;
    }
}