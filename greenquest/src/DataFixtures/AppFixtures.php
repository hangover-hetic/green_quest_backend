<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Event;
use App\Entity\Feed;
use App\Factory\FeedPostFactory;
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
        $users = [];
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
            $users[] = $user;
        }

        for( $i = 0; $i < 10; $i++ ){
            $event = new Event();
            $event->setTitle( "Title", $i );
            $event->setDescription( "Description", $i );
            $event->setLongitude( 20 );
            $event->setLatitude( 10 );
            $feed = new Feed();
            $manager->persist($feed);

            FeedPostFactory::createMany(rand(3, 10), function() use ($feed, $users) {
                return [
                    'feed' => $feed,
                    'author' => $users[rand(0, count($users) - 1)],
                ];
            });
            $event->setFeed($feed);
            $manager->persist($event);
        }

        $manager->flush();
    }
}
