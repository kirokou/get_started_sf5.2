<?php

namespace App\Tests\Traits;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

trait NeedLogin
{
    /**
     * @param KernelBrowser $client
     * @param User $user
     */
    public function logIn (KernelBrowser $client, User $user): void
    {
        $container = $client->getContainer();
        $session = $container->get('session');

        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        /** @phpstan-ignore-next-line */
        $session->set('_security_main', serialize($token));
        /** @phpstan-ignore-next-line */
        $session->save();
        /** @phpstan-ignore-next-line */
        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);
    }

    /**
     * @param String|null $email
     * @return mixed
     */
    private function getUser (String $email = null)
    {
        //code 606
        /** @var UserRepository $userRepository */
        $userRepository = static::$container->get(UserRepository::class);
        return $userRepository->findOneBy(['email' => $email]);
    }
}