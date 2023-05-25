<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MeCrudController extends AbstractController
{




    public function __invoke(): JsonResponse
    {
        $user = $this->getUser();

        // Vérifiez si l'utilisateur est authentifié
        if (!$user) {
            throw new \Exception('Utilisateur non authentifié');
        }

        // Renvoyer les informations de l'utilisateur
        $responseData = [
            'roles' => $user->getRoles(),
        ];

        return new JsonResponse($responseData);
    }
}
