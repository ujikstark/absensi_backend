<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\DateFormType;
use App\Form\EditUserFormType;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrintController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository
    ) {
    }

    #[Route(path: '/admin/cetak', name: 'app_admin_cetak')]
    public function index(Request $request): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(DateFormType::class);
        $form->handleRequest(($request));

        if ($form->isSubmitted() && $form->isValid()) {
            $newDate = $form->getData();
            // dd($newDate);
            $attendances = $this->userRepository->findByDate($newDate['date']);

        } else {

            $attendances = $this->userRepository->findByDate(new \DateTime());
        }



        return $this->render('admin/print/index.html.twig', ['attendances' => $attendances, 'form' => $form->createView()]);
    }

    
}
