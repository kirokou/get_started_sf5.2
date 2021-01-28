<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Tests\KernelTestCase;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class UserRepositoryTest extends KernelTestCase
{
    public function testCountRows(): void
    {
        $this->loadFixtureFiles([\dirname(__DIR__).'/Fixtures/UserFixturesTest.yaml']);
        $user = $this->getRepository()->count([]);

        self::assertSame(30, $user);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function testUpgradePassword(): void
    {
        $this->loadFixtureFiles([\dirname(__DIR__).'/Fixtures/UserFixturesTest.yaml']);
        /** @var User $user */
        $user = $this->getRepository()->findOneBy(['email' => 'user_email_1@domain.com']);
        $this->getRepository()->upgradePassword($user, '123456789');

        self::assertSame('123456789', $user->getPassword());
    }

    private function getRepository(): UserRepository
    {
        /* @phpstan-ignore-next-line */
        return $this->entityManager->getRepository(User::class);
    }
}
