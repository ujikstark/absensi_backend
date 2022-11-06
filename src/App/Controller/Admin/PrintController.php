<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\DateFormType;
use App\Form\EditUserFormType;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
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
        
        $currentDate = new \DateTime;

        if ($form->isSubmitted() && $form->isValid()) {
            $newDate = $form->getData();

            /** @var DateTime date */
            $currentDate = $newDate['date'];

            $attendances = $this->userRepository->findByDate($currentDate);


            if ($form->get('print')->isClicked()) {
                $pdfOptions = new Options();
                $pdfOptions->set('defaultFont', 'Arial');

                // Instantiate Dompdf with our options
                $dompdf = new Dompdf($pdfOptions);

                // Retrieve the HTML generated in our twig file
                $html = $this->renderView('admin/print/show.html.twig', ['attendances' => $attendances, 'form' => $form->createView(), 'date' => $currentDate]);

                // Load HTML to Dompdf
                $dompdf->loadHtml($html);

                // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
                $dompdf->setPaper('A4', 'portrait');

                // Render the HTML as PDF
                $dompdf->render();

                // Output the generated PDF to Browser (inline view)
                $dompdf->stream("Absen ". date_format($currentDate, "d M Y"), [
                    "Attachment" => false
                ]);
                // return $this->render('admin/print/test.html.twig');
            }
            // dd($newDate);

            // dd($attendances);

        } else {

            $attendances = $this->userRepository->findByDate($currentDate);
        }



        return $this->render('admin/print/index.html.twig', ['attendances' => $attendances, 'form' => $form->createView(), 'date' => $currentDate]);
    }


}
