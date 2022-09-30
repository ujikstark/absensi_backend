<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Attendance\CreateAttendanceController;
use App\Controller\Attendance\UpdatePresentController;
use App\Repository\AttendanceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Request;
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
                'postAttendance' => [
                    'controller' => CreateAttendanceController::class,
                    'path' => CreateAttendanceController::PATH,
                    'method' => Request::METHOD_POST,
                ],
            ],
            itemOperations: [
                'put' => ['controller'=> UpdateAttendanceController::class],
                'get',
                'updatePresent' => [
                    'controller' => UpdatePresentController::class,
                    'path' => UpdatePresentController::PATH,
                    'method' => Request::METHOD_PUT,
                ] 
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
    private ?\DateTimeInterface $enteredAt = null;

    #[
        ORM\Column(type: 'datetime', nullable: true),
        Serializer\Groups(groups: ['get_attendances'])

    ]
    private ?\DateTimeInterface $exitedAt = null;

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
        return $this->enteredAt;
    }

    public function setEnteredAt(?\DateTimeInterface $enteredAt): self
    {
        $this->enteredAt = $enteredAt;

        return $this;
    }

    public function getExitedAt(): ?\DateTimeInterface
    {
        return $this->exitedAt;
    }

    public function setExitedAt(?\DateTimeInterface $exitedAt): self
    {
        $this->exitedAt = $exitedAt;

        return $this;
    }
}
