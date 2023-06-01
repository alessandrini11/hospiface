<?php

namespace App\Entity;

use App\Repository\GardeRepository;
use App\Trait\DateTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

#[ORM\Entity(repositoryClass: GardeRepository::class)]
#[HasLifecycleCallbacks]
class Garde
{
    use DateTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $status = null;

    #[ORM\OneToMany(mappedBy: 'garde', targetEntity: PersonnelGarde::class, fetch: 'EAGER', cascade: ['remove'])]
    private Collection $personnelGardes;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'createdGardes')]
    private ?User $createdBy = null;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'updatedGardes')]
    private ?User $updatedBy = null;

    public function __construct()
    {
        $this->personnelGardes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

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
            $personnelGarde->setGarde($this);
        }

        return $this;
    }

    public function removePersonnelGarde(PersonnelGarde $personnelGarde): self
    {
        if ($this->personnelGardes->removeElement($personnelGarde)) {
            // set the owning side to null (unless already changed)
            if ($personnelGarde->getGarde() === $this) {
                $personnelGarde->setGarde(null);
            }
        }

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
}
