<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AttendanceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttendanceRepository::class)]
#[ApiResource]
class Attendance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'attendances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeInterface $entered_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeInterface $exited_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getEnteredAt(): ?\DateTimeInterface
    {
        return $this->entered_at;
    }

    public function setEnteredAt(?\DateTimeInterface $entered_at): self
    {
        $this->entered_at = $entered_at;

        return $this;
    }

    public function getExitedAt(): ?\DateTimeInterface
    {
        return $this->exited_at;
    }

    public function setExitedAt(?\DateTimeInterface $exited_at): self
    {
        $this->exited_at = $exited_at;

        return $this;
    }
}
