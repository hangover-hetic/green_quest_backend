<?php

namespace App\Controller;

use App\Entity\Participation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class CreateParticipationController extends AbstractController
{
    public function __invoke(Participation $participation)
    {
        $event = $participation->getEvent();
        if($event->getParticipations()->count() >= $event->getMaxParticipationNumber()) {
            throw new UnauthorizedHttpException("Event full", "You can't participate to this event because it's full");
        }
        return $participation;
    }
}
