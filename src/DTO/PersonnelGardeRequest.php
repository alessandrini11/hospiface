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
    #[Assert\NotBlank(allowNull: true)]
    public ?\DateTime $startDate;
    #[Assert\NotBlank(allowNull: true)]
    public ?\DateTime $endDate;

    public function __construct(Request $request)
    {
        $this->service = (int) $request->get('service');
        $this->personnel = (int) $request->get('personnel');
        $this->startDate = (new \DateTime())->setTimestamp(strtotime($request->get('startDate')));
        $this->endDate =  (new \DateTime())->setTimestamp(strtotime($request->get('endDate')));
    }
}