<?php

declare(strict_types=1);

namespace Model\User;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateUserDTO
{
    #[
        Assert\NotBlank,
    ]
    private string $name;

    #[
        Assert\Regex(pattern: '/^[a-zA-Z0-9]{3,}$/'),
        Assert\NotBlank
    ]
    private string $username;

    #[
        Assert\NotBlank,
        Assert\Length(min: 4),
        Assert\Regex(pattern: '/\d/')
    ]
    private string $password;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

}
