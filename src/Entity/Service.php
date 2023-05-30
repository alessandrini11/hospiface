<?php

namespace App\Entity;

use App\Interface\EntityInterface;
use App\Repository\ServiceRepository;
use App\Trait\DateTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
#[HasLifecycleCallbacks]
#[UniqueEntity(['name'], message: 'the service already exist')]
class Service implements EntityInterface
{
    use DateTrait;
    const ENABLED = 1;
    const DISABLED = 0;
    const STATUS = [
      self::DISABLED => 'disabled',
      self::ENABLED => 'enabled'
    ];
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: PersonnelService::class, fetch: 'EAGER', cascade: ['remove'])]
    private Collection $personnelServices;

    #[ORM\ManyToOne(inversedBy: 'createdServices')]
    private ?User $createdBy = null;

    #[ORM\ManyToOne(inversedBy: 'updatedServices')]
    private ?User $updatedBy = null;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: PersonnelGarde::class, fetch: 'EAGER', cascade: ['remove'])]
    private Collection $personnelGardes;

    public function __construct()
    {
        $this->personnelServices = new ArrayCollection();
        $this->personnelGardes = new ArrayCollection();
    }

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
     * @return Collection<int, PersonnelService>
     */
    public function getPersonnelServices(): Collection
    {
        return $this->personnelServices;
    }

    public function addPersonnelService(PersonnelService $personnelService): self
    {
        if (!$this->personnelServices->contains($personnelService)) {
            $this->personnelServices->add($personnelService);
            $personnelService->setService($this);
        }

        return $this;
    }

    public function removePersonnelService(PersonnelService $personnelService): self
    {
        if ($this->personnelServices->removeElement($personnelService)) {
            // set the owning side to null (unless already changed)
            if ($personnelService->getService() === $this) {
                $personnelService->setService(null);
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
            $personnelGarde->setService($this);
        }

        return $this;
    }

    public function removePersonnelGarde(PersonnelGarde $personnelGarde): self
    {
        if ($this->personnelGardes->removeElement($personnelGarde)) {
            // set the owning side to null (unless already changed)
            if ($personnelGarde->getService() === $this) {
                $personnelGarde->setService(null);
            }
        }

        return $this;
    }

    public function getData(): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "status" => $this->status
        ];
    }
}
