<?php

namespace App\Service;

use App\DTO\ConsultationRequest;
use App\DTO\ParameterRequest;
use App\Entity\Parametre;
use App\Exceptions\NotFoundException;
use App\Interface\BasicEntityServiceInterface;
use App\Repository\ParametreRepository;

class ParameterService implements BasicEntityServiceInterface
{
    public function __construct(
        readonly private ParametreRepository $parametreRepository
    )
    {
    }
    public function create(ConsultationRequest $consultationRequest): Parametre
    {
        $parameter = new Parametre();
        $parameter->setHeight($consultationRequest->height);
        $parameter->setWeight($consultationRequest->weight);
        $parameter->setTemparature($consultationRequest->temperature);
        $parameter->setBloodPressure($consultationRequest->bloodPressure);
        $this->parametreRepository->save($parameter);
        return $parameter;
    }
    public function update($entityRequest, $entity, $loggedUser = null): Parametre
    {
        $parameter = $this->setFields($entityRequest, $entity);
        $parameter->setCreatedBy($loggedUser);
        $this->parametreRepository->save($parameter, true);
        return $parameter;
    }
    public function findOrFail(int $id): Parametre
    {
        $parameter = $this->parametreRepository->find($id);
        if(!$parameter) throw new NotFoundException('Parameter Not Found');
        return $parameter;
    }
    public function setFields($entityRequest, $entity): ?Parametre
    {
        if (!$entityRequest instanceof ParameterRequest && !$entity instanceof Parametre) return null;
        if ($entityRequest->temperature){
            $entity->setTemparature($entityRequest->temperature);
        }
        if ($entityRequest->bloodPressure){
            $entity->setBloodPressure($entityRequest->bloodPressure);
        }
        if ($entityRequest->height){
            $entity->setHeight($entityRequest->height);
        }
        if ($entityRequest->weight){
            $entity->setWeight($entityRequest->weight);
        }
        return $entity;
    }
}