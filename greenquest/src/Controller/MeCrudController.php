<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MeCrudController extends AbstractController
{

    #[Route('/me', name: 'me', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        $user = $this->getUser();

        // Vérifiez si l'utilisateur est authentifié
        if (!$user) {
            throw new \Exception('Utilisateur non authentifié');
        }

        // Renvoyer les informations de l'utilisateur
        $responseData = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
            'exp' => $user->getExp(),
            'blobs' => $user->getBlobs(),
            'roles' => $user->getRoles(),
        ];

        return $this->json($responseData);
    }
}
