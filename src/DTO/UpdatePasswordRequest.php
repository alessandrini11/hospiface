<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UpdatePasswordRequest
{
    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank]
    public string $oldPassword;

    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank]
    public string $newPassword;

    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank]
    public string $repeatedPassword;

    public function __construct(Request $request)
    {
        $this->oldPassword = $request->get('oldPassword');
        $this->newPassword = $request->get('newPassword');
        $this->repeatedPassword = $request->get('repeatedPassword');
    }


}