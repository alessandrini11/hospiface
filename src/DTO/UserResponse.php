<?php

namespace App\DTO;

use App\Entity\User;

class UserResponse
{
    public ?string $firstname;
    public ?string $lastname;
    public ?string $phonenumber;
    public ?string $email;
    public ?string $sex;
    public ?string $password;
    public ?array $roles;
    public ?string $status;

    public function __construct(User $user)
    {
        $this->firstname = $user->getFirstname();
        $this->lastname = $user->getLastname();
        $this->phonenumber = $user->getPhonenumber();
        $this->email = $user->getEmail();
        $this->sex = $user->getSex();
        $this->password = $user->getPassword();
        $this->roles = $user->getRoles();
        $this->status = $user->getStatus();

    }
}