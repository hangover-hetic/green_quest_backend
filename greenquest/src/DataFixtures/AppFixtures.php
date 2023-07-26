<?php

namespace App\DataFixtures;

use App\Entity\Participation;
use App\Entity\User;
use App\Entity\Event;
use App\Entity\Feed;
use App\Entity\Category;
use App\Factory\FeedPostFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct(private readonly UserPasswordHasherInterface $passwordEncoder)
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        $users = [];
        $events = [];
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

        $possible_categories = ['Nettoyage de plage', 'Jardinage', 'Nettoyage de rue', 'Nettoyage de forêt', 'Nettoyage de parc', 'Nettoyage de lac', 'Nettoyage de rivière', 'Nettoyage de montagne', 'Nettoyage de campagne', 'Nettoyage de ville', 'Nettoyage de village', 'Nettoyage de quartier'];
        $categories = [];
        foreach ($possible_categories as $category) {
            $cat = new Category();
            $cat->setTitle($category);
            $manager->persist($cat);
            $categories[] = $cat;
        }

        for ($i = 0; $i < 10; $i++) {
            $event = new Event();
            $event->setTitle("Event $i");
            $event->setDescription("Description");
            $event->setLongitude($this->faker->longitude(2.20, 2.23));
            $event->setLatitude($this->faker->longitude(48.88, 48.90));
            $event->setCoverPath('trash.jpg');
            $event->setDate(new \DateTime());
            $event->setAuthor($users[rand(0, count($users) - 1)]);
            $event->setCategory($this->faker->randomElement($categories));
            $feed = new Feed();
            $manager->persist($feed);


            FeedPostFactory::createMany(rand(3, 10), function () use ($feed, $users) {
                return [
                    'feed' => $feed,
                    'author' => $users[rand(0, count($users) - 1)],
                ];
            });
            $event->setFeed($feed);
            $manager->persist($event);
            $events[] = $event;
        }

        for ($i = 0; $i < 10; $i++) {
            $participation = new Participation();
            $participation->setRoles(['ROLE_USER']);
            $participation->setEvent($events[rand(0, count($events) - 1)]);
            $participation->setUserId($users[rand(0, count($users) - 1)]);
            $manager->persist($participation);
        }


        $manager->flush();
    }
}
