<?php

namespace App\Service;

use App\DTO\ConsultationRequest;
use App\Entity\Consultation;
use App\Entity\MedicalOrder;
use App\Entity\Parametre;
use App\Entity\Result;
use App\Interface\EntityServiceInterface;
use App\Repository\ConsultationRepository;
use App\Repository\MedicalOrderRepository;
use App\Repository\ParametreRepository;
use App\Repository\ResultRepository;

class ConsultationService implements EntityServiceInterface
{
    public function __construct(
        readonly private ConsultationRepository $consultationRepository,
        readonly private MedicalOrderRepository $medicalOrderRepository,
        readonly private ParametreRepository $parametreRepository,
        readonly private ResultRepository $resultRepository,
        readonly private PatientService $patientService,
        readonly private PersonnelService $personnelService,
    )
    {
    }

    public function create($entityRequest, $loggedUser = null): Consultation
    {
        $parameter = new Parametre();
        $parameter->setCreatedBy($loggedUser);
        $medicalOrder = new MedicalOrder();
        $medicalOrder->setCreatedBy($loggedUser);
        $result = new Result();
        $result
            ->setCreatedBy($loggedUser)
            ->setMedicalOrder($medicalOrder)
        ;
        $consultation = $this->setFields($entityRequest, new Consultation());
        $consultation
            ->setCreatedBy($loggedUser)
            ->setParameter($parameter)
            ->setResult($result);
        $this->parametreRepository->save($parameter);
        $this->medicalOrderRepository->save($medicalOrder);
        $this->resultRepository->save($result);
        $this->consultationRepository->save($consultation, true);
        return $consultation;

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

    }

    public function setFields($entityRequest, $entity): ?Consultation
    {
        if (!$entityRequest instanceof ConsultationRequest && !$entity instanceof Consultation) return null;
        if($entityRequest->doctor){
            $doctor = $this->personnelService->findOrFail($entityRequest->doctor);
            $entity->setDoctor($doctor);
        }
        if($entityRequest->patient){
            $patient = $this->patientService->findOrFail($entityRequest->patient);
            $entity->setPatient($patient);
        }
        if($entityRequest->type){
            $entity->setType($entityRequest->type);
        }
        if($entityRequest->status){
            $entity->setStatus($entityRequest->status);
        }
        return $entity;
    }
}