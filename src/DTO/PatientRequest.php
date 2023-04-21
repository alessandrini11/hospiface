<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
class PatientRequest
{
    #[Assert\Type('string')]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 255)]
    public ?string $firstName;

    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 255)]
    public ?string $lastName;

    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 255)]
    #[Assert\Email]
    public ?string $email;

    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 5)]
    public ?string $sex;

    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 12)]
    #[Assert\Regex('/^[0-9]{6,19}$/')]
    public ?string $phoneNumber;

    #[Assert\Type(type: 'integer')]
    #[Assert\Choice(choices: [0, 1, 2, 3], message: 'The value you selected is not an valid choice')]
    #[Assert\NotBlank(allowNull: true)]
    public ?int $status;

    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank(allowNull: true)]
    public ?string $emergencyPerson;

    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 12)]
    #[Assert\Regex('/^[0-9]{6,19}$/')]
    public ?string $emergencyContact;

    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 3)]
    public ?string $bloodGroup;

    #[Assert\NotBlank(allowNull: true)]
    public ?\DateTime $birthDate;

    public function __construct(Request $request)
    {
        $this->firstName = $request->get('firstName');
        $this->lastName = $request->get('lastName');
        $this->email = $request->get('email');
        $this->sex = $request->get('sex');
        $this->phoneNumber = $request->get('phoneNumber');
        $this->status = (int) $request->get('status');
        $this->emergencyContact = $request->get('emergencyContact');
        $this->emergencyPerson = $request->get('emergencyPerson');
        $this->bloodGroup = $request->get('bloodGroup');
        $this->birthDate = (new \DateTime())->setTimestamp(strtotime($request->get('birthDate')));


    }
}