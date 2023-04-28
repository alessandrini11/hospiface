<?php

namespace App\Service;

use App\DTO\MedicalServiceRequest;
use App\DTO\MedicalServiceResponse;
use App\Entity\Service;
use App\Exceptions\NotFoundException;
use App\Interface\EntityServiceInterface;
use App\Repository\ServiceRepository;

class MedicalServiceService implements EntityServiceInterface
{
    public function __construct(
        readonly private ServiceRepository $medicalServiceRepository
    )
    {
    }

    public function create($entityRequest, $loggedUser = null): MedicalServiceResponse
    {
        $medicalService = $this->setFields($entityRequest, new Service());
        $medicalService->setCreatedBy($loggedUser);
        $this->medicalServiceRepository->save($medicalService, true);
        return new MedicalServiceResponse($medicalService);
    }

    public function findOrFail(int $id): Service
    {
        $medicalService = $this->medicalServiceRepository->find($id);
        if(!$medicalService)
        {
            throw new NotFoundException();
        }
        return $medicalService;
    }

    public function update($entityRequest, $entity, $loggedUser = null): MedicalServiceResponse
    {
        $medicalService = $this->setFields($entityRequest, $entity);
        $medicalService->setUpdatedBy($loggedUser);
        $this->medicalServiceRepository->save($medicalService, true);
        return new MedicalServiceResponse($medicalService);
    }

    public function delete(int $id): void
    {
        $medicalService = $this->findOrFail($id);
        $this->medicalServiceRepository->remove($medicalService, true);
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