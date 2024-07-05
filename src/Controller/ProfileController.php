<?php

// src/Controller/ProfileController.php

namespace App\Controller;

use App\Entity\Profile;
use App\Form\ProfilFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/profile', name: 'app_profile')]
    public function index(ReservationRepository $reservationRepository): Response
    {
        $user = $this->getUser();
        $profile = $user->getProfile();

        $reservation = $reservationRepository->findBy(['idProfile' => $profile->getId()]);

        return $this->render('profile/index.html.twig', [
            'profile' => $profile,
            'reservations' => $reservation
           
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
    public function show(Profile $profile, ReservationRepository $reservationRepository): Response
    {
        $user = $this->getUser();
        $profile = $user->getProfile();

        $reservation = $reservationRepository->findBy(['idProfile' => $profile->getId()]);
        
        $reservation = $reservationRepository->findOneBy ([
            'idProfile' => $profile
        ]);

        return $this->render('profile/index.html.twig', [
            'profile' => $profile,
            'imageName' => $profile->getImageName(), // Ajoutez cette ligne si vous avez une méthode getImageUrl() dans votre entité
            'reservation' => $reservation,
        ]);
    }

    public function edit(Profile $profile): Response
    {
       
        return $this->render('profile/edit.html.twig', [
            'profile' => $profile,
        ]);
    }

}
