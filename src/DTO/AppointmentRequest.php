<?php

namespace App\DTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
class AppointmentRequest
{
    #[Assert\Type('integer')]
    #[Assert\NotBlank(allowNull: true)]
    public ?int $patient;
    #[Assert\Type('integer')]
    #[Assert\NotBlank(allowNull: true)]
    public ?int $doctor;

    #[Assert\NotBlank(allowNull: true)]
    public ?\DateTime $date;

    #[Assert\Type('integer')]
    #[Assert\NotBlank(allowNull: true)]
    public ?int $status;

    public function __construct(Request $request)
    {
        $this->patient = (int) $request->get('patient');
        $this->doctor = (int) $request->get('doctor');
        $this->status = (int) $request->get('status');
        $this->date = $request->get('date') ? (new \DateTime())->setTimestamp(strtotime($request->get('date'))) : null;
    }
}