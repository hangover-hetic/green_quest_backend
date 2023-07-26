<?php

namespace App\Controller;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Storage\StorageInterface;

class GetEventsController extends AbstractController
{
    public function __construct(private readonly StorageInterface $storage)
    {
    }

    public function __invoke(EntityManagerInterface $manager): JsonResponse
    {
        $events = $manager->getRepository(Event::class)->findAll();
        $responseData = [];

        foreach ($events as $event) {
            dump($event);
            $responseData[] = [
                'id' => $event->getId(),
                'title' => $event->getTitle(),
                'description' => $event->getDescription(),
                'longitude' => (double)$event->getLongitude(),
                'latitude' => (double)$event->getLatitude(),
                'coverUrl' =>  $this->storage->resolveUri($event, 'coverFile'),
                'feed' => $event->getFeed()->getId(),
                'author' => $event->getAuthor(),
                'date' => $event->getDate(),
                'maxParticipationNumber' => $event->getMaxParticipationNumber(),
                'participantsNumber' => $event->getParticipationsNumber(),
                'category'           => $event->getCategory()
            ];
        }

        return $this->json($responseData, 200, [], ['groups' => ['event:read']]);
    }
}
