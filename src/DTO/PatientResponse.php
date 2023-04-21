<?php

namespace App\DTO;

use App\Entity\Patient;
use App\Entity\User;

class PatientResponse
{
    public ?string $firstName;
    public ?string $lastName;
    public ?string $email;
    public ?string $sex;
    public ?string $phoneNumber;
    public ?string $emergencyPerson;
    public ?string $emergencyContact;
    public ?string $bloodGroup;
    public ?\DateTime $birthDate;
    public ?int $status;
    public ?User $createdBy;
    public ?User $updatedBy;
    public ?\DateTime $createdAt;
    public ?\DateTime $updatedAt;
    public function __construct(Patient $patient)
    {
        $this->firstName = $patient->getFirstname();
        $this->lastName = $patient->getLastname();
        $this->email = $patient->getEmail();
        $this->sex = $patient->getSex();
        $this->status = $patient->getStatus();
        $this->emergencyContact = $patient->getEmergencyContact();
        $this->emergencyPerson = $patient->getEmergencyPersonne();
        $this->bloodGroup = $patient->getBloodGroup();
        $this->birthDate = $patient->getBirthDate();
        $this->phoneNumber = $patient->getPhonenumber();
        $this->createdBy = $patient->getCreatedBy();
        $this->updatedBy = $patient->getUpdatedBy();
        $this->createdAt = $patient->getCreatedAt();
        $this->updatedAt = $patient->getUpdatedAt();
    }
}