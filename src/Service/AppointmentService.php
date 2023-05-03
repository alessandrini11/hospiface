<?php

namespace App\Service;

use App\DTO\AppointmentRequest;
use App\DTO\AppointmentResponse;
use App\Entity\Appointment;
use App\Interface\EntityServiceInterface;
use App\Repository\AppointmentRepository;

class AppointmentService implements EntityServiceInterface
{
    public function __construct(
        readonly private PatientService $patientService,
        readonly private PersonnelService $personnelService,
        readonly private AppointmentRepository $appointmentRepository
    )
    {
    }

    public function create($entityRequest, $loggedUser = null): AppointmentResponse
    {
        $appointment = $this->setFields($entityRequest, new Appointment());
        $appointment->setCreatedBy($loggedUser);
        $this->appointmentRepository->save($appointment, true);
        return new AppointmentResponse($appointment);
    }
    public function update($entityRequest, $entity, $loggedUser = null): AppointmentResponse
    {
        $appointment = $this->setFields($entityRequest, $entity);
        $appointment->setUpdatedBy($loggedUser);
        $this->appointmentRepository->save($appointment, true);
        return new AppointmentResponse($appointment);
    }
    public function findOrFail(int $id)
    {
        // TODO: Implement findOrFail() method.
    }
    public function delete(int $id): void
    {
        // TODO: Implement delete() method.
    }
    public function setFields($entityRequest, $entity): ?Appointment
    {
        if(!$entityRequest instanceof AppointmentRequest && !$entity instanceof Appointment) return null;
        if($entityRequest->patient){
            $patient = $this->patientService->findOrFail($entityRequest->patient);
            $entity->setPatient($patient);
        }
        if($entityRequest->doctor){
            $doctor = $this->personnelService->findOrFail($entityRequest->doctor);
            $entity->setDoctor($doctor);
        }
        if($entityRequest->status){
            $entity->setStatus($entityRequest->status);
        }
        if($entityRequest->date){
            $entity->setDate($entityRequest->date);
        }
        return $entity;
    }
}