<?php

namespace App\Entity;

use App\Repository\PersonnelServiceRepository;
use App\Trait\DateTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonnelServiceRepository::class)]
#[ORM\HasLifecycleCallbacks]
class PersonnelService
{
    use DateTrait;
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

    #[ORM\ManyToOne(inversedBy: 'createdPersonnelServices')]
    private ?User $createdBy = null;

    #[ORM\ManyToOne(inversedBy: 'updatedPersonnelService')]
    private ?User $updateBy = null;

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

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getUpdateBy(): ?User
    {
        return $this->updateBy;
    }

    public function setUpdateBy(?User $updateBy): self
    {
        $this->updateBy = $updateBy;

        return $this;
    }
}
