<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
class MedicalExamRequest
{
    #[Assert\Type('string')]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 50)]
    public ?string $type;

    #[Assert\Type('integer')]
    #[Assert\NotBlank(allowNull: true)]
    public ?int $result;

    #[Assert\Type('string')]
    #[Assert\NotBlank(allowNull: true)]
    public ?string $description;

    public function __construct(Request $request)
    {
        $this->type = $request->get('type');
        $this->result = (int) $request->get('result');
        $this->description = $request->get('description');
    }
}