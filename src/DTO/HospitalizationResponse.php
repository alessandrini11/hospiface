<?php

namespace App\DTO;

use App\Entity\Hospitilization;

class HospitalizationResponse
{
    public ?int $id;
    public ?int $status;
    public ?string $type;
    public ?\DateTime $start_date;
    public ?\DateTime $end_date;
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
        $this->status = $hospitalization->getStatus();
        $this->type = $hospitalization->getType();
        $this->description = $hospitalization->getDescription();
        $this->start_date = $hospitalization->getStartDate();
        $this->end_date = $hospitalization->getEndDate();
        $this->patient = $hospitalization->getPatient()?->getData();
        $this->room = $hospitalization->getHospitalizationRoom()->getRoom()->getData();
        $this->created_at = $hospitalization->getCreatedAt();
        $this->updated_at = $hospitalization->getUpdatedAt();
        $this->created_by = $hospitalization->getCreatedBy()?->getData();
        $this->updated_by = $hospitalization->getUpdatedBy()?->getData();
    }
}