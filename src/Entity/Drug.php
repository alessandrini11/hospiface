<?php

namespace App\Entity;

use App\Interface\EntityInterface;
use App\Repository\DrugRepository;
use App\Trait\DateTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

#[ORM\Entity(repositoryClass: DrugRepository::class)]
#[HasLifecycleCallbacks]
class Drug implements EntityInterface
{
    use DateTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dosage = null;

    #[ORM\Column(nullable: true)]
    private ?bool $alternative = null;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'drugs')]
    private ?MedicalOrder $medicalOrder = null;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'createdDrugs')]
    private ?User $createdBy = null;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'updatedDrugs')]
    private ?User $updatedBy = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDosage(): ?string
    {
        return $this->dosage;
    }

    public function setDosage(?string $dosage): self
    {
        $this->dosage = $dosage;

        return $this;
    }

    public function isAlternative(): ?bool
    {
        return $this->alternative;
    }

    public function setAlternative(?bool $alternative): self
    {
        $this->alternative = $alternative;

        return $this;
    }

    public function getMedicalOrder(): ?MedicalOrder
    {
        return $this->medicalOrder;
    }

    public function setMedicalOrder(?MedicalOrder $medicalOrder): self
    {
        $this->medicalOrder = $medicalOrder;

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
            "id" => $this->id,
            "name" => $this->name,
            "dosage" => $this->dosage,
            "is_alternative" => $this->alternative
        ];
    }
}
