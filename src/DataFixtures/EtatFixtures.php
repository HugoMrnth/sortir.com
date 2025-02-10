<?php

namespace App\DataFixtures;

use App\Entity\Etat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EtatFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $etatNames = ['En création', 'Ouverte', 'Clôturée', 'En cours', 'Terminée', 'Historisée','Annulée'];

        foreach ($etatNames as $libelle) {
            $etat = new Etat();
            $etat->setLibelle($libelle);
            $manager->persist($etat);

            $this->addReference('etat-'.$libelle, $etat);
        }

        $manager->flush();
    }

}