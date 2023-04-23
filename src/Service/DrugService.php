<?php

namespace App\Service;

use App\DTO\DrugRequest;
use App\Entity\Drug;
use App\Exceptions\NotFoundException;
use App\Interface\EntityServiceInterface;
use App\Repository\DrugRepository;
use App\Repository\MedicalOrderRepository;
use Doctrine\ORM\EntityManagerInterface;

class DrugService implements EntityServiceInterface
{
    public function __construct(
        readonly EntityManagerInterface $entityManager,
        readonly MedicalOrderRepository $medicalOrderRepository,
        readonly DrugRepository $drugRepository
    )
    {
    }

    public function create($entityRequest, $loggedUser = null): Drug
    {
        $drug = $this->setFields($entityRequest, new Drug());
        $drug->setCreatedBy($loggedUser);
        $this->entityManager->persist($drug);
        $this->entityManager->flush();
        return $drug;
    }
    public function update($entityRequest, $entity, $loggedUser = null): Drug
    {
        $drug = $this->setFields($entityRequest, $entity);
        $drug->setUpdatedBy($loggedUser);
        $this->entityManager->persist($drug);
        $this->entityManager->flush();
        return $entity;
    }

    public function findOrFail(int $id): Drug
    {
        $drug = $this->drugRepository->find($id);
        if (!$drug) throw new NotFoundException('Drug Not Found');
        return $drug;
    }
    public function delete(int $id): void
    {
        $drug = $this->findOrFail($id);
        $this->drugRepository->remove($drug, true);
    }
    public function setFields($entityRequest, $entity): ?Drug
    {
        if (!$entityRequest instanceof DrugRequest && !$entity instanceof Drug) return null;
        if ($entityRequest->name){
            $entity->setName($entityRequest->name);
        }
        if ($entityRequest->dosage){
            $entity->setDosage($entityRequest->dosage);
        }
        if ($entityRequest->alternative){
            $entity->setAlternative($entityRequest->alternative);
        }
        if ($entityRequest->medicalOrder){
            $medicalOrder = $this->medicalOrderRepository->find($entityRequest->medicalOrder);
            if (!$medicalOrder) throw new NotFoundException('Medical Order Not Found');
            $entity->setMedicalOrder($medicalOrder);
        }
        return $entity;
    }
}