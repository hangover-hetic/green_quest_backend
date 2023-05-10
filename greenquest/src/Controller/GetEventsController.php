<?php

namespace App\Controller;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetEventsController extends AbstractController
{
    public function __invoke(EntityManagerInterface $manager): JsonResponse
    {
        $events = $manager->getRepository(Event::class)->findAll();
        $responseData = [];

        foreach ($events as $event) {
            $participantIds = $event->getParticipations()->map(function ($participant) {
                return $participant->getUserId()->getId();
            });

            $responseData[] = [
                'id' => $event->getId(),
                'title' => $event->getTitle(),
                'description' => $event->getDescription(),
                'longitude' => $event->getLongitude(),
                'latitude' => $event->getLatitude(),
                'feed' => $event->getFeed()->getId(),
                'participantIds' => $participantIds,
            ];
        }

        return $this->json($responseData);
    }
}
