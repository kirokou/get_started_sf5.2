<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Exception;

trait Timestamps
{
    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $updatedAt = null;

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     *
     * @throws Exception
     *
     * @return $this
     */
    public function setCreatedAtValue(): self
    {
        $this->createdAt = new DateTimeImmutable();

        return $this;
    }

    /**
     * @ORM\PreUpdate()
     *
     * @throws Exception
     *
     * @return $this
     */
    public function setUpdatedAtValue(): self
    {
        $this->updatedAt = new DateTime();

        return $this;
    }
}
