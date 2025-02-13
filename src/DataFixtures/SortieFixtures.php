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

        $lieuRepository = $manager->getRepository(Lieu::class);
        $allLieux = $lieuRepository->findAll();

        $participantRepository = $manager->getRepository(Participant::class);
        $allParticipants = $participantRepository->findAll();

        for ($i = 0; $i < 30; $i++) {
            $dateDebut = $faker->dateTimeBetween("-2 months", "+2 months");
            $dateCloture = $faker->dateTimeInInterval($dateDebut, "-2 days");
            $jauge = $faker->numberBetween($min = 1, $max = 15);
            $duree = $faker->numberBetween($min = 30, $max = 240);
            $organisateur = $faker->randomElement($allParticipants);

            $sortie = new Sortie();
            $sortie->setNom($faker->realTextBetween(1, 25, 3))
                ->setDateDebut(\DateTimeImmutable::createFromMutable($dateDebut))
                ->setDateCloture(\DateTimeImmutable::createFromMutable($dateCloture))
                ->setJauge($jauge)
                ->setDuree($duree)
                ->setDescription($faker->optional(0.8)->text(500))
                ->setLieu($faker->randomElement($allLieux))
                ->setOrganisateur($organisateur)
                ->setSite($organisateur->getSite());

            $dateFin = (clone $dateDebut)->add(new \DateInterval("PT0H" . $duree . "M"));
            $dateHistorisation = (clone $dateDebut)->add(new \DateInterval("P1M"));
            $now = new \DateTimeImmutable('now');

            if($now < $dateCloture){
                $rand = mt_rand(1, 100);

                if ($rand <= 70) {
                    $sortie->setEtat($this->getReference("etat-Ouverte", Etat::class));
                } elseif ($rand <= 90) {
                    $sortie->setEtat($this->getReference("etat-En création", Etat::class));
                } else {
                    $sortie->setEtat($this->getReference("etat-Annulée", Etat::class));
                }
            }elseif($now < $dateDebut){
                    $sortie->setEtat($this->getReference("etat-Clôturée", Etat::class));
            }elseif ($now < $dateFin){
                $sortie->setEtat($this->getReference("etat-En cours", Etat::class));
            }elseif ($now < $dateHistorisation){
                $sortie->setEtat($this->getReference("etat-Terminée", Etat::class));
            }else {
                $sortie->setEtat($this->getReference("etat-Historisée", Etat::class));
            }

            if ($sortie->getEtat()->getLibelle() !== "En création") {
                $randomParticipants = $faker->randomElements($allParticipants, $faker->numberBetween(0, min($jauge, count($allParticipants))));
                foreach ($randomParticipants as $participant) {
                    if($participant !== $organisateur){
                        $sortie->addParticipant($participant);
                    }
                }
            }

            if ($sortie->getEtat()->getLibelle() === "Ouverte" && $sortie->getJauge() === $sortie->getParticipants()->count()){
                $sortie->setEtat($this->getReference("etat-Clôturée", Etat::class));
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