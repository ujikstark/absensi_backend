<?php

// declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Attendance;
use App\Repository\UserRepository;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AttendanceFixtures extends Fixture implements DependentFixtureInterface
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager): void
    {

        $users = $this->userRepository->findAll();

        $date = new \DateTime();
        foreach ($users as $user) {
            for ($t = 0; $t < 5; ++$t) {
                $attendance = new Attendance();

                $attendance
                    ->setUser($user)
                    ->setEnteredAt($date)
                    ->setExitedAt($date)
                    ->setDescription('present')
                ;

                $manager->persist($attendance);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
