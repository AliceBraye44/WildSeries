<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;

    }

    public function load(ObjectManager $manager): void
    {

        // user de type contributeur
        $contributor = new User();
        $contributor->setEmail("contributor@wildseries.com");
        $contributor->setRoles(['ROLE_CONTRIBUTOR']);

        $hashedPassword = $this->passwordHasher->hashPassword(
            $contributor,
            '1234'
        );
        $contributor->setPassword($hashedPassword);
        $manager->persist($contributor);

        // user de type admin
        $admin = new User();
        $admin->setEmail("admin@wildseries.com");
        $admin->setRoles(['ROLE_ADMIN']);

        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'admin'
        );
        $admin->setPassword($hashedPassword);
        $manager->persist($admin);

        $manager->flush();
    }
}
