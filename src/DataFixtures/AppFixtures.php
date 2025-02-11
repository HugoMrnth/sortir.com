<?php

namespace App\DataFixtures;

use App\Entity\Participant;
use App\Entity\Site;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture implements DependentFixtureInterface
{

    public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasher)
    { }
    public function load(ObjectManager $manager): void
    {

        $admin = new Participant();
        $admin->setUsername('admin');
        $admin->setEmail('admin@test.fr');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->userPasswordHasher->hashPassword($admin, 'root'));
        $admin->setNom("Super");
        $admin->setPrenom("Didier");
        $admin->setTelephone("0123456789");
        $admin->setActif(true);
        $admin->setSite($this->getReference('site-Saint-Herblain', Site::class));
        $manager->persist($admin);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [SiteFixtures::class];
    }

}
