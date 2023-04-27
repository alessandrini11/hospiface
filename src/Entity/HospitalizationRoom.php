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

    #[ORM\ManyToOne(inversedBy: 'hospitalizationRooms')]
    private ?Hospitilization $hospitalization = null;

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

    public function getHospitalization(): ?Hospitilization
    {
        return $this->hospitalization;
    }

    public function setHospitalization(?Hospitilization $hospitalization): self
    {
        $this->hospitalization = $hospitalization;

        return $this;
    }
}
