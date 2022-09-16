<?php

declare(strict_types=1);

namespace Model\PersistAttendanceDTO;

use Symfony\Component\Validator\Constraints as Assert;

class PersistAttendanceDTO
{
    #[
        Assert\NotBlank(groups: ['create_attendance']),
    ]
    private ?\DateTimeInterface $entered_at = null;

    #[Assert\Length(max: 99, groups: ['update_todo'])]
    private ?string $description = null;

    #[
        Assert\NotBlank(groups: ['update_attendance']),
    ]
    private ?\DateTimeInterface $exited_at = null;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }


    public function getExitedAt(): ?\DateTimeInterface
    {
        return $this->exited_at;
    }

    public function setExitedAt(?\DateTimeInterface $exited_at): void
    {
        $this->exited_at = $exited_at;
    }

    public function getEnteredAt(): ?\DateTimeInterface
    {
        return $this->entered_at;
    }

    public function setEnteredAt(?\DateTimeInterface $entered_at): void
    {
        $this->entered_at = $entered_at;
    }
}
