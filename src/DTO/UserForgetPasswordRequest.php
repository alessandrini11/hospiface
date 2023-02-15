<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UserForgetPasswordRequest
{
    #[Assert\Type(type: 'string')]
    #[Assert\Length(max: 255)]
    public string $password;

    #[Assert\Type(type: 'string')]
    #[Assert\Length(max: 255)]
    public string $repeatedPassword;
    public function __construct(Request $request)
    {
        $this->password = $request->get('password');
        $this->repeatedPassword = $request->get('repeatedPassword');
    }
}