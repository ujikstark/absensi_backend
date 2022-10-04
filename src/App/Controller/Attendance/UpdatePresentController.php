<?php

declare(strict_types=1);

namespace App\Controller\Attendance;

use App\Entity\Attendance;
use App\Repository\AttendanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdatePresentController extends AbstractController
{

    public const PATH = '/attendances/{id}/exit-done';

    public function __construct(
        private AttendanceRepository $attendanceRepository
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {

        $attendance = $this->attendanceRepository->find($request->get('id'));

        if (!$attendance) {
            $error = array();
            $error['message'] = 'Attendance not found';
            return $this->json($error, Response::HTTP_BAD_REQUEST);
        }

        /** @var User $user */
        $user = $this->getUser();

        if ($user != $attendance->getUser()) {
            $error = array();
            $error['message'] = 'This is not your resource';
            return $this->json($error, Response::HTTP_UNAUTHORIZED);
        }

        
        $attendance->setExitedAt(new \DateTime());
        $attendance->setDescription('hadir');
        
        $this->attendanceRepository->add($attendance, true);
    
        return $this->json($attendance, Response::HTTP_OK);
    

    }
}
