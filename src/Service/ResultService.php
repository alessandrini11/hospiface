<?php

namespace App\Service;

use App\DTO\ResultRequest;
use App\Entity\Result;
use App\Exceptions\NotFoundException;
use App\Interface\BasicEntityServiceInterface;
use App\Repository\ResultRepository;

class ResultService implements BasicEntityServiceInterface
{
    public function __construct(
        readonly private ResultRepository $resultRepository
    )
    {
    }

    public function update($entityRequest, $entity, $loggedUser = null): Result
    {
        $result = $this->setFields($entityRequest, $entity);
        $result->setUpdatedBy($loggedUser);
        $this->resultRepository->save($result, true);
        return $result;
    }

    public function findOrFail(int $id)
    {
        $result = $this->resultRepository->find($id);
        if(!$result) throw new NotFoundException('Result Not Found');
        return $result;
    }

    public function setFields($entityRequest, $entity): ?Result
    {
        if(!$entityRequest instanceof ResultRequest && !$entity instanceof Result) return null;
        if($entityRequest->interpretation){
            $entity->setInterpretation($entityRequest->interpretation);
        }
        return $entity;
    }
}