<?php

// src/Controller/ProfileController.php

namespace App\Controller;

use App\Entity\Profile;
use App\Form\ProfilFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class ProfileController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }

    #[Route('/profile/edit', name: 'app_edit_profile')]
    public function editProfile(Request $request): Response
    {
        $user = $this->getUser();
        $profile = $user->getProfile() ?? new Profile();
        
        $form = $this->createForm(ProfilFormType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Associer le profil à l'utilisateur et définir d'autres propriétés si nécessaire
            $profile->setIdUser($user);
            $profile->setCreatedAt(new \DateTimeImmutable());

            $this->entityManager->persist($profile);
            $this->entityManager->flush();
            
            $this->addFlash('success', 'Profil mis à jour avec succès !');
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('profile/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}
