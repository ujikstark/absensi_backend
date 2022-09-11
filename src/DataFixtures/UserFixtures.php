<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;


class UserFixtures extends Fixture
{

    public const DEFAULT_USERNAME = 'test';
    public const DEFAULT_PASSWORD = 'test';
    public const DEFAULT_NAME = 'test';

    private $hasher;

    public function __construct(
        UserPasswordHasherInterface $hasher
    ) {
      $this->hasher = $hasher;  
    }

    public function load(ObjectManager $manager): void
    {
        $defaultUser = new User();
        $password = $this->hasher->hashPassword($defaultUser, self::DEFAULT_PASSWORD);
        $defaultUser
            ->setUsername(self::DEFAULT_USERNAME)
            ->setName(self::DEFAULT_NAME)
            ->setPassword($password)
            ->setCreatedAt(new DateTimeImmutable());

        $manager->persist($defaultUser);
        
        $faker = Factory::create();

        for ($i = 0; $i < 5; $i++) {
            $user = new User();

            $password = $this->hasher->hashPassword($user, self::DEFAULT_PASSWORD);
            
            $user
                ->setUsername($faker->userName())
                ->setName($faker->name())
                ->setPassword($password);

            $manager->persist($user);
                
        }

        $manager->flush();

    }

}
