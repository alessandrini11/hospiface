<?php

namespace App\Service;

use App\DTO\GardeRequest;
use App\Entity\Garde;
use App\Exceptions\NotFoundException;
use App\Interface\EntityServiceInterface;
use App\Repository\GardeRepository;

class GardeService implements EntityServiceInterface
{
    public function __construct(
        readonly private GardeRepository $gardeRepository,
        readonly private DateService $dateService
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
    public function update($entityRequest, $entity, $loggedUser = null): Garde
    {
        $garde = $this->setFields($entityRequest, $entity);
        $garde->setUpdatedBy($loggedUser);
        $this->gardeRepository->save($garde, true);
        return $garde;
    }
    public function findOrFail(int $id): Garde
    {
       $garde = $this->gardeRepository->find($id);
       if (!$garde) throw new NotFoundException('Gard Not Found');
       return $garde;
    }
    public function delete(int $id): void
    {
        $garde = $this->findOrFail($id);
        $this->gardeRepository->remove($garde, true);
    }
    public function setFields($entityRequest, $entity): ?Garde
    {
        if (!$entityRequest instanceof GardeRequest && !$entity instanceof Garde) return null;
        $this->dateService->compareDates($entityRequest->endDate, $entityRequest->startDate);
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