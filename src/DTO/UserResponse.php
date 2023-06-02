<?php

namespace App\DTO;

use App\Entity\User;

class UserResponse
{
    public ?int $id;
    public ?string $firstname;
    public ?string $lastname;
    public ?string $phonenumber;
    public ?string $email;
    public ?string $sex;
    public ?array $roles;
    public ?int $status;
    public ?\DateTime $created_at;
    public ?\DateTime $updated_at;

    public function __construct(User $user)
    {
        $this->id = $user->getId();
        $this->firstname = $user->getFirstname();
        $this->lastname = $user->getLastname();
        $this->phonenumber = $user->getPhonenumber();
        $this->email = $user->getEmail();
        $this->sex = $user->getSex();
        $this->roles = $user->getRoles();
        $this->status = (int)$user->getStatus();
        $this->created_at = $user->getCreatedAt();
        $this->updated_at = $user->getUpdatedAt();
    }
}