<?php

namespace App\model;


use App\Entity\PersonnelGarde;

class ReceiverModel
{
    public string $fullName;
    public string $phoneNumber;
    public string $startDate;
    public string $endDate;

    public function __construct(PersonnelGarde $personnel_garde)
    {
        $this->fullName = $personnel_garde->getPersonnel()->getTitle(). ". ". $personnel_garde->getPersonnel()->getFirstname(). " ". $personnel_garde->getPersonnel()->getLastname();
        $this->phoneNumber = $personnel_garde->getPersonnel()->getPhonenumber();
        $this->startDate = $personnel_garde->getStartDate()->format('D/M'). " à " .$personnel_garde->getStartDate()->format('H:i');
        $this->endDate = $personnel_garde->getEndDate()->format('D/M H:i'). " à " .$personnel_garde->getEndDate()->format('H:i');
    }
}