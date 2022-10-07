<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Account\GetMeController;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Model\User\CreateUserDTO;
use Model\User\UpdateUserDTO;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation as Serializer;



#[
    ORM\Entity(
        repositoryClass: UserRepository::class),
        ORM\Table(name: 'app_user'),
        ApiResource(
            collectionOperations: [
                'get' => [
                    'security' => "is_granted('ROLE_ADMIN')"
                ],
                'post' => [
                    'input' => CreateUserDTO::class,
                    'normalization_context' => [
                        'groups' => ['get_user'],
                    ],
                ]
            ],
            itemOperations: [
                'get' => [
                    'normalization_context' => [
                        'groups' => ['get_user'],
                    ],
                ],
                'put' => [
                    'input' => UpdateUserDTO::class,
                ],
                'getMe' => [
                    'method' => Request::METHOD_GET,
                    'normalization_context' => [
                        'groups' => ['get_me'],
                    ],
                    'path' => GetMeController::PATH,
                    'identifiers' => [],
                    'controller' => GetMeController::class,
                    'read' => false,
                    'openapi_context' => [
                        'tags' => ['Account'],
                        'summary' => 'Retrieves current user resource.',
                        'description' => 'Retrieves current user resource.',
                        'parameters' => [],
                        'responses' => [
                            Response::HTTP_UNAUTHORIZED => [
                                'description' => 'Unauthenticated user',
                                'content' => [
                                    'application/json' => [],
                                ],
                            ],
                        ],
                    ],],
            ],
            formats: ['json']
    )
]
#[UniqueEntity('username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[
        ORM\Id,
        ORM\GeneratedValue,
        ORM\Column,
        Serializer\Groups(groups: [
            'get_user',
            'get_me'
        ])
    ]
    private ?int $id = null;

    #[
        ORM\Column(length: 180),
        Serializer\Groups(groups: [
            'get_user',
            'get_me',
        ])
    ]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[
        ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true),
        Serializer\Groups(groups: [
            'get_user',
        ])
    ]
    private ?\DateTimeInterface $birthDate = null;

    #[ORM\Column(nullable: true)]
    private ?bool $gender = null;

    #[
        ORM\Column(type: Types::TEXT, nullable: true),
        Serializer\Groups(groups: [
        'get_user',
        ])
    ]
    private ?string $address = null;

    #[
        ORM\Column(length: 20, nullable: true),
        Serializer\Groups(groups: [
            'get_user',
        ])
    ]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $status = null;

    #[
        ORM\Column(length: 255, nullable: true),
        Serializer\Groups(groups: [
            'get_user',
        ])
    ]
    private ?string $description = null;

    #[ORM\Column(type: 'json')]
    private $roles = [];    

    #[
        ORM\Column(type: 'datetime'),
        Serializer\Groups(groups: [
            'get_user',
        ])
    ]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $endedAt = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Attendance::class, orphanRemoval: true)]
    private Collection $attendances;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->attendances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function isGender(): ?bool
    {
        return $this->gender;
    }

    public function setGender(?bool $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

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

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getEndedAt(): ?\DateTimeInterface
    {
        return $this->endedAt;
    }

    public function setEndedAt(?\DateTimeInterface $endedAt): self
    {
        $this->endedAt = $endedAt;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';


        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Attendance>
     */
    public function getAttendances(): Collection
    {
        return $this->attendances;
    }

    public function addAttendance(Attendance $attendance): self
    {
        if (!$this->attendances->contains($attendance)) {
            $this->attendances->add($attendance);
            $attendance->setUser($this);
        }

        return $this;
    }

    public function removeAttendance(Attendance $attendance): self
    {
        if ($this->attendances->removeElement($attendance)) {
            // set the owning side to null (unless already changed)
            if ($attendance->getUser() === $this) {
                $attendance->setUser(null);
            }
        }

        return $this;
    }

    #[Serializer\Groups(groups: ['get_me'])]
    public function getLastAttendance(): ?Attendance
    {
        $attendance = $this->attendances->last();

        if (false === $attendance) {
            return null;
        }

        return $attendance;
    }
}
