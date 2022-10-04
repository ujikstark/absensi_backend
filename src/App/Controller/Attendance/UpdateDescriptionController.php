<?php

declare(strict_types=1);

namespace App\Controller\Attendance;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Attendance;
use App\Repository\AttendanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\User;
use Model\Attendance\UpdateDescriptionDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateDescriptionController extends AbstractController
{

    public const PATH = '/attendances/{id}/update-description';

    public function __construct(
        private ValidatorInterface $validator,
        private AttendanceRepository $attendanceRepository
    ) {
    }

    public function __invoke(Request $request, UpdateDescriptionDTO $data): JsonResponse
    {
        
        $this->validator->validate($data);

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
        
        $attendance->setDescription($data->getDescription());
        
        $this->attendanceRepository->add($attendance, true);
    
        return $this->json($attendance, Response::HTTP_OK);
    

    }
}
