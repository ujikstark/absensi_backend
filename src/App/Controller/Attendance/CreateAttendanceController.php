<?php

declare(strict_types=1);

namespace App\Controller\Attendance;

use App\Entity\Attendance;
use App\Entity\User;
use App\Repository\AttendanceRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateAttendanceController extends AbstractController
{

    public const PATH = '/attendances/enter';


    public function __construct(
        private AttendanceRepository $attendanceRepository
    ) {
    }

    public function __invoke(): JsonResponse
    {

        /** @var User $user */
        $user = $this->getUser();

        $attendance = new Attendance();
        $attendance->setUser($user);
        $attendance->setEnteredAt(new DateTime());
        $this->attendanceRepository->add($attendance, true);
    
        return $this->json($attendance, Response::HTTP_CREATED);

    }
}
