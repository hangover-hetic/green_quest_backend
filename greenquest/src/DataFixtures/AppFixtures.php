<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for( $i = 0; $i < 10; $i++ ){
            $event = new Event();
            $event->setTitle( "Title", $i ); 
            $event->setDescription( "Description", $i );
            $event->setPosition( [12, 20, 50] );
            $manager->persist($event);
        }

        $manager->flush();
    }
}
