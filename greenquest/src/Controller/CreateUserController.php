<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateUserController extends AbstractController
{
    public function __invoke(User $data, UserPasswordHasherInterface $passwordEncoder)
    {
        $data->setPassword($passwordEncoder->hashPassword($data, $data->getPassword()));
        $data->setExp(0);
        $data->setBlobs(0);
        return $data;
    }
}
