<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Feed;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CreateEventController extends AbstractController
{
    public function __invoke(Event $data, EntityManagerInterface $manager): Event
    {
        $data->setMaxParticipationNumber((int) $data->getMaxParticipationNumber());
        $feed = new Feed();
        $manager->persist($feed);
        $data->setFeed($feed);
        $data->setAuthor($this->getUser());
        return $data;
    }
}
