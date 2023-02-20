<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\RegistrationType;
use App\Service\Customer\CustomerRegistrator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/', name: 'app_registration', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function registration(Request $request, CustomerRegistrator $registrator): Response
    {
        $form = $this->createForm(RegistrationType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $customerData = $form->getData();

            $registrator->register($customerData);

            return $this->redirectToRoute('app_registered_congratulation');
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/congratulation', name: 'app_registered_congratulation')]
    public function congratulationsForRegistered(): Response
    {
        return $this->render('registration/congratulations.html.twig');
    }
}
