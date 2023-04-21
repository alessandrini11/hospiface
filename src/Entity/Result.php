<?php

namespace App\Entity;

use App\Repository\ResultRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResultRepository::class)]
class Result
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $interpretation = null;

    #[ORM\ManyToOne(inversedBy: 'createdResults')]
    private ?User $createdBy = null;

    #[ORM\ManyToOne(inversedBy: 'updatedResults')]
    private ?User $updatedBy = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?MedicalOrder $medicalOrder = null;

    #[ORM\OneToMany(mappedBy: 'result', targetEntity: MedicalExams::class)]
    private Collection $medicalExam;

    public function __construct()
    {
        $this->medicalExam = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInterpretation(): ?string
    {
        return $this->interpretation;
    }

    public function setInterpretation(?string $interpretation): self
    {
        $this->interpretation = $interpretation;

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

    public function getMedicalOrder(): ?MedicalOrder
    {
        return $this->medicalOrder;
    }

    public function setMedicalOrder(?MedicalOrder $medicalOrder): self
    {
        $this->medicalOrder = $medicalOrder;

        return $this;
    }

    /**
     * @return Collection<int, MedicalExams>
     */
    public function getMedicalExam(): Collection
    {
        return $this->medicalExam;
    }

    public function addMedicalExam(MedicalExams $medicalExam): self
    {
        if (!$this->medicalExam->contains($medicalExam)) {
            $this->medicalExam->add($medicalExam);
            $medicalExam->setResult($this);
        }

        return $this;
    }

    public function removeMedicalExam(MedicalExams $medicalExam): self
    {
        if ($this->medicalExam->removeElement($medicalExam)) {
            // set the owning side to null (unless already changed)
            if ($medicalExam->getResult() === $this) {
                $medicalExam->setResult(null);
            }
        }

        return $this;
    }
}
