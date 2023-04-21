<?php

namespace App\Entity;

use App\Repository\ConsultationRepository;
use App\Trait\DateTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

#[ORM\Entity(repositoryClass: ConsultationRepository::class)]
#[HasLifecycleCallbacks]
class Consultation
{
    use DateTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'consultations')]
    private ?Personnel $doctor = null;

    #[ORM\ManyToOne(inversedBy: 'consultations')]
    private ?Patient $patient = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Parametre $parameter = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Result $result = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDoctor(): ?Personnel
    {
        return $this->doctor;
    }

    public function setDoctor(?Personnel $doctor): self
    {
        $this->doctor = $doctor;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getParameter(): ?Parametre
    {
        return $this->parameter;
    }

    public function setParameter(?Parametre $parameter): self
    {
        $this->parameter = $parameter;

        return $this;
    }

    public function getResult(): ?Result
    {
        return $this->result;
    }

    public function setResult(?Result $result): self
    {
        $this->result = $result;

        return $this;
    }
}