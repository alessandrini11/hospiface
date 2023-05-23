<?php

namespace App\DTO;

use App\Entity\Patient;
use App\Entity\User;

class PatientResponse
{
    public ?int $id;
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
    public ?array $hospitalizations;
    public ?array $consultations;
    public ?array $createdBy;
    public ?array $updatedBy;
    public ?\DateTime $createdAt;
    public ?\DateTime $updatedAt;
    public function __construct(Patient $patient)
    {
        $this->id = $patient->getId();
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
        $this->createdBy = $patient->getCreatedBy()?->getData();
        $this->updatedBy = $patient->getUpdatedBy()?->getData();
        $this->createdAt = $patient->getCreatedAt();
        $this->updatedAt = $patient->getUpdatedAt();
        $hospitalizations = [];
        $consultations = [];
        foreach ($patient->getConsultations() as $consultation){
            $consultations[] = $consultation->getData();
        }
        foreach ($patient->getHospitilizations() as $hospitalization){
            $hospitalizations[] = $hospitalization->getData();
        }
        $this->hospitalizations = $hospitalizations;
        $this->consultations = $consultations;
    }
}