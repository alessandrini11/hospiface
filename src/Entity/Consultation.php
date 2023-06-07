<?php

namespace App\Entity;

use App\Interface\EntityInterface;
use App\Repository\ConsultationRepository;
use App\Trait\DateTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

#[ORM\Entity(repositoryClass: ConsultationRepository::class)]
#[HasLifecycleCallbacks]
class Consultation implements EntityInterface
{
    const CHECKUP = 'check-up';
    const NORMAL = 'normal';
    CONST TYPES = [self::CHECKUP];
    const STARTED = 0;
    const ENDED = 1;
    const STATUS = [
        self::ENDED => 'ended',
        self::STARTED => 'started'
    ];
    use DateTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\ManyToOne(fetch: 'EAGER' , inversedBy: 'consultations')]
    private ?Personnel $doctor = null;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'consultations')]
    private ?Patient $patient = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private ?Parametre $parameter = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private ?Result $result = null;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'createdConsultations')]
    private ?User $createdBy = null;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'updatedConsultations')]
    private ?User $updatedBy = null;

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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
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

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?User $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function getData(): array
    {
        return [
            "id" => $this->id,
            "status" => $this->status,
            "doctor" => $this->doctor->getData(),
            "patient" => $this->patient?->getData(),
            "result" => $this->result?->getData(),
            "parameter" => $this->parameter?->getData(),
            "created_at" => $this->createdAt
        ];
    }
}
