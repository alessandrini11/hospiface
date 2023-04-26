<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
class GardeRequest
{
    #[Assert\NotBlank(allowNull: true)]
    public ?\DateTime $startDate;

    #[Assert\NotBlank(allowNull: true)]
    public ?\DateTime $endDate;

    #[Assert\Type('integer')]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Choice(choices: [0, 1, 2], message: 'The Status is not valid')]
    public ?int $status;

    public function __construct(Request $request)
    {
        $this->startDate = !$request->get('startDate') ? (new \DateTime())->setTimestamp(strtotime($request->get('startDate'))) : null;
        $this->endDate = !$request->get('startDate') ? (new \DateTime())->setTimestamp(strtotime($request->get('endDate'))) : null;
        $this->status = (int) $request->get('status');
    }

}