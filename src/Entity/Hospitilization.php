<?php

namespace App\Entity;

use App\Repository\HospitilizationRepository;
use App\Trait\DateTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

#[ORM\Entity(repositoryClass: HospitilizationRepository::class)]
#[HasLifecycleCallbacks]
class Hospitilization
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
    private ?string $status = null;

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

    #[ORM\OneToMany(mappedBy: 'hospitalization', targetEntity: HospitalizationRoom::class)]
    private Collection $hospitalizationRooms;

    public function __construct()
    {
        $this->hospitalizationRooms = new ArrayCollection();
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

    /**
     * @return Collection<int, HospitalizationRoom>
     */
    public function getHospitalizationRooms(): Collection
    {
        return $this->hospitalizationRooms;
    }

    public function addHospitalizationRoom(HospitalizationRoom $hospitalizationRoom): self
    {
        if (!$this->hospitalizationRooms->contains($hospitalizationRoom)) {
            $this->hospitalizationRooms->add($hospitalizationRoom);
            $hospitalizationRoom->setHospitalization($this);
        }

        return $this;
    }

    public function removeHospitalizationRoom(HospitalizationRoom $hospitalizationRoom): self
    {
        if ($this->hospitalizationRooms->removeElement($hospitalizationRoom)) {
            // set the owning side to null (unless already changed)
            if ($hospitalizationRoom->getHospitalization() === $this) {
                $hospitalizationRoom->setHospitalization(null);
            }
        }

        return $this;
    }
}
