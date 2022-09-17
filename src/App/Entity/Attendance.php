<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\CreateAttendanceController;
use App\Controller\UpdateAttendanceController;
use App\Repository\AttendanceRepository;
use Doctrine\ORM\Mapping as ORM;
use Model\Attendance\PersistAttendanceDTO;
use Symfony\Component\Serializer\Annotation as Serializer;


#[
    ORM\Entity(
        repositoryClass: AttendanceRepository::class),
        ORM\Table(name: 'attendance'),
        ApiResource(
            collectionOperations: [
                'get' => [
                    'normalization_context' => [
                        'groups' => ['get_attendances'],
                    ],
                ],
                'post' => [
                    'controller' => CreateAttendanceController::class,
                    // 'path' => CreateAttendanceController::PATH
                    // 'input' => PersistAttendanceDTO::class
                ],
            ],
            itemOperations: [
                'put' => ['controller'=> UpdateAttendanceController::class],
                'get' => [
                    'controller' => NotFoundAction::class,
                    'read' => false,
                    'output' => false,
                ],
            ],
            formats: ['json']
    )
]
class Attendance
{
    #[
        ORM\Id,
        ORM\GeneratedValue,
        ORM\Column,
        Serializer\Groups(groups: ['get_attendances'])

    ]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'attendances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[
        ORM\Column(length: 100, nullable: true),
        Serializer\Groups(groups: ['get_attendances'])

    ]
    private ?string $description = null;

    #[
        ORM\Column(type: 'datetime', nullable: true),
        Serializer\Groups(groups: ['get_attendances'])
    ]
    private ?\DateTimeInterface $entered_at = null;

    #[
        ORM\Column(type: 'datetime', nullable: true),
        Serializer\Groups(groups: ['get_attendances'])

    ]
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
