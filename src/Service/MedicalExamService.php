<?php

namespace App\Service;

use App\DTO\MedicalExamRequest;
use App\Entity\MedicalExams;
use App\Interface\EntityServiceInterface;
use App\Repository\MedicalExamsRepository;
use Doctrine\ORM\EntityManagerInterface;

class MedicalExamService implements EntityServiceInterface
{
    public function __construct(
        readonly private MedicalExamsRepository $medicalExamsRepository,
        readonly private ResultService $resultService,
        readonly private EntityManagerInterface $entityManager
    )
    {
    }

    public function create($entityRequest, $loggedUser = null): MedicalExams
    {
        $result = $this->resultService->findOrFail($entityRequest->result);
        $medicalExam = $this->setFields($entityRequest, new MedicalExams());
        $medicalExam->setCreatedBy($loggedUser);
        $result->addMedicalExam($medicalExam);
        $this->entityManager->persist($result);
        $this->entityManager->persist($medicalExam);
        $this->entityManager->flush();
        return $medicalExam;
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

    public function setFields($entityRequest, $entity): ?MedicalExams
    {
        if(!$entityRequest instanceof MedicalExamRequest && !$entity instanceof MedicalExams) return null;
        if($entityRequest->type){
            $entity->setType($entityRequest->type);
        }
        if($entityRequest->description){
            $entity->setDescription($entityRequest->description);
        }
        return $entity;
    }

}