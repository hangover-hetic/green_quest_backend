<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(private readonly UserPasswordHasherInterface $passwordEncoder)
    {

    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail('user' . $i . '@example.com');
            $user->setFirstname('User' . $i);
            $user->setLastname('User' . $i);
            $user->setPassword($this->passwordEncoder->hashPassword($user, 'password'));
            $user->setExp(0);
            $user->setBlobs(0);
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
