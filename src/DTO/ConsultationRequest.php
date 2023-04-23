<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
class ConsultationRequest
{
    #[Assert\Type('integer')]
    #[Assert\NotBlank(allowNull: true)]
    public ?int $doctor;

    #[Assert\Type('integer')]
    #[Assert\NotBlank(allowNull: true)]
    public ?int $patient;

    #[Assert\Type('integer')]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Choice(choices: [0, 1, 2, 3], message: 'the status is invalid')]
    public ?int $status;

    #[Assert\Type('string')]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 50)]
    public ?string $type;

    public function __construct(Request $request)
    {
        $this->type = $request->get('type');
        $this->doctor = (int) $request->get('doctor');
        $this->patient = (int) $request->get('patient');
        $this->status = (int) $request->get('status');
    }
}