<?php

namespace App\DTO;

use App\Entity\Appointment;

class AppointmentResponse
{
    public ?int $id;
    public ?array $patient;
    public ?array $doctor;
    public ?int $status;
    public ?\DateTime $date;
    public ?array $created_by;
    public ?array $updated_by;
    public ?\DateTime $created_at;
    public ?\DateTime $updated_at;
    public function __construct(Appointment $appointment)
    {
        $this->id = $appointment->getId();
        $this->patient = $appointment->getPatient()->getData();
        $this->doctor = $appointment->getDoctor()->getData();
        $this->status = $appointment->getStatus();
        $this->date = $appointment->getDate();
        $this->created_by = $appointment->getCreatedBy()?->getData();
        $this->updated_by = $appointment->getUpdatedBy()?->getData();
        $this->created_at = $appointment->getCreatedAt();
        $this->updated_at = $appointment->getUpdatedAt();
    }
}