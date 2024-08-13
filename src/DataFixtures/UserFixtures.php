<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
    }
    public function load(ObjectManager $manager): void
    {
        //the first user
        $user = new User();
        $user->setEmail('yazidsefsaf45@yahoo,com');
        $user->setRoles(['ROLE_CONTRIBUTOR']);
        $this->addReference('user', $user);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'password'
        );
        $user->setPassword($hashedPassword);
        $manager->persist($user);

        $admin = new User();
        $admin->setEmail('yazidsefsaf45@gmail.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'password'
        );
        $this->addReference('admin', $admin);
        $admin->setPassword($hashedPassword);
        $manager->persist($admin);

        //ajouter les deux utilisateurs
        $manager->flush();
    }
}
