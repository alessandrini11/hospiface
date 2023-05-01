<?php

namespace App\DTO;

use App\Entity\Speciality;

class SpecialityResponse
{
    public ?int $id;
    public ?string $name;
    public ?array $personnels;
    public ?array $created_by;
    public ?array $updated_by;
    public ?\DateTime $created_at;
    public ?\DateTime $updated_at;
    public function __construct(Speciality $speciality)
    {
        $this->id = $speciality->getId();
        $this->name = $speciality->getName();
        $this->created_by = $speciality->getCreatedBy()?->getData();
        $this->updated_by = $speciality->getUpdatedBy()?->getData();
        $this->created_at = $speciality->getCreatedAt();
        $this->updated_at = $speciality->getUpdatedAt();
        $personnels = [];
        foreach ($speciality->getPersonnels() as $personnel){
            $personnels[] = $personnel->getData();
        }
        $this->personnels = $personnels;
    }
}