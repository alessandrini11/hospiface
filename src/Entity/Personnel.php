<?php

namespace App\Entity;

use App\Interface\EntityInterface;
use App\Repository\PersonnelRepository;
use App\Trait\DateTrait;
use App\Trait\PersonTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: PersonnelRepository::class)]
#[HasLifecycleCallbacks]
#[UniqueEntity(['email'], 'this email is already taken')]
class Personnel implements EntityInterface
{
    use DateTrait;
    use PersonTrait;
    const MAN = 'man';
    const WOMAN = 'woman';

    const SEXS = [
        self::MAN => 'man',
        self::WOMAN => 'woman',
    ];

    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;
    const STATUS_DELETED = 2;

    const STATUSES = [
        self::STATUS_DISABLED => 'Disabled',
        self::STATUS_ENABLED => 'Enabled',
        self::STATUS_DELETED => 'Deleted',
    ];
    const MEDICAL = 'medical';
    const ADMINISTRATIVE = 'administrative';
    const TECHNICAL = 'technical';
    const ACADEMIC = 'academic';
    const DOCTOR = 'doctor';
    const LAB_TECHNICIAN = 'lab. technician';
    const NURSE = 'nurse';
    const EMBALMER = 'embalmer';
    const CAREGIVER = 'caregiver';
    const LEGAL_OFFICER = 'legal officer';
    const COMPUTER_SCIENTIST = 'computer scientist';
    const ACCOUNTANT = 'accountant';
    const TITLES = [
        'Pr.',
        'Dr.',
        'Ing.'
    ];
    const TYPES = [
        self::MEDICAL => [
            self::DOCTOR,
            self::LAB_TECHNICIAN,
            self::NURSE,
            self::CAREGIVER,
            self::EMBALMER
        ],
        self::ADMINISTRATIVE => [
            self::LEGAL_OFFICER,
            self::COMPUTER_SCIENTIST,
            self::ACCOUNTANT
        ],
        self::TECHNICAL => [
            'maintenance', 'security'
        ],
        self::ACADEMIC => [
            self::DOCTOR,
            self::LAB_TECHNICIAN,
            self::NURSE,
            self::CAREGIVER,
            self::EMBALMER,
            self::LEGAL_OFFICER,
            self::COMPUTER_SCIENTIST,
            self::ACCOUNTANT
        ]

    ];
    const POSITIONS = [
        'general manager', 'deputy director', 'head of department'
    ];
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $positionHeld = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subType = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'createdPersonnels')]
    private ?User $createdBy = null;

    #[ORM\ManyToOne(fetch: 'EAGER',inversedBy: 'updatedPersonnels')]
    private ?User $updatedBy = null;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'personnels')]
    private ?Speciality $speciality = null;

    #[ORM\OneToMany(mappedBy: 'personnel', targetEntity: PersonnelService::class, fetch: 'EAGER', orphanRemoval: true)]
    private Collection $personnelServices;

    #[ORM\OneToMany(mappedBy: 'personnel', targetEntity: PersonnelGarde::class, fetch: 'EAGER', orphanRemoval: true)]
    private Collection $personnelGardes;

    #[ORM\OneToMany(mappedBy: 'doctor', targetEntity: Consultation::class, fetch: 'EAGER')]
    private Collection $consultations;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $bloodGroup = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    public function __construct()
    {
        $this->personnelServices = new ArrayCollection();
        $this->personnelGardes = new ArrayCollection();
        $this->consultations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

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

    public function getPositionHeld(): ?string
    {
        return $this->positionHeld;
    }

    public function setPositionHeld(?string $positionHeld): self
    {
        $this->positionHeld = $positionHeld;

        return $this;
    }

    public function getSubType(): ?string
    {
        return $this->subType;
    }

    public function setSubType(?string $subType): self
    {
        $this->subType = $subType;

        return $this;
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

    public function getSpeciality(): ?Speciality
    {
        return $this->speciality;
    }

    public function setSpeciality(?Speciality $speciality): self
    {
        $this->speciality = $speciality;

        return $this;
    }

    /**
     * @return Collection<int, PersonnelService>
     */
    public function getPersonnelServices(): Collection
    {
        return $this->personnelServices;
    }

    public function addPersonnelService(PersonnelService $personnelService): self
    {
        if (!$this->personnelServices->contains($personnelService)) {
            $this->personnelServices->add($personnelService);
            $personnelService->setPersonnel($this);
        }

        return $this;
    }

    public function removePersonnelService(PersonnelService $personnelService): self
    {
        if ($this->personnelServices->removeElement($personnelService)) {
            // set the owning side to null (unless already changed)
            if ($personnelService->getPersonnel() === $this) {
                $personnelService->setPersonnel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PersonnelGarde>
     */
    public function getPersonnelGardes(): Collection
    {
        return $this->personnelGardes;
    }

    public function addPersonnelGarde(PersonnelGarde $personnelGarde): self
    {
        if (!$this->personnelGardes->contains($personnelGarde)) {
            $this->personnelGardes->add($personnelGarde);
            $personnelGarde->setPersonnel($this);
        }

        return $this;
    }

    public function removePersonnelGarde(PersonnelGarde $personnelGarde): self
    {
        if ($this->personnelGardes->removeElement($personnelGarde)) {
            // set the owning side to null (unless already changed)
            if ($personnelGarde->getPersonnel() === $this) {
                $personnelGarde->setPersonnel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Consultation>
     */
    public function getConsultations(): Collection
    {
        return $this->consultations;
    }

    public function addConsultation(Consultation $consultation): self
    {
        if (!$this->consultations->contains($consultation)) {
            $this->consultations->add($consultation);
            $consultation->setDoctor($this);
        }

        return $this;
    }

    public function removeConsultation(Consultation $consultation): self
    {
        if ($this->consultations->removeElement($consultation)) {
            // set the owning side to null (unless already changed)
            if ($consultation->getDoctor() === $this) {
                $consultation->setDoctor(null);
            }
        }

        return $this;
    }

    public function getBloodGroup(): ?string
    {
        return $this->bloodGroup;
    }

    public function setBloodGroup(?string $bloodGroup): self
    {
        $this->bloodGroup = $bloodGroup;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getData(): array
    {
        return [
            "id" => $this->id,
            "first_name" => $this->firstname,
            "last_name" => $this->lastname,
            "title" => $this->title,
            "sex" => $this->sex,
            "type" => $this->type,
            "sub_typ" => $this->subType,
            "speciality" => $this->speciality?->getData(),
            "phone_number" => $this->phonenumber,
            "email" => $this->email,
            "status" => $this->status,
            "position_held" => $this->positionHeld,
        ];
    }
}
