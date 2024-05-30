<?php

namespace App\Controller;

use App\Entity\Subscription;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubscriptionController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/subscription', name: 'app_subscription')]
    public function index(): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        // Vérifier si l'utilisateur est connecté
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        // Récupérer toutes les souscriptions
        $subscriptions = $this->entityManager->getRepository(Subscription::class)->findAll();

        return $this->render('subscription/index.html.twig', [
            'subscriptions' => $subscriptions,
            'user' => $user,
        ]);
    }

    #[Route('/change-subscription/{id}', name: 'app_change_subscription', methods: ['POST'])]
    public function changeSubscription(int $id, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        $subscription = $entityManager->getRepository(Subscription::class)->find($id);

        if (!$subscription) {
            throw $this->createNotFoundException('Abonnement non trouvé.');
        }

        $user->setSubscription($subscription);
        $entityManager->flush();

        return $this->redirectToRoute('app_subscription');
    }
}
