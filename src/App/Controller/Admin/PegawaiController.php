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

class PegawaiController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository
    ) {
    }

    
    #[Route(path: '/admin/pegawai', name: 'app_admin_pegawai')]
    public function index(): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $users = $this->userRepository->findAll();

        return $this->render('admin/pegawai/index.html.twig', ['users' => $users]);
    }

    #[Route(path: '/admin/pegawai/create', name: 'admin_create_user')]
    public function create(Request $request): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(UserFormType::class);

        $form->handleRequest(($request));
        if ($form->isSubmitted() && $form->isValid()) {
            $newUser = $form->getData();

            // dd($newUser);
            // exit;
            $this->userRepository->add($newUser, true);

            return $this->redirectToRoute('app_admin_pegawai');
        }

        return $this->render('admin/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route(path: '/admin/pegawai/edit/{id}', name: 'admin_edit_user')]
    public function edit(Request $request, $id): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = $this->userRepository->find($id);

        $form = $this->createForm(EditUserFormType::class, $user);

        $form->handleRequest(($request));

        if ($form->isSubmitted() && $form->isValid()) {
            // $newUser = $form->getData();

            // $this->userRepository->add($newUser, true);

            // return $this->redirectToRoute('app_admin_pegawai');
            $user->setName($form->get('name')->getData());
            $user->setAddress($form->get('address')->getData());
            $user->setPhoneNumber($form->get('phoneNumber')->getData());
            $user->setDescription($form->get('description')->getData());

            $this->userRepository->add($user, true);

            return $this->redirectToRoute('app_admin_pegawai');

        }

        return $this->render('admin/pegawai/edit.html.twig', ['user' => $user, 'form' => $form->createView()]);
    }

    #[Route(path: '/admin/pegawai/delete/{id}', name: 'admin_delete_user')]
    public function delete($id): Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = $this->userRepository->find($id);

        $this->userRepository->remove($user, true);
        return $this->redirectToRoute('app_admin_pegawai');

        

    }
}
