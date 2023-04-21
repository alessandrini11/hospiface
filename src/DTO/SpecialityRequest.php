<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
class SpecialityRequest
{
    #[Assert\Type('string')]
    public ?string $name;

    public function __construct(Request $request)
    {
        $this->name = $request->get('name');
    }
}