<?php

namespace App\DataFixtures;

use App\Entity\Participant;
use App\Entity\Site;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ParticipantFixtures extends Fixture implements DependentFixtureInterface
{

    public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasher)
    { }
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create("fr_FR");

        $siteRepository = $manager->getRepository(Site::class);
        $allSites = $siteRepository->findAll();

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
                ->setActif(true)
                ->setSite($faker->randomElement($allSites));

            $manager->persist($participant);

            $this->addReference("participant$i", $participant);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [SiteFixtures::class];
    }
}
