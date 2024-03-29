<?php

namespace App\Service;

use App\DTO\HospitalisationRequest;
use App\Entity\HospitalizationRoom;
use App\Entity\Hospitilization;
use App\Exceptions\NotFoundException;
use App\Interface\EntityServiceInterface;
use App\Repository\HospitalizationRoomRepository;
use App\Repository\HospitilizationRepository;

class HospitalizationService implements EntityServiceInterface
{
    public function __construct(
        readonly private HospitilizationRepository $hospitalizationRepository,
        readonly private PatientService $patientService,
        readonly private HospitalizationRoomService $hospitalizationRoomService,
        readonly private RoomService $roomService,
        readonly private HospitalizationRoomRepository $hospitalizationRoomRepository
    )
    {
    }
    public function create($entityRequest, $loggedUser = null): Hospitilization
    {
        $hospitalization = $this->setFields($entityRequest, new Hospitilization());
        $hospitalization->setCreatedBy($loggedUser);
        $this->hospitalizationRepository->save($hospitalization, true);
        return $hospitalization;
    }
    public function update($entityRequest, $entity, $loggedUser = null): Hospitilization
    {
        $hospitalization = $this->setFields($entityRequest, $entity, true);
        $hospitalization->setUpdatedBy($loggedUser);
        $this->hospitalizationRepository->save($hospitalization, true);
        return $hospitalization;
    }

    public function findOrFail(int $id): Hospitilization
    {
       $hospitalization = $this->hospitalizationRepository->find($id);
       if (!$hospitalization) throw new NotFoundException('Hospitalization Not Found');
       return $hospitalization;
    }

    public function delete(int $id): void
    {
        $hospitalization = $this->findOrFail($id);
        $this->hospitalizationRepository->remove($hospitalization, true);
    }
    public function setFields($entityRequest, $entity): ?Hospitilization
    {
        if(!$entityRequest instanceof HospitalisationRequest && !$entity instanceof Hospitilization) return null;
        if($entityRequest->startDate){
            $entity->setStartDate($entityRequest->startDate);
        }
        if($entityRequest->endDate){
            $entity->setEndDate($entityRequest->endDate);
        }
        if($entityRequest->status !== null){
            $entity->setStatus($entityRequest->status);
        }
        if($entityRequest->type){
            $entity->setType($entityRequest->type);
        }
        if($entityRequest->patient){
            $patient = $this->patientService->findOrFail($entityRequest->patient);
            $entity->setPatient($patient);
        }
        if ($entityRequest->room){
            $room = $this->roomService->findOrFail($entityRequest->room);
            // $this->roomService->isFull($room);
            $hospitalRoom =  $this->hospitalizationRoomService->createOrUpdate($entity, $room);
            $entity->setHospitalizationRoom($hospitalRoom);
        }
        if($entityRequest->description){
            $entity->setDescription($entityRequest->description);
        }
        return $entity;
    }
}