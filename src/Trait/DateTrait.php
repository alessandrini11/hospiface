<?php

namespace App\Trait;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
trait DateTrait
{
    #[ORM\Column(nullable: true)]
    private ?DateTime $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?DateTime $updatedAt = null;

    /**
     * Get the date of creation
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the date of update.
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): self
    {
        $this->createdAt = new DateTime('now');

        return $this;
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): self
    {
        $this->updatedAt = new DateTime('now');

        return $this;
    }
}