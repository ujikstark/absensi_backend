<?php

declare(strict_types=1);

namespace Model\User;

use Symfony\Component\Validator\Constraints as Assert;

final class UpdateUserDTO
{
    #[Assert\NotBlank]
    private string $name;
    
    #[Assert\NotBlank]    
    private ?\DateTime $birthDate = null;
    
    #[Assert\Type('bool')]
    private ?bool $gender = null;
    
    #[Assert\NotBlank]
    private ?string $address = null;

    #[
        Assert\NotBlank,
        Assert\Length(max: 20)
    ]
    private ?string $phoneNumber = null;

    #[
        Assert\NotBlank,
        Assert\Length(max: 50)
    ]
    private ?string $status = null;
    
    #[
        Assert\NotBlank,
        Assert\Length(max: 254)
    ]
    private ?string $description = null;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBirthDate(): ?\DateTime
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTime $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getGender(): bool
    {
        return $this->gender;
    }

    public function setGender(bool $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

}
