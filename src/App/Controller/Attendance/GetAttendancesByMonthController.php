<?php

declare(strict_types=1);

namespace App\Controller\Attendance;

use App\Entity\Attendance;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetAttendancesByMonthController extends AbstractController
{

    public const PATH = '/attendances/month/{number}';


    public function __invoke(Request $request): JsonResponse
    {
    

        /** @var User $user */
        $user = $this->getUser();

        $attendances = $user->getAttendancesByMonth((int)$request->get('number'));
        
        if ($attendances) {
            return $this->json($attendances, Response::HTTP_OK);
        } else {
            $error = array();
            $error['message'] = 'Attendances not found';
            return $this->json($error, Response::HTTP_BAD_REQUEST);
        }
        
    
    

    }
}
