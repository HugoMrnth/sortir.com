<?php

namespace App\DataFixtures;

use App\Entity\Participant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ParticipantFixtures extends Fixture
{

    public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasher)
    { }
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create("fr_FR");

        for ($i = 0; $i < 15; $i++) {
            $participant = new Participant();
            $participant
                ->setUsername($faker->userName)
                ->setEmail($faker->email)
                ->setRoles(['ROLE_USER'])
                ->setPassword($this->userPasswordHasher->hashPassword($participant, $faker->password))
                ->setNom($faker->lastName())
                ->setPrenom($faker->firstName())
                ->setTelephone($faker->phoneNumber())
                ->setActif(true);
            $manager->persist($participant);

            $this->addReference("participant$i", $participant);
        }

        $manager->flush();
    }
}
