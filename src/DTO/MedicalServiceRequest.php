<?php

namespace App\DTO;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
class MedicalServiceRequest
{
    #[Assert\Type('string')]
    #[Assert\NotBlank(allowNull: true)]
    public ?string $name;

    #[Assert\Type('int')]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Choice(choices: [0, 1], message: 'The status you selected is not an valid choice')]
    public ?int $status;

    public function __construct(Request $request)
    {
        $this->status = (int) $request->get('status');
        $this->name = $request->get('name');
    }
}