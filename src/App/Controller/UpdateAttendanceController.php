<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Attendance;
use App\Repository\AttendanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;


class UpdateAttendanceController extends AbstractController
{

    public function __construct(
        private AttendanceRepository $attendanceRepository
    ) {
    }

    public function __invoke(Attendance $data): JsonResponse
    {

        $data->setExitedAt(new \DateTimeImmutable());
        
        $this->attendanceRepository->add($data, true);

        return $this->json($data);


    }
}
