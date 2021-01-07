<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Tests\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
    public function testLoginPage(): void
    {
        $crawler = $this->client->request('GET', '/login');
        self::assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        self::assertResponseIsSuccessful();
        // form
        self::assertSelectorNotExists('.alert.alert-danger');
        self::assertSame(1, $crawler->filter('form')->count());
        self::assertSame(1, $crawler->filter('input[name="email"]')->count());
        self::assertSame(1, $crawler->filter('input[name="password"]')->count());
        self::assertSame(1, $crawler->filter('button[type="submit"]')->count());
    }

    public function testLoginWithBadCredentials(): void
    {
        $crawler = $this->client->request('GET', '/login');
        // Form
        $form = $crawler->selectButton('Sign in')->form();
        $form['email'] = 'test';
        $form['password'] = 'InvalidPassword';
        $this->client->submit($form);
        // Form redirect
        self::assertResponseRedirects('/login');
        $this->client->followRedirect();
        // Assertions
        self::assertSame(200, $this->client->getResponse()->getStatusCode());
        self::assertSelectorExists('.alert.alert-danger');
    }

    public function testUserAuthenticatedFully(): void
    {
        $this->logInUser();
        $this->client->request('GET', '/login');
        self::assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
        self::assertResponseRedirects('/');
        $this->client->followRedirect();
        self::assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testLogout(): void
    {
        $this->logInUser();
        $this->client->request('GET', '/logout');
        self::assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
        self::assertResponseRedirects('');
        $this->client->followRedirect();
        self::assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }
}
