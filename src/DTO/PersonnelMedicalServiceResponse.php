<?php

namespace App\DTO;

use App\Entity\PersonnelService;

class PersonnelMedicalServiceResponse
{
    public ?int $id;
    public ?array $personnel;
    public ?array $service;
    public ?string $position_held;
    public ?array $created_by;
    public ?array $updated_by;
    public ?\DateTime $updated_at;
    public ?\DateTime $created_at;
    public function __construct(PersonnelService $personnelService)
    {
        $this->id = $personnelService->getId();
        $this->personnel = $personnelService->getPersonnel()?->getData();
        $this->service = $personnelService->getService()->getData();
        $this->position_held = $personnelService->getPositionHeld();
        $this->created_by = $personnelService->getCreatedBy()?->getData();
        $this->updated_by = $personnelService->getUpdateBy()?->getData();
        $this->created_at = $personnelService->getCreatedAt();
        $this->updated_at = $personnelService->getUpdatedAt();
    }
}