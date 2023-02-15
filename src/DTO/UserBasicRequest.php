<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
class UserBasicRequest
{
    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 255)]
    #[Assert\Email]
    public ?string $email;

    public function __construct(Request $request)
    {
        $this->email = $request->get('email');
    }
}