<?php

declare(strict_types=1);

namespace App\Tests;

use App\Tests\Entity\Traits\AssertionErrorsTraits;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase as SymfonyKernelTestCase;

class KernelTestCase extends SymfonyKernelTestCase
{
    use AssertionErrorsTraits;
    use FixturesTrait;

    protected EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();
        /** @var EntityManagerInterface $em */
        $em = self::$container->get(EntityManagerInterface::class);
        $this->entityManager = $em;
        parent::setUp();
    }
}
