<?php

namespace App\Entity;

use App\Interface\EntityInterface;
use App\Repository\RoomRepository;
use App\Trait\DateTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Room implements EntityInterface
{
    use DateTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $number = null;

    #[ORM\Column(nullable: true)]
    private ?int $beds = null;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'createdRooms')]
    private ?User $createdBy = null;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'updatedRooms')]
    private ?User $updatedBy = null;

    #[ORM\OneToMany(mappedBy: 'room', targetEntity: HospitalizationRoom::class)]
    private Collection $hospitalizationRooms;

    public function __construct()
    {
        $this->hospitalizationRooms = new ArrayCollection();
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
            $hospitalizationRoom->setRoom($this);
        }

        return $this;
    }

    public function removeHospitalizationRoom(HospitalizationRoom $hospitalizationRoom): self
    {
        if ($this->hospitalizationRooms->removeElement($hospitalizationRoom)) {
            // set the owning side to null (unless already changed)
            if ($hospitalizationRoom->getRoom() === $this) {
                $hospitalizationRoom->setRoom(null);
            }
        }

        return $this;
    }

    public function getData(): array
    {
        return [
            "id" => $this->id,
            "number" => $this->number,
            "beds" => $this->beds
        ];
    }
}
