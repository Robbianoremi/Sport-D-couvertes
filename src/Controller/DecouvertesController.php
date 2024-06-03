<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DecouvertesController extends AbstractController
{
    #[Route('/decouvertes', name: 'app_decouvertes')]
    public function index(): Response
    {
        return $this->render('decouvertes/index.html.twig', [
            'controller_name' => 'DecouvertesController',
        ]);
    }
}
