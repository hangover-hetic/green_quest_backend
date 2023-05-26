<?php

namespace App\Controller;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Storage\StorageInterface;

class GetEventController extends AbstractController
{
    public function __construct(private readonly StorageInterface $storage)
    {
    }
    public function __invoke(Event $event, EntityManagerInterface $manager): JsonResponse
    {
        $participantIds = $event->getParticipations()->map(function ($participant) {
            return $participant;
        });

        $responseData = [
            'id' => $event->getId(),
            'title' => $event->getTitle(),
            'description' => $event->getDescription(),
            'longitude' => $event->getLongitude(),
            'latitude' => $event->getLatitude(),
            'feed' => $event->getFeed()->getId(),
            'coverUrl' =>  $this->storage->resolveUri($event, 'coverFile'),
            'participantIds' => $participantIds,
        ];

        return $this->json($responseData);
    }
}
