<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Subscription;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Création des abonnements
        $subscription1 = new Subscription();
        $subscription1->setTitle('Basique');
        $subscription1->setDescription('<li>10 PDFs par mois</li><li>Accès à l\'historique des conversions</li><li>Assistance par email</li>');
        $subscription1->setPdfLimit(10);
        $subscription1->setPriceMonth(0);
        $subscription1->setPriceYear(0);

        $manager->persist($subscription1);

        $subscription2 = new Subscription();
        $subscription2->setTitle('Avancé');
        $subscription2->setDescription('<li>30 PDFs par mois</li><li>Accès à l\'historique des conversions</li><li>Assistance par email et chat</li><li>Accès complet aux fonctionnalités avancées</li>');
        $subscription2->setPdfLimit(30);
        $subscription2->setPriceMonth(9.99);
        $subscription2->setPriceYear(89.99);

        $manager->persist($subscription2);

        $subscription3 = new Subscription();
        $subscription3->setTitle('Pro');
        $subscription3->setDescription('<li>100 PDFs par mois</li><li>Accès à l\'historique des conversions</li><li>Assistance prioritaire par email, chat et téléphone</li><li>Accès complet aux fonctionnalités avancées</li><li>Intégration avec des outils tiers</li>');
        $subscription3->setPdfLimit(100);
        $subscription3->setPriceMonth(14.99);
        $subscription3->setPriceYear(134.99);

        $manager->persist($subscription3);

        $user = new User();
        $user->setEmail('ben.frenal@icloud.com');
        $user->setPassword($this->passwordHasher->hashPassword($user, '123456'));
        $user->setFirstname('Benjamin');
        $user->setLastname('Frenal');
        $user->setRoles(['ROLE_USER']);
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setUpdatedAt(new \DateTimeImmutable());
        $user->setSubscription($subscription1);
        $subscriptionEndDate = new \DateTimeImmutable();
        $subscriptionEndDate = $subscriptionEndDate->modify('+1 month');
        $user->setSubscriptionEndAt($subscriptionEndDate);

        $manager->persist($user);

        $manager->flush();
    }
}