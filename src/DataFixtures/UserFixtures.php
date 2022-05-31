<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;
    private $urlGenerator;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
     {
         $this->passwordHasher = $passwordHasher;
     }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $manager->persist($user);
        $user->setEmail('julien.rochefolle@gmail.com');
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            '123456'
        ));

        $manager->flush();
    }
}
