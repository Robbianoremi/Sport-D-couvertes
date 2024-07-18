<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AnimationController extends AbstractController
{
    #[Route('/animations', name: 'app_animations')]
    public function index(): Response
    {
        return $this->render('animations/index.html.twig', [
            'controller_name' => 'AnimationController',
        ]);
    }
}
