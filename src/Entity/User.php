<?php

namespace App\Entity;

use App\Repository\UserRepository;
use App\Trait\DateTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(['email'], 'This email is already taken')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use DateTrait;

    const MAN = 'man';
    const WOMAN = 'woman';

    const SEXES = [
        self::MAN => 'man',
        self::WOMAN => 'woman',
    ];
    const ROLE_USER = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';

    const ROLES = [
        self::ROLE_ADMIN => 'Admin',
        self::ROLE_USER => 'User',
    ];

    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;
    const STATUS_DELETED = 2;

    const STATUSES = [
        self::STATUS_DISABLED => 'Disabled',
        self::STATUS_ENABLED => 'Enabled',
        self::STATUS_DELETED => 'Deleted',
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $phonenumber = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $status = null;

    #[ORM\Column(length: 255)]
    private ?string $sex = null;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Personnel::class, fetch: 'EAGER')]
    private Collection $createdPersonnels;

    #[ORM\OneToMany(mappedBy: 'updatedBy', targetEntity: Personnel::class, fetch: 'EAGER')]
    private Collection $updatedPersonnels;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Speciality::class, fetch: 'EAGER')]
    private Collection $createdSpecialities;

    #[ORM\OneToMany(mappedBy: 'updatedBy', targetEntity: Speciality::class, fetch: 'EAGER')]
    private Collection $updatedSpecialities;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Patient::class, fetch: 'EAGER')]
    private Collection $createdPatients;

    #[ORM\OneToMany(mappedBy: 'updatedBy', targetEntity: Patient::class, fetch: 'EAGER')]
    private Collection $updatedPatients;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Service::class, fetch: 'EAGER')]
    private Collection $createdServices;

    #[ORM\OneToMany(mappedBy: 'updatedBy', targetEntity: Service::class, fetch: 'EAGER')]
    private Collection $updatedServices;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Parametre::class, fetch: 'EAGER')]
    private Collection $createdParameters;

    #[ORM\OneToMany(mappedBy: 'updatedBy', targetEntity: Parametre::class, fetch: 'EAGER')]
    private Collection $updatedParameters;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Result::class, fetch: 'EAGER')]
    private Collection $createdResults;

    #[ORM\OneToMany(mappedBy: 'updatedBy', targetEntity: Result::class, fetch: 'EAGER')]
    private Collection $updatedResults;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: MedicalOrder::class, fetch: 'EAGER')]
    private Collection $createdMedicalOrders;

    #[ORM\OneToMany(mappedBy: 'updatedBy', targetEntity: MedicalOrder::class, fetch: 'EAGER')]
    private Collection $updatedMedicalOrders;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Drug::class, fetch: 'EAGER')]
    private Collection $createdDrugs;

    #[ORM\OneToMany(mappedBy: 'updatedBy', targetEntity: Drug::class, fetch: 'EAGER')]
    private Collection $updatedDrugs;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: MedicalExams::class, fetch: 'EAGER')]
    private Collection $createdMedicalExams;

    #[ORM\OneToMany(mappedBy: 'updatedBy', targetEntity: MedicalExams::class, fetch: 'EAGER')]
    private Collection $updatedMedicalExams;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Room::class, fetch: 'EAGER')]
    private Collection $createdRooms;

    #[ORM\OneToMany(mappedBy: 'updatedBy', targetEntity: Room::class, fetch: 'EAGER')]
    private Collection $updatedRooms;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Hospitilization::class, fetch: 'EAGER')]
    private Collection $createdHospitilizations;

    #[ORM\OneToMany(mappedBy: 'updatedBy', targetEntity: Hospitilization::class, fetch: 'EAGER')]
    private Collection $updatedHospitilizations;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: ConfigDesign::class, fetch: 'EAGER')]
    private Collection $createdConfigDesigns;

    #[ORM\OneToMany(mappedBy: 'updatedBy', targetEntity: ConfigDesign::class, fetch: 'EAGER')]
    private Collection $updatedConfigDesigns;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Consultation::class, fetch: 'EAGER')]
    private Collection $createdConsultations;

    #[ORM\OneToMany(mappedBy: 'updatedBy', targetEntity: Consultation::class, fetch: 'EAGER')]
    private Collection $updatedConsultations;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: PersonnelService::class, fetch: 'EAGER')]
    private Collection $createdPersonnelServices;

    #[ORM\OneToMany(mappedBy: 'updateBy', targetEntity: PersonnelService::class, fetch: 'EAGER')]
    private Collection $updatedPersonnelService;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Garde::class, fetch: 'EAGER')]
    private Collection $createdGardes;

    #[ORM\OneToMany(mappedBy: 'updatedBy', targetEntity: Garde::class, fetch: 'EAGER')]
    private Collection $updatedGardes;

    public function __construct()
    {
        $this->createdPersonnels = new ArrayCollection();
        $this->updatedPersonnels = new ArrayCollection();
        $this->createdSpecialities = new ArrayCollection();
        $this->updatedSpecialities = new ArrayCollection();
        $this->createdPatients = new ArrayCollection();
        $this->updatedPatients = new ArrayCollection();
        $this->createdServices = new ArrayCollection();
        $this->updatedServices = new ArrayCollection();
        $this->createdParameters = new ArrayCollection();
        $this->updatedParameters = new ArrayCollection();
        $this->createdResults = new ArrayCollection();
        $this->updatedResults = new ArrayCollection();
        $this->createdMedicalOrders = new ArrayCollection();
        $this->updatedMedicalOrders = new ArrayCollection();
        $this->createdDrugs = new ArrayCollection();
        $this->updatedDrugs = new ArrayCollection();
        $this->createdMedicalExams = new ArrayCollection();
        $this->updatedMedicalExams = new ArrayCollection();
        $this->createdRooms = new ArrayCollection();
        $this->updatedRooms = new ArrayCollection();
        $this->createdHospitilizations = new ArrayCollection();
        $this->updatedHospitilizations = new ArrayCollection();
        $this->createdConfigDesigns = new ArrayCollection();
        $this->updatedConfigDesigns = new ArrayCollection();
        $this->createdConsultations = new ArrayCollection();
        $this->updatedConsultations = new ArrayCollection();
        $this->createdPersonnelServices = new ArrayCollection();
        $this->updatedPersonnelService = new ArrayCollection();
        $this->createdGardes = new ArrayCollection();
        $this->updatedGardes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhonenumber(): ?string
    {
        return $this->phonenumber;
    }

    public function setPhonenumber(string $phonenumber): self
    {
        $this->phonenumber = $phonenumber;

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

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getData(): array
    {
        return [
            "id" => $this->getId(),
            "firstname" => $this->firstname,
            "lastname" => $this->lastname,
            "sex" => $this->sex,
            "phoneNumber" => $this->phonenumber,
            "email" => $this->email,
            "roles" => $this->roles,
            "status" => (int)$this->status
        ];
    }

    /**
     * @return Collection<int, Personnel>
     */
    public function getCreatedPersonnels(): Collection
    {
        return $this->createdPersonnels;
    }

    public function addCreatedPersonnel(Personnel $createdPersonnel): self
    {
        if (!$this->createdPersonnels->contains($createdPersonnel)) {
            $this->createdPersonnels->add($createdPersonnel);
            $createdPersonnel->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCreatedPersonnel(Personnel $createdPersonnel): self
    {
        if ($this->createdPersonnels->removeElement($createdPersonnel)) {
            // set the owning side to null (unless already changed)
            if ($createdPersonnel->getCreatedBy() === $this) {
                $createdPersonnel->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Personnel>
     */
    public function getUpdatedPersonnels(): Collection
    {
        return $this->updatedPersonnels;
    }

    public function addUpdatedPersonnel(Personnel $updatedPersonnel): self
    {
        if (!$this->updatedPersonnels->contains($updatedPersonnel)) {
            $this->updatedPersonnels->add($updatedPersonnel);
            $updatedPersonnel->setUpdatedBy($this);
        }

        return $this;
    }

    public function removeUpdatedPersonnel(Personnel $updatedPersonnel): self
    {
        if ($this->updatedPersonnels->removeElement($updatedPersonnel)) {
            // set the owning side to null (unless already changed)
            if ($updatedPersonnel->getUpdatedBy() === $this) {
                $updatedPersonnel->setUpdatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Speciality>
     */
    public function getCreatedSpecialities(): Collection
    {
        return $this->createdSpecialities;
    }

    public function addCreatedSpeciality(Speciality $createdSpeciality): self
    {
        if (!$this->createdSpecialities->contains($createdSpeciality)) {
            $this->createdSpecialities->add($createdSpeciality);
            $createdSpeciality->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCreatedSpeciality(Speciality $createdSpeciality): self
    {
        if ($this->createdSpecialities->removeElement($createdSpeciality)) {
            // set the owning side to null (unless already changed)
            if ($createdSpeciality->getCreatedBy() === $this) {
                $createdSpeciality->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Speciality>
     */
    public function getUpdatedSpecialities(): Collection
    {
        return $this->updatedSpecialities;
    }

    public function addUpdatedSpeciality(Speciality $updatedSpeciality): self
    {
        if (!$this->updatedSpecialities->contains($updatedSpeciality)) {
            $this->updatedSpecialities->add($updatedSpeciality);
            $updatedSpeciality->setUpdatedBy($this);
        }

        return $this;
    }

    public function removeUpdatedSpeciality(Speciality $updatedSpeciality): self
    {
        if ($this->updatedSpecialities->removeElement($updatedSpeciality)) {
            // set the owning side to null (unless already changed)
            if ($updatedSpeciality->getUpdatedBy() === $this) {
                $updatedSpeciality->setUpdatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Patient>
     */
    public function getCreatedPatients(): Collection
    {
        return $this->createdPatients;
    }

    public function addCreatedPatient(Patient $createdPatient): self
    {
        if (!$this->createdPatients->contains($createdPatient)) {
            $this->createdPatients->add($createdPatient);
            $createdPatient->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCreatedPatient(Patient $createdPatient): self
    {
        if ($this->createdPatients->removeElement($createdPatient)) {
            // set the owning side to null (unless already changed)
            if ($createdPatient->getCreatedBy() === $this) {
                $createdPatient->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Patient>
     */
    public function getUpdatedPatients(): Collection
    {
        return $this->updatedPatients;
    }

    public function addUpdatedPatient(Patient $updatedPatient): self
    {
        if (!$this->updatedPatients->contains($updatedPatient)) {
            $this->updatedPatients->add($updatedPatient);
            $updatedPatient->setUpdatedBy($this);
        }

        return $this;
    }

    public function removeUpdatedPatient(Patient $updatedPatient): self
    {
        if ($this->updatedPatients->removeElement($updatedPatient)) {
            // set the owning side to null (unless already changed)
            if ($updatedPatient->getUpdatedBy() === $this) {
                $updatedPatient->setUpdatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getCreatedServices(): Collection
    {
        return $this->createdServices;
    }

    public function addCreatedService(Service $createdService): self
    {
        if (!$this->createdServices->contains($createdService)) {
            $this->createdServices->add($createdService);
            $createdService->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCreatedService(Service $createdService): self
    {
        if ($this->createdServices->removeElement($createdService)) {
            // set the owning side to null (unless already changed)
            if ($createdService->getCreatedBy() === $this) {
                $createdService->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getUpdatedServices(): Collection
    {
        return $this->updatedServices;
    }

    public function addUpdatedService(Service $updatedService): self
    {
        if (!$this->updatedServices->contains($updatedService)) {
            $this->updatedServices->add($updatedService);
            $updatedService->setUpdatedBy($this);
        }

        return $this;
    }

    public function removeUpdatedService(Service $updatedService): self
    {
        if ($this->updatedServices->removeElement($updatedService)) {
            // set the owning side to null (unless already changed)
            if ($updatedService->getUpdatedBy() === $this) {
                $updatedService->setUpdatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Parametre>
     */
    public function getCreatedParameters(): Collection
    {
        return $this->createdParameters;
    }

    public function addCreatedParameter(Parametre $createdParameter): self
    {
        if (!$this->createdParameters->contains($createdParameter)) {
            $this->createdParameters->add($createdParameter);
            $createdParameter->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCreatedParameter(Parametre $createdParameter): self
    {
        if ($this->createdParameters->removeElement($createdParameter)) {
            // set the owning side to null (unless already changed)
            if ($createdParameter->getCreatedBy() === $this) {
                $createdParameter->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Parametre>
     */
    public function getUpdatedParameters(): Collection
    {
        return $this->updatedParameters;
    }

    public function addUpdatedParameter(Parametre $updatedParameter): self
    {
        if (!$this->updatedParameters->contains($updatedParameter)) {
            $this->updatedParameters->add($updatedParameter);
            $updatedParameter->setUpdatedBy($this);
        }

        return $this;
    }

    public function removeUpdatedParameter(Parametre $updatedParameter): self
    {
        if ($this->updatedParameters->removeElement($updatedParameter)) {
            // set the owning side to null (unless already changed)
            if ($updatedParameter->getUpdatedBy() === $this) {
                $updatedParameter->setUpdatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Result>
     */
    public function getCreatedResults(): Collection
    {
        return $this->createdResults;
    }

    public function addCreatedResult(Result $createdResult): self
    {
        if (!$this->createdResults->contains($createdResult)) {
            $this->createdResults->add($createdResult);
            $createdResult->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCreatedResult(Result $createdResult): self
    {
        if ($this->createdResults->removeElement($createdResult)) {
            // set the owning side to null (unless already changed)
            if ($createdResult->getCreatedBy() === $this) {
                $createdResult->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Result>
     */
    public function getUpdatedResults(): Collection
    {
        return $this->updatedResults;
    }

    public function addUpdatedResult(Result $updatedResult): self
    {
        if (!$this->updatedResults->contains($updatedResult)) {
            $this->updatedResults->add($updatedResult);
            $updatedResult->setUpdatedBy($this);
        }

        return $this;
    }

    public function removeUpdatedResult(Result $updatedResult): self
    {
        if ($this->updatedResults->removeElement($updatedResult)) {
            // set the owning side to null (unless already changed)
            if ($updatedResult->getUpdatedBy() === $this) {
                $updatedResult->setUpdatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MedicalOrder>
     */
    public function getCreatedMedicalOrders(): Collection
    {
        return $this->createdMedicalOrders;
    }

    public function addCreatedMedicalOrder(MedicalOrder $createdMedicalOrder): self
    {
        if (!$this->createdMedicalOrders->contains($createdMedicalOrder)) {
            $this->createdMedicalOrders->add($createdMedicalOrder);
            $createdMedicalOrder->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCreatedMedicalOrder(MedicalOrder $createdMedicalOrder): self
    {
        if ($this->createdMedicalOrders->removeElement($createdMedicalOrder)) {
            // set the owning side to null (unless already changed)
            if ($createdMedicalOrder->getCreatedBy() === $this) {
                $createdMedicalOrder->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MedicalOrder>
     */
    public function getUpdatedMedicalOrders(): Collection
    {
        return $this->updatedMedicalOrders;
    }

    public function addUpdatedMedicalOrder(MedicalOrder $updatedMedicalOrder): self
    {
        if (!$this->updatedMedicalOrders->contains($updatedMedicalOrder)) {
            $this->updatedMedicalOrders->add($updatedMedicalOrder);
            $updatedMedicalOrder->setUpdatedBy($this);
        }

        return $this;
    }

    public function removeUpdatedMedicalOrder(MedicalOrder $updatedMedicalOrder): self
    {
        if ($this->updatedMedicalOrders->removeElement($updatedMedicalOrder)) {
            // set the owning side to null (unless already changed)
            if ($updatedMedicalOrder->getUpdatedBy() === $this) {
                $updatedMedicalOrder->setUpdatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Drug>
     */
    public function getCreatedDrugs(): Collection
    {
        return $this->createdDrugs;
    }

    public function addCreatedDrug(Drug $createdDrug): self
    {
        if (!$this->createdDrugs->contains($createdDrug)) {
            $this->createdDrugs->add($createdDrug);
            $createdDrug->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCreatedDrug(Drug $createdDrug): self
    {
        if ($this->createdDrugs->removeElement($createdDrug)) {
            // set the owning side to null (unless already changed)
            if ($createdDrug->getCreatedBy() === $this) {
                $createdDrug->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Drug>
     */
    public function getUpdatedDrugs(): Collection
    {
        return $this->updatedDrugs;
    }

    public function addUpdatedDrug(Drug $updatedDrug): self
    {
        if (!$this->updatedDrugs->contains($updatedDrug)) {
            $this->updatedDrugs->add($updatedDrug);
            $updatedDrug->setUpdatedBy($this);
        }

        return $this;
    }

    public function removeUpdatedDrug(Drug $updatedDrug): self
    {
        if ($this->updatedDrugs->removeElement($updatedDrug)) {
            // set the owning side to null (unless already changed)
            if ($updatedDrug->getUpdatedBy() === $this) {
                $updatedDrug->setUpdatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MedicalExams>
     */
    public function getCreatedMedicalExams(): Collection
    {
        return $this->createdMedicalExams;
    }

    public function addCreatedMedicalExam(MedicalExams $createdMedicalExam): self
    {
        if (!$this->createdMedicalExams->contains($createdMedicalExam)) {
            $this->createdMedicalExams->add($createdMedicalExam);
            $createdMedicalExam->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCreatedMedicalExam(MedicalExams $createdMedicalExam): self
    {
        if ($this->createdMedicalExams->removeElement($createdMedicalExam)) {
            // set the owning side to null (unless already changed)
            if ($createdMedicalExam->getCreatedBy() === $this) {
                $createdMedicalExam->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MedicalExams>
     */
    public function getUpdatedMedicalExams(): Collection
    {
        return $this->updatedMedicalExams;
    }

    public function addUpdatedMedicalExam(MedicalExams $updatedMedicalExam): self
    {
        if (!$this->updatedMedicalExams->contains($updatedMedicalExam)) {
            $this->updatedMedicalExams->add($updatedMedicalExam);
            $updatedMedicalExam->setUpdatedBy($this);
        }

        return $this;
    }

    public function removeUpdatedMedicalExam(MedicalExams $updatedMedicalExam): self
    {
        if ($this->updatedMedicalExams->removeElement($updatedMedicalExam)) {
            // set the owning side to null (unless already changed)
            if ($updatedMedicalExam->getUpdatedBy() === $this) {
                $updatedMedicalExam->setUpdatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Room>
     */
    public function getCreatedRooms(): Collection
    {
        return $this->createdRooms;
    }

    public function addCreatedRoom(Room $createdRoom): self
    {
        if (!$this->createdRooms->contains($createdRoom)) {
            $this->createdRooms->add($createdRoom);
            $createdRoom->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCreatedRoom(Room $createdRoom): self
    {
        if ($this->createdRooms->removeElement($createdRoom)) {
            // set the owning side to null (unless already changed)
            if ($createdRoom->getCreatedBy() === $this) {
                $createdRoom->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Room>
     */
    public function getUpdatedRooms(): Collection
    {
        return $this->updatedRooms;
    }

    public function addUpdatedRoom(Room $updatedRoom): self
    {
        if (!$this->updatedRooms->contains($updatedRoom)) {
            $this->updatedRooms->add($updatedRoom);
            $updatedRoom->setUpdatedBy($this);
        }

        return $this;
    }

    public function removeUpdatedRoom(Room $updatedRoom): self
    {
        if ($this->updatedRooms->removeElement($updatedRoom)) {
            // set the owning side to null (unless already changed)
            if ($updatedRoom->getUpdatedBy() === $this) {
                $updatedRoom->setUpdatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Hospitilization>
     */
    public function getCreatedHospitilizations(): Collection
    {
        return $this->createdHospitilizations;
    }

    public function addCreatedHospitilization(Hospitilization $createdHospitilization): self
    {
        if (!$this->createdHospitilizations->contains($createdHospitilization)) {
            $this->createdHospitilizations->add($createdHospitilization);
            $createdHospitilization->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCreatedHospitilization(Hospitilization $createdHospitilization): self
    {
        if ($this->createdHospitilizations->removeElement($createdHospitilization)) {
            // set the owning side to null (unless already changed)
            if ($createdHospitilization->getCreatedBy() === $this) {
                $createdHospitilization->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Hospitilization>
     */
    public function getUpdatedHospitilizations(): Collection
    {
        return $this->updatedHospitilizations;
    }

    public function addUpdatedHospitilization(Hospitilization $updatedHospitilization): self
    {
        if (!$this->updatedHospitilizations->contains($updatedHospitilization)) {
            $this->updatedHospitilizations->add($updatedHospitilization);
            $updatedHospitilization->setUpdatedBy($this);
        }

        return $this;
    }

    public function removeUpdatedHospitilization(Hospitilization $updatedHospitilization): self
    {
        if ($this->updatedHospitilizations->removeElement($updatedHospitilization)) {
            // set the owning side to null (unless already changed)
            if ($updatedHospitilization->getUpdatedBy() === $this) {
                $updatedHospitilization->setUpdatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ConfigDesign>
     */
    public function getCreatedConfigDesigns(): Collection
    {
        return $this->createdConfigDesigns;
    }

    public function addCreatedConfigDesign(ConfigDesign $createdConfigDesign): self
    {
        if (!$this->createdConfigDesigns->contains($createdConfigDesign)) {
            $this->createdConfigDesigns->add($createdConfigDesign);
            $createdConfigDesign->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCreatedConfigDesign(ConfigDesign $createdConfigDesign): self
    {
        if ($this->createdConfigDesigns->removeElement($createdConfigDesign)) {
            // set the owning side to null (unless already changed)
            if ($createdConfigDesign->getCreatedBy() === $this) {
                $createdConfigDesign->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ConfigDesign>
     */
    public function getUpdatedConfigDesigns(): Collection
    {
        return $this->updatedConfigDesigns;
    }

    public function addUpdatedConfigDesign(ConfigDesign $updatedConfigDesign): self
    {
        if (!$this->updatedConfigDesigns->contains($updatedConfigDesign)) {
            $this->updatedConfigDesigns->add($updatedConfigDesign);
            $updatedConfigDesign->setUpdatedBy($this);
        }

        return $this;
    }

    public function removeUpdatedConfigDesign(ConfigDesign $updatedConfigDesign): self
    {
        if ($this->updatedConfigDesigns->removeElement($updatedConfigDesign)) {
            // set the owning side to null (unless already changed)
            if ($updatedConfigDesign->getUpdatedBy() === $this) {
                $updatedConfigDesign->setUpdatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Consultation>
     */
    public function getCreatedConsultations(): Collection
    {
        return $this->createdConsultations;
    }

    public function addCreatedConsultation(Consultation $createdConsultation): self
    {
        if (!$this->createdConsultations->contains($createdConsultation)) {
            $this->createdConsultations->add($createdConsultation);
            $createdConsultation->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCreatedConsultation(Consultation $createdConsultation): self
    {
        if ($this->createdConsultations->removeElement($createdConsultation)) {
            // set the owning side to null (unless already changed)
            if ($createdConsultation->getCreatedBy() === $this) {
                $createdConsultation->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Consultation>
     */
    public function getUpdatedConsultations(): Collection
    {
        return $this->updatedConsultations;
    }

    public function addUpdatedConsultation(Consultation $updatedConsultation): self
    {
        if (!$this->updatedConsultations->contains($updatedConsultation)) {
            $this->updatedConsultations->add($updatedConsultation);
            $updatedConsultation->setUpdatedBy($this);
        }

        return $this;
    }

    public function removeUpdatedConsultation(Consultation $updatedConsultation): self
    {
        if ($this->updatedConsultations->removeElement($updatedConsultation)) {
            // set the owning side to null (unless already changed)
            if ($updatedConsultation->getUpdatedBy() === $this) {
                $updatedConsultation->setUpdatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PersonnelService>
     */
    public function getCreatedPersonnelServices(): Collection
    {
        return $this->createdPersonnelServices;
    }

    public function addCreatedPersonnelService(PersonnelService $createdPersonnelService): self
    {
        if (!$this->createdPersonnelServices->contains($createdPersonnelService)) {
            $this->createdPersonnelServices->add($createdPersonnelService);
            $createdPersonnelService->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCreatedPersonnelService(PersonnelService $createdPersonnelService): self
    {
        if ($this->createdPersonnelServices->removeElement($createdPersonnelService)) {
            // set the owning side to null (unless already changed)
            if ($createdPersonnelService->getCreatedBy() === $this) {
                $createdPersonnelService->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PersonnelService>
     */
    public function getUpdatedPersonnelService(): Collection
    {
        return $this->updatedPersonnelService;
    }

    public function addUpdatedPersonnelService(PersonnelService $updatedPersonnelService): self
    {
        if (!$this->updatedPersonnelService->contains($updatedPersonnelService)) {
            $this->updatedPersonnelService->add($updatedPersonnelService);
            $updatedPersonnelService->setUpdateBy($this);
        }

        return $this;
    }

    public function removeUpdatedPersonnelService(PersonnelService $updatedPersonnelService): self
    {
        if ($this->updatedPersonnelService->removeElement($updatedPersonnelService)) {
            // set the owning side to null (unless already changed)
            if ($updatedPersonnelService->getUpdateBy() === $this) {
                $updatedPersonnelService->setUpdateBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Garde>
     */
    public function getCreatedGardes(): Collection
    {
        return $this->createdGardes;
    }

    public function addCreatedGarde(Garde $createdGarde): self
    {
        if (!$this->createdGardes->contains($createdGarde)) {
            $this->createdGardes->add($createdGarde);
            $createdGarde->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCreatedGarde(Garde $createdGarde): self
    {
        if ($this->createdGardes->removeElement($createdGarde)) {
            // set the owning side to null (unless already changed)
            if ($createdGarde->getCreatedBy() === $this) {
                $createdGarde->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Garde>
     */
    public function getUpdatedGardes(): Collection
    {
        return $this->updatedGardes;
    }

    public function addUpdatedGarde(Garde $updatedGarde): self
    {
        if (!$this->updatedGardes->contains($updatedGarde)) {
            $this->updatedGardes->add($updatedGarde);
            $updatedGarde->setUpdatedBy($this);
        }

        return $this;
    }

    public function removeUpdatedGarde(Garde $updatedGarde): self
    {
        if ($this->updatedGardes->removeElement($updatedGarde)) {
            // set the owning side to null (unless already changed)
            if ($updatedGarde->getUpdatedBy() === $this) {
                $updatedGarde->setUpdatedBy(null);
            }
        }

        return $this;
    }
}
