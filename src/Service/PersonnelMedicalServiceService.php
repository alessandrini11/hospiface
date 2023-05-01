<?php

namespace App\Service;

use App\DTO\PersonnelMedicalServiceRequest;
use App\DTO\PersonnelMedicalServiceResponse;
use App\Exceptions\NotFoundException;
use App\Interface\EntityServiceInterface;
use App\Service\PersonnelService as PersonServ;
use App\Entity\PersonnelService as PersonServEntity;
use App\Repository\PersonnelServiceRepository;
use App\Repository\ServiceRepository;

class PersonnelMedicalServiceService implements EntityServiceInterface
{
    public function __construct(
        readonly private PersonnelServiceRepository $personnelServiceRepository,
        readonly private PersonServ $personServ,
        readonly private MedicalServiceService $medicalServiceService
    )
    {
    }

    public function create($entityRequest, $loggedUser = null): PersonnelMedicalServiceResponse
    {
        $personnelService = $this->setFields($entityRequest, new PersonServEntity());
        $personnelService
            ->setCreatedBy($loggedUser);
        $this->personnelServiceRepository->save($personnelService, true);
        return new PersonnelMedicalServiceResponse($personnelService);
    }
    public function update($entityRequest, $entity, $loggedUser = null): PersonnelMedicalServiceResponse
    {
        $personnelService = $this->setFields($entityRequest, $entity);
        $personnelService
            ->setUpdateBy($loggedUser);
        $this->personnelServiceRepository->save($personnelService, true);
        return new PersonnelMedicalServiceResponse($personnelService);
    }

    public function findOrFail(int $id): PersonServEntity
    {
        $personnelService = $this->personnelServiceRepository->find($id);
        if (!$personnelService) throw new NotFoundException('Personnel Service Not Found');
        return $personnelService;
    }


    public function delete(int $id): void
    {
        $personnelService = $this->findOrFail($id);
        $this->personnelServiceRepository->remove($personnelService, true);
    }
    public function setFields($entityRequest, $entity): ?PersonServEntity
    {
        if (!$entityRequest instanceof PersonnelMedicalServiceRequest && !$entity instanceof PersonServEntity) return null;
        if($entityRequest->personnel){
            $personnel = $this->personServ->findOrFail($entityRequest->personnel);
            $entity->setPersonnel($personnel);
        }
        if($entityRequest->service){
            $service = $this->medicalServiceService->findOrFail($entityRequest->service);
            $entity->setService($service);
        }
        if($entityRequest->positionHeld){
            $entity->setPositionHeld($entityRequest->positionHeld);
        }
        return $entity;
    }

}