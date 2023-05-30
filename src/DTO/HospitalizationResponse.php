<?php

namespace App\DTO;

use App\Entity\Hospitilization;

class HospitalizationResponse
{
    public ?int $id;
    public ?int $status;
    public ?string $type;
    public ?\DateTime $startDate;
    public ?\DateTime $endDate;
    public ?array $room;
    public ?array $patient;
    public ?string $description;
    public ?array $created_by;
    public ?array $updated_by;
    public ?\DateTime $created_at;
    public ?\DateTime $updated_at;
    public function __construct(Hospitilization $hospitalization)
    {
        $this->id = $hospitalization->getId();
        $this->status = (int) $hospitalization->getStatus();
        $this->type = $hospitalization->getType();
        $this->description = $hospitalization->getDescription();
        $this->startDate = $hospitalization->getStartDate();
        $this->endDate = $hospitalization->getEndDate();
        $this->patient = $hospitalization->getPatient()?->getData();
        $this->room = $hospitalization->getHospitalizationRoom()?->getRoom()->getData();
        $this->created_at = $hospitalization->getCreatedAt();
        $this->updated_at = $hospitalization->getUpdatedAt();
        $this->created_by = $hospitalization->getCreatedBy()?->getData();
        $this->updated_by = $hospitalization->getUpdatedBy()?->getData();
    }
}