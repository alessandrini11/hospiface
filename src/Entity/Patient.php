<?php

namespace App\Entity;

use App\Interface\EntityInterface;
use App\Repository\PatientRepository;
use App\Trait\DateTrait;
use App\Trait\PersonTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
#[UniqueEntity(['email'], 'this email is already taken')]
#[HasLifecycleCallbacks]
class Patient implements EntityInterface
{
    use PersonTrait;
    use DateTrait;
    const MAN = 'man';
    const WOMAN = 'woman';
    const FREE = 0;
    const HOSPITALIZED = 1;
    const DEATH = 2;
    const STATUS = [
        self::FREE => 'free',
        self::HOSPITALIZED => 'hospitalized',
        self::DEATH => 'death'
    ];
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $emergencyPersonne = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $emergencyContact = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $bloodGroup = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthDate = null;

    #[ORM\ManyToOne(inversedBy: 'createdPatients')]
    private ?User $createdBy = null;

    #[ORM\ManyToOne(inversedBy: 'updatedPatients')]
    private ?User $updatedBy = null;

    #[ORM\OneToMany(mappedBy: 'patient', targetEntity: Consultation::class, fetch: 'EAGER')]
    private Collection $consultations;

    #[ORM\OneToMany(mappedBy: 'patient', targetEntity: Hospitilization::class, fetch: 'EAGER')]
    private Collection $hospitilizations;

    #[ORM\OneToMany(mappedBy: 'patient', targetEntity: Appointment::class)]
    private Collection $appointments;

    public function __construct()
    {
        $this->consultations = new ArrayCollection();
        $this->hospitilizations = new ArrayCollection();
        $this->appointments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmergencyPersonne(): ?string
    {
        return $this->emergencyPersonne;
    }

    public function setEmergencyPersonne(?string $emergencyPersonne): self
    {
        $this->emergencyPersonne = $emergencyPersonne;

        return $this;
    }

    public function getEmergencyContact(): ?string
    {
        return $this->emergencyContact;
    }

    public function setEmergencyContact(string $emergencyContact): self
    {
        $this->emergencyContact = $emergencyContact;

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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
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
            $consultation->setPatient($this);
        }

        return $this;
    }

    public function removeConsultation(Consultation $consultation): self
    {
        if ($this->consultations->removeElement($consultation)) {
            // set the owning side to null (unless already changed)
            if ($consultation->getPatient() === $this) {
                $consultation->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Hospitilization>
     */
    public function getHospitilizations(): Collection
    {
        return $this->hospitilizations;
    }

    public function addHospitilization(Hospitilization $hospitilization): self
    {
        if (!$this->hospitilizations->contains($hospitilization)) {
            $this->hospitilizations->add($hospitilization);
            $hospitilization->setPatient($this);
        }

        return $this;
    }

    public function removeHospitilization(Hospitilization $hospitilization): self
    {
        if ($this->hospitilizations->removeElement($hospitilization)) {
            // set the owning side to null (unless already changed)
            if ($hospitilization->getPatient() === $this) {
                $hospitilization->setPatient(null);
            }
        }

        return $this;
    }

    public function getData(): array
    {
        return [
            'id' => $this->id,
            'firstName' => $this->firstname,
            'lastName' => $this->lastname,
            'email' => $this->email,
            'sex' => $this->sex,
            'status' => $this->status,
            'emergency_person' => $this->emergencyPersonne,
            'emergency_contact' => $this->emergencyContact,
            'blood_group' => $this->bloodGroup,
            'birth_date' => $this->birthDate
        ];
    }

    /**
     * @return Collection<int, Appointment>
     */
    public function getAppointments(): Collection
    {
        return $this->appointments;
    }

    public function addAppointment(Appointment $appointment): self
    {
        if (!$this->appointments->contains($appointment)) {
            $this->appointments->add($appointment);
            $appointment->setPatient($this);
        }

        return $this;
    }

    public function removeAppointment(Appointment $appointment): self
    {
        if ($this->appointments->removeElement($appointment)) {
            // set the owning side to null (unless already changed)
            if ($appointment->getPatient() === $this) {
                $appointment->setPatient(null);
            }
        }

        return $this;
    }
}
