<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class CreateUserController extends AbstractController
{
    public function __invoke(User $data, UserPasswordHasherInterface $passwordEncoder)
    {
        $data->setPassword($passwordEncoder->hashPassword($data, 'password'));
        $data->setExp(0);
        $data->setBlobs(0);
        return $data;
    }
}
