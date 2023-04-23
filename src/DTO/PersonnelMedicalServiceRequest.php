<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
class PersonnelMedicalServiceRequest
{
    #[Assert\Type('integer')]
    #[Assert\NotBlank(allowNull: true)]
    public ?int $personnel;

    #[Assert\Type('integer')]
    #[Assert\NotBlank(allowNull: true)]
    public ?int $service;

    #[Assert\Type('string')]
    #[Assert\NotBlank(allowNull: true)]
    public ?string $positionHeld;

    public function __construct(Request $request)
    {
        $this->positionHeld = $request->get('positionHeld');
        $this->service = (int) $request->get('service');
        $this->personnel = (int) $request->get('personnel');
    }
}