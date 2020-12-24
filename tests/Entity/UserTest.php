<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    private User $user;

    public function setUp(): void
    {
        $this->user = new User();
    }

    public function testUsername(): void
    {
        $this->user->setEmail('test@domain.fr');
        self::assertEquals('test@domain.fr', $this->user->getEmail());
    }

    public function testPassword(): void
    {
        $this->user->setPassword('usertestpassword');
        self::assertEquals('usertestpassword', $this->user->getPassword());
    }

    public function testGetSalt(): void
    {
        self::assertEquals(null, $this->user->getSalt());
    }

    public function testEraseCredentials(): void
    {
        $user = $this->user;
        $this->user->eraseCredentials();
        self::assertEquals($user, $this->user);
    }
}
