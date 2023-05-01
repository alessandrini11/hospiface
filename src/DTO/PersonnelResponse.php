<?php

namespace App\DTO;

use App\Entity\Personnel;

class PersonnelResponse
{
    public ?int $id;
    public ?string $first_name;
    public ?string $last_name;
    public ?string $title;
    public ?string $sex;
    public ?string $type;
    public ?string $sub_type;
    public ?string $phone_number;
    public ?array $speciality;
    public ?string $email;
    public ?string $status;
    public ?string $position_held;
    public ?array $consultations;
    public ?array $gardes;
    public ?array $created_by;
    public ?array $updated_by;
    public ?\DateTime $created_at;
    public ?\DateTime $updated_at;
    public function __construct(Personnel $personnel)
    {
        $this->id = $personnel->getId();
        $this->title = $personnel->getTitle();
        $this->first_name = $personnel->getFirstname();
        $this->last_name = $personnel->getLastname();
        $this->sex = $personnel->getSex();
        $this->type = $personnel->getType();
        $this->sub_type = $personnel->getSubType();
        $this->speciality = $personnel->getSpeciality()?->getData();
        $this->phone_number = $personnel->getPhonenumber();
        $this->email = $personnel->getEmail();
        $this->status = $personnel->getStatus();
        $this->position_held = $personnel->getPositionHeld();
        $this->created_by = $personnel->getCreatedBy()?->getData();
        $this->updated_by = $personnel->getUpdatedBy()?->getData();
        $this->created_at = $personnel->getCreatedAt();
        $this->updated_at = $personnel->getUpdatedAt();
        $consultations = [];
        $personnelGardes = [];
        foreach ($personnel->getConsultations() as $consultation){
            $consultations[] = $consultation->getData();
        }
        foreach ($personnel->getPersonnelGardes() as $personnelGarde){
            $personnelGardes[] = $personnelGarde->getData();
        }
        $this->consultations = $consultations;
        $this->gardes = $personnelGardes;
    }
}