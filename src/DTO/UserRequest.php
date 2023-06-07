<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UserRequest
{
    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 255)]
    public ?string $firstname;

    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 255)]
    public ?string $lastname;

    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 255)]
    public ?string $email;

    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank(allowNull: true)]
    public ?string $password;

    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 5)]
    public ?string $sex;

    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank(allowNull: true)]
    public ?string $phonenumber;

    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank(allowNull: true)]
    public ?string $role;

    #[Assert\Type(type: 'integer')]
    public ?int $status;
    public function __construct(Request $request)
    {
        $this->firstname = $request->get('firstname');
        $this->lastname = $request->get('lastname');
        $this->email = $request->get('email');
        $this->phonenumber = $request->get('phonenumber');
        $this->sex = $request->get('sex');
        $this->password = $request->get('password');
        $this->role = $request->get('role');
        $this->status = (int)$request->get('status');
    }
}