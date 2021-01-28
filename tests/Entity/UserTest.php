<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\User;
use App\Tests\KernelTestCase;
use DateTimeImmutable;

class UserTest extends KernelTestCase
{
    public function testUsername(): void
    {
        $user = $this->getUser();
        self::assertSame('user_test_email@example.com', $user->getEmail());
    }

    public function testPassword(): void
    {
        $user = $this->getUser();
        self::assertSame('user_test_password', $user->getPassword());
    }

    public function testIsVerified(): void
    {
        $user = $this->getUser();
        self::assertTrue($user->isVerified());
    }

    public function testGetSalt(): void
    {
        $user = $this->getUser();
        self::assertNull($user->getSalt());
    }

    public function testSaveAdminsSuccessfully(): void
    {
        $user = $this->saveUser();

        self::assertNotNull($user->getId());
        self::assertIsInt($user->getId());
        self::assertInstanceOf(DateTimeImmutable::class, $user->getCreatedAt());
        self::assertNull($user->getUpdatedAt());
    }

    public function testAdminsWithEmailAlreadyExists(): void
    {
        $this->loadFixtureFiles([\dirname(__DIR__).'/Fixtures/UserFixturesTest.yaml']);
        $user = $this->getUser();

        $this->assertHasErrors($user->setEmail('user_email_1@domain.com'), 1);
    }

    private function saveUser(): User
    {
        $user = $this->getUser();
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    private function getUser(): User
    {
        return (new User())
            ->setEmail('user_test_email@example.com')
            ->setPassword('user_test_password')
            ->setIsVerified(true)
        ;
    }
}
