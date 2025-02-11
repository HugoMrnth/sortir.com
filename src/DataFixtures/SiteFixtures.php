<?php

namespace App\DataFixtures;

use App\Entity\Site;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SiteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $siteNames = ['Saint-Herblain', 'Chartres de Bretagne', 'La Roche-sur-Yon'];

        foreach ($siteNames as $nom) {
            $site = new Site();
            $site->setNom($nom);
            $manager->persist($site);

            $this->addReference('site-'.$nom, $site);
        }

        $manager->flush();
    }

}