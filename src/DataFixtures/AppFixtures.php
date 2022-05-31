<?php

namespace App\DataFixtures;

use App\Entity\Aliment;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Security;

class AppFixtures extends Fixture
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager)
    {

        // create 10 products! Bam!
        for ($i = 0; $i < 10; $i++) {
            $aliment = new Aliment();
            $aliment->setName('aliment '.$i);
            $aliment->setDescription('bla bla bla');
            $aliment->setContent('bla bla bla');
            $aliment->setUser($this->userRepository->find(6));
            $aliment->setImageName('pineapple-612cdb2ea8b2d905739384.jpg');
            $manager->persist($aliment);
        }

        $manager->flush();
    }
}
