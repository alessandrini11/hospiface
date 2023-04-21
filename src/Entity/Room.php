<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $number = null;

    #[ORM\Column(nullable: true)]
    private ?int $beds = null;

    #[ORM\ManyToOne(inversedBy: 'createdRooms')]
    private ?User $createdBy = null;

    #[ORM\ManyToOne(inversedBy: 'updatedRooms')]
    private ?User $updatedBy = null;

    #[ORM\OneToMany(mappedBy: 'room', targetEntity: Hospitilization::class)]
    private Collection $hospitilizations;

    public function __construct()
    {
        $this->hospitilizations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getBeds(): ?int
    {
        return $this->beds;
    }

    public function setBeds(?int $beds): self
    {
        $this->beds = $beds;

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
            $hospitilization->setRoom($this);
        }

        return $this;
    }

    public function removeHospitilization(Hospitilization $hospitilization): self
    {
        if ($this->hospitilizations->removeElement($hospitilization)) {
            // set the owning side to null (unless already changed)
            if ($hospitilization->getRoom() === $this) {
                $hospitilization->setRoom(null);
            }
        }

        return $this;
    }
}
