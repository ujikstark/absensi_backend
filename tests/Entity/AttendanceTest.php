<?php

declare(strict_types=1);

namespace Tests\Unit\App\Entity;

use App\Entity\Attendance;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class AttendanceTest extends TestCase
{
    private Attendance $testedObject;

    protected function setUp(): void
    {
        $this->testedObject = new Attendance();
    }


    public function testGetDescription(): void
    {
        $description = 'present';

        $attendance = $this->testedObject->setDescription($description);

        $this->assertInstanceOf(Attendance::class, $attendance);
        $this->assertEquals($description, $this->testedObject->getDescription());
    }

    public function testGetEnteredAt(): void
    {
        $date = new \DateTime();

        $attendance = $this->testedObject->setEnteredAt($date);

        $this->assertInstanceOf(Attendance::class, $attendance);
        $this->assertEquals($date, $this->testedObject->getEnteredAt());
    }

    public function testGetExitedAt(): void
    {
        $date = new \DateTime();

        $attendance = $this->testedObject->setExitedAt($date);

        $this->assertInstanceOf(Attendance::class, $attendance);
        $this->assertEquals($date, $this->testedObject->getExitedAt());
    }

    public function testGetUser(): void
    {
        $user = new User();

        $attendance = $this->testedObject->setUser($user);

        $this->assertInstanceOf(Attendance::class, $attendance);
        $this->assertEquals($user, $this->testedObject->getUser());
    }
}
