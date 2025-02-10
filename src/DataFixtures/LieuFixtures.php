<?php

namespace App\DataFixtures;

use App\Entity\Lieu;
use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LieuFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create("fr_FR");

        $villeRepository = $manager->getRepository(Ville::class);
        $allVilles = $villeRepository->findAll();

        for ($i = 0; $i < 15; $i++) {
            if ($faker->boolean(60)) {
                $latitude = $faker->latitude(-90, 90);
                $longitude = $faker->longitude(-180, 180);
            } else {
                $latitude = null;
                $longitude = null;
            }

            $lieu = new Lieu();
            $lieu
                ->setNom($faker->realTextBetween(1, 30, 3))
                ->setRue($faker->optional(0.8)->streetAddress())
                ->setLatitude($latitude)
                ->setLongitude($longitude)
                ->setVille($faker->randomElement($allVilles));
            $manager->persist($lieu);

            $this->addReference("lieu$i", $lieu);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [VilleFixtures::class];
    }

}