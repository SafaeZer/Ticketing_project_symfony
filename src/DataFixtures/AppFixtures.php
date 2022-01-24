<?php

namespace App\DataFixtures;

use App\Entity\Ticket;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // create 10 tickets! Bam!
        for ($i = 0; $i < 10; $i++) {
            $ticket = new Ticket();
            $ticket->setTitre('ticket ' . $i);
            $ticket->setDescription();
            $ticket->setDescription();
            $ticket->setPriority();
            $ticket->setDescription();
            $manager->persist($ticket);
        }

        $manager->flush();
    }
}
