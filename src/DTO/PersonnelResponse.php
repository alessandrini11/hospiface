<?php

namespace App\DTO;

use App\Entity\Personnel;

class PersonnelResponse
{
    public ?int $id;
    public ?string $firstName;
    public ?string $lastName;
    public ?string $title;
    public ?string $bloodGroup;
    public ?string $address;
    public ?string $sex;
    public ?string $type;
    public ?string $subType;
    public ?string $phoneNumber;
    public ?array $speciality;
    public ?string $email;
    public ?int $status;
    public ?string $positionHeld;
    public ?int $consultations;
    public ?int $gardes;
    public ?array $created_by;
    public ?array $updated_by;
    public ?array $services;
    public ?\DateTime $created_at;
    public ?\DateTime $updated_at;
    public function __construct(Personnel $personnel)
    {
        $this->id = $personnel->getId();
        $this->title = $personnel->getTitle() !== "none" ? $personnel->getTitle() : "";
        $this->firstName = $personnel->getFirstname();
        $this->lastName = $personnel->getLastname();
        $this->sex = $personnel->getSex();
        $this->type = $personnel->getType();
        $this->subType = $personnel->getSubType();
        $this->speciality = $personnel->getSpeciality()?->getName() !== "aucune" ? $personnel->getSpeciality()?->getData() : null;
        $this->phoneNumber = $personnel->getPhonenumber();
        $this->email = $personnel->getEmail();
        $this->status = $personnel->getStatus();
        $this->bloodGroup = $personnel->getBloodGroup();
        $this->positionHeld = $personnel->getPositionHeld() !== "none" ? $personnel->getPositionHeld() : "";
        $this->created_by = $personnel->getCreatedBy()?->getData();
        $this->updated_by = $personnel->getUpdatedBy()?->getData();
        $this->created_at = $personnel->getCreatedAt();
        $this->updated_at = $personnel->getUpdatedAt();
        $this->consultations = count($personnel->getConsultations());
        $this->gardes = count($personnel->getPersonnelGardes());
        $services = [];
        foreach($personnel->getPersonnelServices() as $service){
            $services[] = $service->getData();
        }
        $this->services = $services;
    }
}