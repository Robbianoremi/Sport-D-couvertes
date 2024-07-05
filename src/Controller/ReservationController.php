<?php

namespace App\Controller;

use DateTime;
use DateTimeImmutable;
use App\Entity\Reservation;
use App\Form\ReservationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $reservations = $entityManager->getRepository(Reservation::class)->findAll();

        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    #[Route('/reservation/new', name: 'app_reservation_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $reservation = new Reservation();

        $form = $this->createForm(ReservationFormType::class, $reservation);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifier si l'utilisateur est connecté et a un profil
            $user = $this->getUser();
            if ($user === null) {
                $this->addFlash('danger', 'Vous devez être connecté pour faire une réservation.');
                return $this->redirectToRoute('app_login'); // Rediriger vers la page de connexion
            }

            $profile = $user->getProfile();
            if ($profile === null) {
                $this->addFlash('danger', 'Vous n\'avez pas de profil associé.');
                return $this->redirectToRoute('app_profile_new'); // Rediriger vers la page de création de profil
            }

            $reservation->setIdProfile($profile);
            $reservation->setCreatedAt(new DateTimeImmutable());

            // Vérifier s'il existe une réservation pour cette date
            $date = $reservation->getCreatedAt();
            $existingReservation = $entityManager->getRepository(Reservation::class)->findOneBy(['createdAt' => $date]);
            if ($existingReservation) {
                $this->addFlash('danger', 'Il y a déjà une réservation pour cette date.');
                return $this->redirectToRoute('app_reservation_new');
            }

            // Si tout va bien, procéder à la sauvegarde de la réservation
            $entityManager->persist($reservation);
            $entityManager->flush();

            // Envoyer l'email de confirmation
            $email = (new Email())
                ->from('votre@adresse.email')
                ->to($user->getEmail())
                ->subject('Confirmation de réservation')
                ->text('Votre réservation a bien été prise en compte.');

            $mailer->send($email);

            // Ajouter un message de confirmation
            $this->addFlash('success', 'Réservation effectuée avec succès. Un email de confirmation vous a été envoyé.');

            return $this->redirectToRoute('app_profile');
        }

        return $this->render('reservation/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/reservation/delete/{id}', name: 'app_reservation_delete')]
    public function delete(Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($reservation);
        $entityManager->flush();

        $this->addFlash('success', 'La réservation a été supprimée avec succès.');

        return $this->redirectToRoute('app_profile');
    }

    #[Route('/reservation/update/{id}', name: 'app_reservation_update')]
    public function update(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationFormType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Si le formulaire est soumis et valide, enregistrez les modifications
            $entityManager->flush();

            $this->addFlash('success', 'La réservation a été mise à jour avec succès.');

            return $this->redirectToRoute('app_profile');
        }

        // Si le formulaire n'est pas encore soumis ou s'il y a des erreurs de validation, affichez le formulaire de modification
        return $this->render('reservation/update.html.twig', [
            'form' => $form->createView(),
            'reservation' => $reservation,
        ]);
    }
}
