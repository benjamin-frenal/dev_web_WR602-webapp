<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Subscription;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $subscription1 = new Subscription();
        $subscription1->setTitle('ESSENTIAL');
        $subscription1->setDescription('Abonnement ESSENTIAL');
        $subscription1->setPdfLimit(3);
        $subscription1->setPrice(0);
        $subscription1->setMedia('assets/essential.png');

        $manager->persist($subscription1);

        $subscription2 = new Subscription();
        $subscription2->setTitle('ADVANCED');
        $subscription2->setDescription('Abonnement ADVANCED');
        $subscription2->setPdfLimit(10);
        $subscription2->setPrice(5);
        $subscription2->setMedia('assets/advanced.png');

        $manager->persist($subscription2);

        $subscription3 = new Subscription();
        $subscription3->setTitle('EXPERT');
        $subscription3->setDescription('Abonnement EXPERT');
        $subscription3->setPdfLimit(50);
        $subscription3->setPrice(10);
        $subscription3->setMedia('assets/expert.png');

        $manager->persist($subscription3);


        $manager->flush();
    }
}