<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
class DrugRequest
{
    #[Assert\Type('string')]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 255)]
    public ?string $name;

    #[Assert\Type('string')]
    #[Assert\NotBlank(allowNull: true)]
    public ?string $dosage;

    #[Assert\Type('boolean')]
    public ?bool $alternative;

    #[Assert\Type('integer')]
    #[Assert\NotBlank(allowNull: true)]
    public ?int $medicalOrder;

    public function __construct(Request $request)
    {
        $this->alternative = (bool) $request->get('alternative');
        $this->dosage = $request->get('dosage');
        $this->name = $request->get('name');
        $this->medicalOrder = (int) $request->get('medicalOrder');
    }
}