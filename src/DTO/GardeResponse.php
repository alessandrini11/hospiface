<?php

namespace App\DTO;

use App\Entity\Garde;

class GardeResponse
{
    public ?int $id;
    public ?\DateTime $start_date;
    public ?\DateTime $end_date;
    public ?array $personnel;
    public ?int $status;
    public ?array $created_by;
    public ?array $updated_by;
    public ?\DateTime $created_at;
    public ?\DateTime $updated_at;

    public function __construct(Garde $garde)
    {
        $this->id = $garde->getId();
        $this->start_date = $garde->getStartDate();
        $this->end_date = $garde->getEndDate();
        $this->status = $garde->getStatus();
        $this->created_by = $garde->getCreatedBy()?->getData();
        $this->updated_by = $garde->getUpdatedBy()?->getData();
        $this->created_at = $garde->getCreatedAt();
        $this->updated_at = $garde->getUpdatedAt();
        $personnel = [];
        foreach ($garde->getPersonnelGardes() as $personnelGarde){
            $personnel[] = $personnelGarde->getData();
        }
        $this->personnel = $personnel;
    }
}