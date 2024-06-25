<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\PanierDiscipline;
use App\Entity\Discipline;
use App\Repository\DisciplineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    #[Route('/disciplines', name: 'discipline_list')]
    public function list(DisciplineRepository $disciplineRepository): Response
    {
        $disciplines = $disciplineRepository->findAll();
        $stripePublicKey = $this->getParameter('stripe_public_key');

        return $this->render('panier/discipline_list.html.twig', [
            'disciplines' => $disciplines,
            'stripe_public_key' => $stripePublicKey
        ]);
    }

    #[Route('/basket/create', name: 'create_basket', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $profile = $user->getProfile();
   
        $data = $request->request->all();
        $disciplineIds = $data['disciplines'] ?? [];

        if (empty($disciplineIds)) {
            return new Response(json_encode(['error' => 'No disciplines selected.']), 400, ['Content-Type' => 'application/json']);
        }

        $disciplines = $entityManager->getRepository(Discipline::class)->findBy(['id' => $disciplineIds]);

        if (empty($disciplines)) {
            return new Response(json_encode(['error' => 'No valid disciplines found.']), 400, ['Content-Type' => 'application/json']);
        }

        $panier = new Panier();
        $panier->setCreatedAt(new \DateTimeImmutable());
        $panier->setIdProfile($profile);
        
        foreach ($disciplines as $discipline) {
            $quantity = $data["quantity-{$discipline->getId()}"] ?? 1;
            $panierDiscipline = new PanierDiscipline();
            $panierDiscipline->setDiscipline($discipline);
            $panierDiscipline->setQuantity((int)$quantity);
            $panierDiscipline->setPanier($panier);
            $entityManager->persist($panierDiscipline);
        }

        $entityManager->persist($panier);
        try {
            $entityManager->flush();
        } catch (\Exception $e) {
            return new Response(json_encode(['error' => 'Failed to save basket.', 'details' => $e->getMessage()]), 500, ['Content-Type' => 'application/json']);
        }

        return new Response(json_encode(['id' => $panier->getId()]), 200, ['Content-Type' => 'application/json']);
    }
}
