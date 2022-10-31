<?php

// src/Controller/LuckyController.php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository
    ) {
    }

    #[Route(path: '/admin', name: 'app_admin')]
    public function index(): Response {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $users = $this->userRepository->findAll();

        return $this->render('admin/index.html.twig', ['users' => $users]);
    }

    #[Route(path: '/admin/create', name: 'app_admin_tambah')]
    public function create(Request $request): Response {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = new User();
        $form = $this->createForm(UserFormType::class);

        $form->handleRequest(($request));
        if ($form->isSubmitted() && $form->isValid()) {
            $newUser = $form->getData();

            // dd($newUser);
            // exit;
            $this->userRepository->add($newUser, true);

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/create.html.twig', ['form' => $form->createView()]);
    }

   
}