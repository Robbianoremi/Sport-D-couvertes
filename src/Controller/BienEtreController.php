<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BienEtreController extends AbstractController
{
    #[Route('/bien/etre', name: 'app_bien_etre')]
    public function index(): Response
    {
        return $this->render('bien_etre/index.html.twig', [
            'controller_name' => 'BienEtreController',
        ]);
    }
}
