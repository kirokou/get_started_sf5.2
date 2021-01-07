<?php

declare(strict_types=1);

namespace App\Tests;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as SymfonyWebTestCase;

class WebTestCase extends SymfonyWebTestCase
{
    use FixturesTrait;

    protected KernelBrowser $client;
    protected EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        /** @var EntityManagerInterface $em */
        $em = self::$container->get(EntityManagerInterface::class);
        $this->entityManager = $em;
        parent::setUp();
    }

    public function login(?User $user): void
    {
        if (null === $user) {
            return;
        }
        $this->client->loginUser($user);
    }

    protected function logInUser(): void
    {
        $usersData = $this->loadFixtureFiles([__DIR__.'/Fixtures/UserFixturesTest.yaml']);
        /** @var User $user */
        $user = $usersData['user_1'];
        $this->login($user);
    }

    protected function logInAdmin(): void
    {
        $usersData = $this->loadFixtureFiles([__DIR__.'/Fixtures/UserFixturesTest.yaml']);
        /** @var User $admin */
        $admin = $usersData['admin_1'];
        $this->login($admin);
    }

    protected function logInSuperAdmin(): void
    {
        $usersData = $this->loadFixtureFiles([__DIR__.'/Fixtures/UserFixturesTest.yaml']);
        /** @var User $superAdmin */
        $superAdmin = $usersData['super_admin_1'];
        $this->login($superAdmin);
    }
}
