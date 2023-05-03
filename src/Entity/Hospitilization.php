<?php

namespace App\Entity;

use App\Interface\EntityInterface;
use App\Repository\HospitilizationRepository;
use App\Trait\DateTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

#[ORM\Entity(repositoryClass: HospitilizationRepository::class)]
#[HasLifecycleCallbacks]
class Hospitilization implements EntityInterface
{
    use DateTrait;

    const PROGRAMMED = 0;
    const STARTED = 1;
    const ENDED = 2;
    const STATUS = [
        self::PROGRAMMED => 'programmed',
        self::STARTED => 'started',
        self::ENDED => 'ended'
    ];
    const OBSERVATION = 'observation';
    const MEDICALCARE = 'medical care';
    const INTENSIVECARE = 'intensive care';
    const SURGYCALRECOVERY = 'surgical recovery';
    const TYPES = [
        self::INTENSIVECARE,
        self::OBSERVATION,
        self::MEDICALCARE,
        self::SURGYCALRECOVERY
    ];
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'hospitilizations')]
    private ?Patient $patient = null;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'createdHospitilizations')]
    private ?User $createdBy = null;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'updatedHospitilizations')]
    private ?User $updatedBy = null;

    #[ORM\OneToOne(inversedBy: 'hospitilization', cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private ?HospitalizationRoom $hospitalizationRoom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
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

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

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

    public function getHospitalizationRoom(): ?HospitalizationRoom
    {
        return $this->hospitalizationRoom;
    }

    public function setHospitalizationRoom(?HospitalizationRoom $hospitalizationRoom): self
    {
        $this->hospitalizationRoom = $hospitalizationRoom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getData(): array
    {
        return [
            "id" => $this->id,
            "status" => $this->status,
            "type" => $this->type,
            "description" => $this->description,
            "start_date" => $this->startDate,
            "end_date" => $this->endDate,
            "room" => $this->hospitalizationRoom?->getRoom()->getData(),
            "patient" => $this->patient->getData(),
            "created_by" => $this->createdBy?->getData(),
            "updated_by" => $this->updatedBy?->getData(),
            "created_at" => $this->createdAt,
            "updated_at" => $this->updatedAt
        ];
    }
}
