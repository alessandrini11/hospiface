<?php

namespace App\Entity;

use App\Repository\PersonnelServiceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonnelServiceRepository::class)]
class PersonnelService
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'personnelServices')]
    private ?Personnel $personnel = null;

    #[ORM\ManyToOne(inversedBy: 'personnelServices')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Service $service = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $positionHeld = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPersonnel(): ?Personnel
    {
        return $this->personnel;
    }

    public function setPersonnel(?Personnel $personnel): self
    {
        $this->personnel = $personnel;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getPositionHeld(): ?string
    {
        return $this->positionHeld;
    }

    public function setPositionHeld(?string $positionHeld): self
    {
        $this->positionHeld = $positionHeld;

        return $this;
    }
}
