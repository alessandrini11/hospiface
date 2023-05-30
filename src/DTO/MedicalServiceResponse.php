<?php

namespace App\DTO;

use App\Entity\Service;
use Symfony\Component\HttpFoundation\Request;

class MedicalServiceResponse
{
    public ?int $id;
    public ?string $name;
    public ?int $status;
    public ?array $personnel_service;

    public ?array $personnel_gardes;
    public ?array $created_by;
    public ?array $updated_by;
    public ?\DateTime $created_at;
    public ?\DateTime $updated_at;

    public function __construct(Service $service)
    {
        $this->id = $service->getId();
        $this->name = $service->getName();
        $this->status = $service->getStatus();
        $this->created_by = $service->getCreatedBy()?->getData();
        $this->updated_by = $service->getUpdatedBy()?->getData();
        $this->created_at = $service->getCreatedAt();
        $this->updated_at = $service->getUpdatedAt();
        $personnels = [];
        $personnelGardes = [];
        foreach ($service->getPersonnelServices() as $personnelService){
            $personnels[] = [
                'id' => $personnelService->getId(),
                'personnel' => $personnelService->getPersonnel()?->getData(),
                'positionHeld' => $personnelService->getPositionHeld()
            ];
        }
        foreach ($service->getPersonnelGardes() as $personnelGarde){
            $personnelGardes[] = $personnelGarde?->getData();
        }
        $this->personnel_service = $personnels;
        $this->personnel_gardes = $personnelGardes;
    }
}