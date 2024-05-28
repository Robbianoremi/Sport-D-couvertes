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
use Symfony\Component\DependencyInjection\Loader\Configurator\mailer;

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
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();

        // Pré-remplir la date et l'heure si elles sont passées en paramètre
        $date = $request->query->get('date');
        if ($date) {
            try {
                $reservation->setBookAt(new DateTimeImmutable($date)); 
            } catch (\Exception $e) {
                // Gérer l'exception si le format de la date n'est pas valide
                $this->addFlash('danger', 'Format de date invalide.');
                return $this->redirectToRoute('app_reservation_new');
            }
        }

        $form = $this->createForm(ReservationFormType::class, $reservation);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifier si une réservation existe déjà pour cette heure
            $date = $reservation->getBookAt();
            
            // Vérifier si l'utilisateur est connecté et a un profil
            $user = $this->getUser();
            if ($user === null) {
                $this->addFlash('danger', 'Vous devez être connecté pour faire une réservation.');
                return $this->redirectToRoute('app_profile'); // Rediriger vers la page de connexion ou une autre page appropriée
            }
        
            $profile = $user->getProfile();
            if ($profile === null) {
                $this->addFlash('danger', 'Vous n\'avez pas de profil associé.');
                return $this->redirectToRoute('app_profile_new'); // Rediriger vers la page de création de profil ou une autre page appropriée
            }
        
            $reservation->setIdProfile($profile);
        
            // Vérifier s'il existe une réservation pour cette heure
            $existingReservation = $entityManager->getRepository(Reservation::class)->findOneBy(['date' => $date]);
            if ($existingReservation) {
                $this->addFlash('danger', 'Il y a déjà une réservation pour cette date.');
                return $this->redirectToRoute('app_reservation_new');
            }
        
            // Si tout va bien, procéder à la sauvegarde de la réservation
            $entityManager->persist($reservation);
            $entityManager->flush();
        
            // Envoyer l'email de confirmation
           // Remplacez 'votre@adresse.email' par l'adresse email de destination
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
        
        


        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifier si une réservation existe déjà pour cette heure
            $date = $reservation->getBookAt();
            $reservation->setIdProfile($this->getUser()->getProfile());
           
            $existingReservation = $entityManager->getRepository(Reservation::class)->findOneBy(['date' => $date]);
            if ($existingReservation) {
                $this->addFlash('danger', 'Il y a déjà une réservation pour cette heure.');
                return $this->redirectToRoute('app_reservation_new');
            }

            // Vérifier si la date du jour n'est pas dépassée
            $now = new DateTime();
            if ($date < $now) {
                $this->addFlash('danger', 'Veuillez choisir un créneau pour demain.');
                return $this->redirectToRoute('app_reservation_new');
            }

            // Autoriser seulement les réservations à partir du lendemain
            $tomorrow = (clone $now)->modify('+1 day');
            if ($date < $tomorrow) {
                $this->addFlash('danger', 'Vous pouvez réserver à partir de demain.');
                return $this->redirectToRoute('app_reservation_new');
            }

           
           

            // Si tout est valide, enregistrer la réservation
            $entityManager->persist($reservation);
            $entityManager->flush();

            $this->addFlash('success', 'La réservation a été correctement ajoutée.');

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
