<?php

namespace App\Entity;

use App\Repository\HospitalizationRoomRepository;
use App\Trait\DateTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HospitalizationRoomRepository::class)]
#[ORM\HasLifecycleCallbacks]
class HospitalizationRoom
{
    use DateTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'hospitalizationRooms')]
    private ?Room $room = null;

    #[ORM\OneToOne(mappedBy: 'hospitalizationRoom', cascade: ['persist', 'remove'])]
    private ?Hospitilization $hospitilization = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function getHospitilization(): ?Hospitilization
    {
        return $this->hospitilization;
    }

    public function setHospitilization(?Hospitilization $hospitilization): self
    {
        // unset the owning side of the relation if necessary
        if ($hospitilization === null && $this->hospitilization !== null) {
            $this->hospitilization->setHospitalizationRoom(null);
        }

        // set the owning side of the relation if necessary
        if ($hospitilization !== null && $hospitilization->getHospitalizationRoom() !== $this) {
            $hospitilization->setHospitalizationRoom($this);
        }

        $this->hospitilization = $hospitilization;

        return $this;
    }
}
