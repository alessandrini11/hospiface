<?php

namespace App\Entity;

use App\Interface\EntityInterface;
use App\Repository\PersonnelGardeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonnelGardeRepository::class)]
class PersonnelGarde implements EntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(fetch: 'EAGER' , inversedBy: 'personnelGardes')]
    private ?Personnel $personnel = null;

    #[ORM\ManyToOne(fetch: 'EAGER' , inversedBy: 'personnelGardes')]
    private ?Service $service = null;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'personnelGardes')]
    private ?Garde $garde = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDate = null;

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

    public function getGarde(): ?Garde
    {
        return $this->garde;
    }

    public function setGarde(?Garde $garde): self
    {
        $this->garde = $garde;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }
    public function getData(): array
    {
        return [
            "id" => $this->id,
            "personnel" => $this->personnel->getData(),
            "service" => $this->service->getData(),
            "start_date" => $this->startDate,
            "end_date" => $this->endDate
        ];
    }
}
