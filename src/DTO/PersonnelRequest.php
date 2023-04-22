<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
class PersonnelRequest
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
    #[Assert\Choice(choices: ['man', 'woman'], message: 'The sex you selected is not an valid choice')]
    public ?string $sex;

    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 12)]
    #[Assert\Regex('/^[0-9]{6,19}$/')]
    public ?string $phoneNumber;

    #[Assert\Type(type: 'integer')]
    #[Assert\Choice(choices: [0, 1, 2, 3], message: 'The status you selected is not an valid choice')]
    #[Assert\NotBlank(allowNull: true)]
    public ?int $status;

    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 3)]
    public ?string $bloodGroup;

    #[Assert\NotBlank(allowNull: true)]
    public ?\DateTime $birthDate;

    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 255)]
    public ?string $positionHeld;

    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 255)]
    public ?string $type;
    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 255)]
    public ?string $subType;

    #[Assert\Type(type: 'string')]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 255)]
    public ?string $title;

    #[Assert\Type(type: 'integer')]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Length(max: 5)]
    public ?int $speciality;

    public function __construct(Request $request)
    {
        $this->firstName = $request->get('firstName');
        $this->lastName = $request->get('lastName');
        $this->sex = $request->get('sex');
        $this->email = $request->get('email');
        $this->phoneNumber = $request->get('phoneNumber');
        $this->bloodGroup = $request->get('bloodGroup');
        $this->status = (int) $request->get('status');
        $this->birthDate = (new \DateTime())->setTimestamp(strtotime($request->get('birthDate')));
        $this->positionHeld = $request->get('positionHeld');
        $this->type = $request->get('type');
        $this->subType = $request->get('subType');
        $this->speciality = (int) $request->get('speciality');
        $this->title = $request->get('title');
    }
}