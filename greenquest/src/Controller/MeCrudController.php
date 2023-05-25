<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MeCrudController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    public function __invoke(): JsonResponse
    {
        $user = $this->security->getUser();

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
