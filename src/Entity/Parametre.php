<?php

namespace App\Entity;

use App\Interface\EntityInterface;
use App\Repository\ParametreRepository;
use App\Trait\DateTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

#[ORM\Entity(repositoryClass: ParametreRepository::class)]
#[HasLifecycleCallbacks]
class Parametre implements EntityInterface
{
    use DateTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $temparature = null;

    #[ORM\Column(nullable: true)]
    private ?float $bloodPressure = null;

    #[ORM\Column(nullable: true)]
    private ?float $weight = null;

    #[ORM\Column(nullable: true)]
    private ?float $height = null;

    #[ORM\ManyToOne(fetch: 'EAGER' , inversedBy: 'createdParameters')]
    private ?User $createdBy = null;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'updatedParameters')]
    private ?User $updatedBy = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTemparature(): ?float
    {
        return $this->temparature;
    }

    public function setTemparature(?float $temparature): self
    {
        $this->temparature = $temparature;

        return $this;
    }

    public function getBloodPressure(): ?float
    {
        return $this->bloodPressure;
    }

    public function setBloodPressure(?float $bloodPressure): self
    {
        $this->bloodPressure = $bloodPressure;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getHeight(): ?float
    {
        return $this->height;
    }

    public function setHeight(?float $height): self
    {
        $this->height = $height;

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

    public function getData(): array
    {
        return [
            "height" => $this->height,
            "weight" => $this->weight,
            "bloodPressure" => $this->bloodPressure,
            "temparature" => $this->temparature
        ];
    }
}
