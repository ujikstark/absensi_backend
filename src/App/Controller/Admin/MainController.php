<?php

// src/Controller/LuckyController.php
namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\EditUserFormType;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository
    ) {
    }

    
    #[Route(path: '/admin', name: 'app_admin_analisis')]
    public function index(): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $lastAttendances = $this->userRepository->findByLastAttendance();

        $date = new \DateTime();

        $attendancesToday =  array_filter($lastAttendances, function($value) use ($date) {
            $currentDate = date_create($value['entered_at']);

            return date_format($currentDate, 'Y-m-d') == $date->format('Y-m-d'); 
            // return true;
        });

        usort($lastAttendances, function($first, $second) {
            return $first['entered_at'] < $second['entered_at'];
        });
        

        return $this->render('admin/analisis/index.html.twig', ['lastAttendances' => $lastAttendances, 'attendancesToday' => $attendancesToday, 'date'=> $date]);
    }

    #[Route('/admin/logout', name: 'app_admin_logout', methods: ['GET'])]
    public function logout()
    {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

    
}
