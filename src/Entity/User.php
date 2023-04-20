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

    const SEXS = [
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

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Personnel::class)]
    private Collection $createdPersonnels;

    #[ORM\OneToMany(mappedBy: 'updatedBy', targetEntity: Personnel::class)]
    private Collection $updatedPersonnels;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Speciality::class)]
    private Collection $createdSpecialities;

    #[ORM\OneToMany(mappedBy: 'updatedBy', targetEntity: Speciality::class)]
    private Collection $updatedSpecialities;

    public function __construct()
    {
        $this->createdPersonnels = new ArrayCollection();
        $this->updatedPersonnels = new ArrayCollection();
        $this->createdSpecialities = new ArrayCollection();
        $this->updatedSpecialities = new ArrayCollection();
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
}
