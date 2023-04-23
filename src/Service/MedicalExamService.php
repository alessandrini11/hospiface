<?php

namespace App\Service;

use App\DTO\MedicalExamRequest;
use App\Entity\MedicalExams;
use App\Exceptions\NotFoundException;
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
        $medicalExam = $this->setFields($entityRequest, new MedicalExams());
        $medicalExam->setCreatedBy($loggedUser);
        $this->entityManager->persist($medicalExam);
        $this->entityManager->flush();
        return $medicalExam;
    }
    public function update($entityRequest, $entity, $loggedUser = null): MedicalExams
    {
        $medicalExam = $this->setFields($entityRequest, $entity);
        $medicalExam->setUpdatedBy($loggedUser);
        $this->medicalExamsRepository->save($medicalExam, true);
        return $medicalExam;
    }

    public function findOrFail(int $id): MedicalExams
    {
        $medicalExam = $this->medicalExamsRepository->find($id);
        if(!$medicalExam) throw new NotFoundException('Medical Exam Not Found');
        return $medicalExam;
    }

    public function delete(int $id): void
    {
        $medicalExam = $this->findOrFail($id);
        $this->medicalExamsRepository->remove($medicalExam, true);
    }

    public function setFields($entityRequest, $entity): ?MedicalExams
    {
        if(!$entityRequest instanceof MedicalExamRequest && !$entity instanceof MedicalExams) return null;
        if($entityRequest->type){
            $entity->setType($entityRequest->type);
        }
        if($entityRequest->result){
            $result = $this->resultService->findOrFail($entityRequest->result);
            $result->addMedicalExam($entity);
            $this->entityManager->persist($result);
        }
        if($entityRequest->description){
            $entity->setDescription($entityRequest->description);
        }
        return $entity;
    }

}