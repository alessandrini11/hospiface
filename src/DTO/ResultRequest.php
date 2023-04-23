<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
class ResultRequest
{
    #[Assert\Type('string')]
    #[Assert\NotBlank(allowNull: true)]
    public ?string $interpretation;

    public function __construct(Request $request)
    {
        $this->interpretation = $request->get('interpretation');
    }
}