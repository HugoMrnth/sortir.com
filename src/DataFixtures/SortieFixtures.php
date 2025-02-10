<?php

namespace App\DataFixtures;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SortieFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create("fr_FR");

        $etatRepository = $manager->getRepository(Etat::class);
        $allEtats = $etatRepository->findAll();

        $lieuRepository = $manager->getRepository(Lieu::class);
        $allLieux = $lieuRepository->findAll();

        $participantRepository = $manager->getRepository(Participant::class);
        $allParticipants = $participantRepository->findAll();

        for ($i = 0; $i < 30; $i++) {
            $dateDebut = $faker->dateTimeBetween("-2 months", "+2 months");
            $dateCloture = $faker->dateTimeInInterval($dateDebut,"-2 days");
            $randomParticipants = $faker->randomElements($allParticipants, $faker->numberBetween(0, min(15, count($allParticipants))));

            $sortie = new Sortie();
            $sortie->setNom($faker->realTextBetween(1, 30, 3))
                ->setDateDebut(\DateTimeImmutable::createFromMutable($dateDebut))
                ->setDateCloture(\DateTimeImmutable::createFromMutable($dateCloture))
                ->setJauge($faker->numberBetween($min = 1, $max = 15))
                ->setDuree($faker->numberBetween($min = 30, $max = 240))
                ->setDescription($faker->optional(0.8)->text(500))
                ->setEtat($faker->randomElement($allEtats))
                ->setLieu($faker->randomElement($allLieux))
                ->setOrganisateur($faker->randomElement($allParticipants));

            foreach ($randomParticipants as $participant) {
                $sortie->addParticipant($participant);
            }

            $manager->persist($sortie);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [EtatFixtures::class, LieuFixtures::class, ParticipantFixtures::class];
    }

}