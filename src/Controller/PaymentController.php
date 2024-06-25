<?php

namespace App\Controller;

use Stripe\Stripe;
use Stripe\Webhook;
use App\Entity\Invoice;
use Psr\Log\LoggerInterface;
use Stripe\Checkout\Session;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaymentController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    #[Route('/create-checkout-session/{panierId}', name: 'create_checkout_session')]
    public function createCheckoutSession(int $panierId, PanierRepository $panierRepository, EntityManagerInterface $em): Response
    {
        $panier = $panierRepository->find($panierId);

        if (!$panier) {
            return new JsonResponse(['error' => 'Basket not found.'], Response::HTTP_NOT_FOUND);
        }

        Stripe::setApiKey($this->getParameter('stripe_secret_key'));

        $lineItems = [];
        foreach ($panier->getPanierDisciplines() as $panierDiscipline) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $panierDiscipline->getDiscipline()->getNom(),
                    ],
                    'unit_amount' => $panierDiscipline->getDiscipline()->getPrix() * 100, // Stripe expects the amount in cents
                ],
                'quantity' => $panierDiscipline->getQuantity(),
            ];
        }

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => $this->generateUrl('payment_success', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('payment_cancel', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        $panier->setStripeSessionId($session->id);
        $em->persist($panier);
        $em->flush();

        $this->logger->info('Checkout session created', ['sessionId' => $session->id, 'panierId' => $panierId]);

        return new JsonResponse(['id' => $session->id, 'url' => $session->url]);
    }

    #[Route('/payment-success', name: 'payment_success')]
    public function paymentSuccess(): Response
    {
        return $this->render('payment/success.html.twig');
    }

    #[Route('/payment-cancel', name: 'payment_cancel')]
    public function paymentCancel(): Response
    {
        return $this->render('payment/cancel.html.twig');
    }

    #[Route('/webhook', name: 'stripe_webhook')]
    public function stripeWebhook(Request $request, PanierRepository $panierRepository, EntityManagerInterface $em): Response
    {
        $payload = @file_get_contents('php://input');
        $sig_header = $request->headers->get('stripe-signature');
        $endpoint_secret = $this->getParameter('stripe_webhook_secret');

        $this->logger->info('Webhook received', ['payload' => $payload, 'signature' => $sig_header]);

        try {
            $event = Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
            $this->logger->info('Webhook event constructed', ['event' => $event]);
        } catch (\UnexpectedValueException $e) {
            $this->logger->error('Invalid payload', ['exception' => $e]);
            return new Response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            $this->logger->error('Invalid signature', ['exception' => $e]);
            return new Response('Invalid signature', 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            $this->logger->info('Checkout session completed', ['sessionId' => $session->id]);

            // Retrieve the basket from your database
            $panier = $panierRepository->findOneBy(['stripeSessionId' => $session->id]);

            if ($panier) {
                $panier->setIsPaid(true);

                // Create and persist the invoice
                $invoice = new Invoice();
                $invoice->setCreatedAt(new \DateTimeImmutable());
                $invoice->setPanier($panier);
                $invoice->setAmount($panier->getTotalAmount()); // Assuming you have a method to get the total amount

                $em->persist($invoice);
                $em->persist($panier);
                $em->flush();

                $this->logger->info('Basket and invoice updated', ['panierId' => $panier->getId(), 'invoiceId' => $invoice->getId()]);
            } else {
                $this->logger->error('Basket not found', ['stripeSessionId' => $session->id]);
                return new Response('Basket not found', 404);
            }
        }

        return new Response('Success', 200);
    }

}
