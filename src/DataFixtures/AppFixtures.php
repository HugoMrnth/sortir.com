<?php

namespace App\DataFixtures;

use App\Entity\Participant;
use App\Entity\Wish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class AppFixtures extends Fixture
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
        $manager->persist($admin);

        $manager->flush();
    }
}
