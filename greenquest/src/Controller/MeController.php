<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MeController extends AbstractController
{
    public function __invoke(): ?\Symfony\Component\Security\Core\User\UserInterface
    {
        return $this->getUser();
    }
}
