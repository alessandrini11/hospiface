<?php

namespace App\Service;

use App\DTO\PersonnelGardeRequest;
use App\Entity\PersonnelGarde;
use App\Exceptions\NotFoundException;
use App\Interface\EntityServiceInterface;
use App\Repository\PersonnelGardeRepository;

class PersonnelGardeService implements EntityServiceInterface
{
    public function __construct(
        private readonly PersonnelService $personnelService,
        private readonly MedicalServiceService $medicalServiceService,
        private readonly PersonnelGardeRepository $personnelGardeRepository,
        private readonly DateService $dateService
    )
    {
    }

    public function create($entityRequest, $loggedUser = null): PersonnelGarde
    {
        $personnelGarde = $this->setFields($entityRequest, new PersonnelGarde());
        $this->personnelGardeRepository->save($personnelGarde, true);
        return $personnelGarde;
    }

    public function update($entityRequest, $entity, $loggedUser = null): PersonnelGarde
    {
        $personnelGarde = $this->setFields($entityRequest, $entity);
        $this->personnelGardeRepository->save($personnelGarde, true);
        return $personnelGarde;
    }

    public function findOrFail(int $id): PersonnelGarde
    {
        $personnelGarde = $this->personnelGardeRepository->find($id);
        if(!$personnelGarde) throw new NotFoundException('Personnel Garde Not Found');
        return $personnelGarde;
    }
    public function delete(int $id): void
    {
        $personnelGarde = $this->findOrFail($id);
        $this->personnelGardeRepository->remove($personnelGarde, true);
    }
    public function setFields($entityRequest, $entity): ?PersonnelGarde
    {
        if (!$entityRequest instanceof PersonnelGardeRequest && !$entity instanceof PersonnelGarde) return null;
        if($entityRequest->startDate){
            $entity->setStartDate($entityRequest->startDate);
        }
        if($entityRequest->endDate){
            $this->dateService->compareDates($entityRequest->endDate, $entityRequest->startDate);
            $entity->setEndDate($entityRequest->endDate);
        }
        if($entityRequest->personnel){
            $personnel = $this->personnelService->findOrFail($entityRequest->personnel);
            $entity->setPersonnel($personnel);
        }
        if($entityRequest->service){
            $medicalService = $this->medicalServiceService->findOrFail($entityRequest->service);
            $entity->setService($medicalService);
        }
        return $entity;
    }

}