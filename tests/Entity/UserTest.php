<?php

declare(strict_types=1);

namespace Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $testedObject;

    protected function setUp(): void
    {
        $this->testedObject = new User();
    }

    public function testGetUsername(): void
    {
        $username = 'admin';

        $user = $this->testedObject->setUsername($username);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($username, $this->testedObject->getUsername());
    }

    public function testGetRoles(): void
    {
        $roleAdmin = ['ROLE_ADMIN'];

        $user = $this->testedObject->setRoles($roleAdmin);

        $this->assertInstanceOf(User::class, $user);
        $this->assertContains('ROLE_USER', $this->testedObject->getRoles());
        $this->assertContains('ROLE_ADMIN', $this->testedObject->getRoles());
    }

    public function testGetPassword(): void
    {
        $password = 'password';

        $user = $this->testedObject->setPassword($password);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($password, $this->testedObject->getPassword());
    }


    public function testGetName(): void
    {
        $name = 'john';

        $user = $this->testedObject->setName($name);
        
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($name, $user->getName());
    }


    public function testEraseCredentials(): void
    {
        $this->assertNull($this->testedObject->eraseCredentials());
    }
}