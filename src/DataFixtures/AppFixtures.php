<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private Generator $faker;
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->faker = Factory::create();
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadIp($manager);
        $this->loadContact($manager);
        $this->loadUser($manager);
    }

    private function loadUser(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('user@gmail.com');
        $user->setRoles(['ROLE_ADMIN']);
        $password = $this->passwordEncoder->encodePassword($user, 'Synolia-2020');
        $user->setPassword($password);
        $manager->persist($user);
        $manager->flush();
    }

}
