<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
class PersonnelGardeRequest
{
    #[Assert\Type('integer')]
    #[Assert\NotBlank(allowNull: true)]
    public ?int $service;

    #[Assert\Type('integer')]
    #[Assert\NotBlank(allowNull: true)]
    public ?int $personnel;

    #[Assert\Type('integer')]
    #[Assert\NotBlank(allowNull: true)]
    public ?int $garde;
    #[Assert\NotBlank(allowNull: true)]
    public ?\DateTime $startDate;
    #[Assert\NotBlank(allowNull: true)]
    public ?\DateTime $endDate;

    public function __construct(Request $request)
    {
        $this->service = (int) $request->get('service');
        $this->personnel = (int) $request->get('personnel');
        $this->garde = (int) $request->get('garde');
        $this->startDate = $request->get('startDate') ? (new \DateTime())->setTimestamp(strtotime($request->get('startDate'))) : null;
        $this->endDate = $request->get('startDate') ? (new \DateTime())->setTimestamp(strtotime($request->get('endDate'))) : null;

    }
}