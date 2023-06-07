<?php

namespace App\DTO;

use App\Entity\Drug;

class DrugResponse
{
    public ?int $id;
    public ?string $name;
    public ?string $dosage;
    public ?int $days;
    public ?bool $is_alternative;
    public function __construct(Drug $drug)
    {
        $this->id = $drug->getId();
        $this->name = $drug->getName();
        $this->dosage = $drug->getDosage();
        $this->is_alternative = $drug->isAlternative();
        $this->days = $drug->getDays();
    }
}