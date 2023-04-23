<?php

namespace App\Service;

use App\DTO\GardeRequest;
use App\Entity\Garde;
use App\Interface\EntityServiceInterface;
use App\Repository\GardeRepository;

class GardeService implements EntityServiceInterface
{
    public function __construct(
        readonly private GardeRepository $gardeRepository
    )
    {
    }

    public function create($entityRequest, $loggedUser = null): Garde
    {
        $garde = $this->setFields($entityRequest, new Garde());
        $garde->setCreatedBy($loggedUser);
        $this->gardeRepository->save($garde, true);
        return $garde;
    }
    public function update($entityRequest, $entity, $loggedUser = null)
    {
        // TODO: Implement update() method.
    }
    public function findOrFail(int $id)
    {
        // TODO: Implement findOrFail() method.
    }
    public function delete(int $id): void
    {
        // TODO: Implement delete() method.
    }
    public function setFields($entityRequest, $entity): ?Garde
    {
        if (!$entityRequest instanceof GardeRequest && !$entity instanceof Garde) return null;
        if($entityRequest->startDate){
            $entity->setStartDate($entityRequest->startDate);
        }
        if($entityRequest->endDate){
            $entity->setEndDate($entityRequest->endDate);
        }
        if($entityRequest->status){
            $entity->setStatus($entityRequest->status);
        }
        return $entity;
    }
}