<?php

namespace App\DTO;
use App\Entity\Hospitilization;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;


class HospitalisationRequest
{
    #[Assert\Type('integer')]
    #[Assert\Choice(choices: [Hospitilization::PROGRAMMED, Hospitilization::STARTED, Hospitilization::ENDED])]
    public ?int $status;

    #[Assert\Type('string')]
    #[Assert\Choice(choices: Hospitilization::TYPES, message: 'the type you selected is not valid')]
    public ?string $type;

    public ?\DateTime $startDate;

    public ?\DateTime $endDate;

    #[Assert\Type('integer')]
    public ?int $patient;

    #[Assert\Type('integer')]
    public ?int $room;

    #[Assert\Type('string')]
    public ?string $description;

    public function __construct(Request $request)
    {
        $this->status = (int) $request->get('status');
        $this->type = $request->get('type');
        $this->startDate = $request->get('startDate') ? (new \DateTime())->setTimestamp(strtotime($request->get('startDate'))) : null;
        $this->endDate = $request->get('endDate') ? (new \DateTime())->setTimestamp(strtotime($request->get('endDate'))) : null;
        $this->patient = (int) $request->get('patient');
        $this->room = (int) $request->get('room');
        $this->description = $request->get('description');
    }
}