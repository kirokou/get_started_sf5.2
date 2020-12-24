<?php

namespace App\Tests\Controller;

use App\Tests\Traits\NeedLogin;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    use NeedLogin;

    protected KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
        parent::setUp();
    }

    public function testLoginPage(): void
    {
        $crawler = $this->client->request('GET', '/en/login');
        static::assertSame(200, $this->client->getResponse()->getStatusCode());
        static::assertResponseIsSuccessful();
        // form
        static::assertSelectorNotExists('.alert.alert-danger');
        static::assertSame(1, $crawler->filter('form')->count());
        static::assertSame(1, $crawler->filter('input[name="email"]')->count());
        static::assertSame(1, $crawler->filter('input[name="password"]')->count());
        static::assertSame(1, $crawler->filter('button[type="submit"]')->count());
    }

    public function testLoginWithBadCredentials(): void
    {
        $crawler = $this->client->request('GET', '/en/login');
        // Form
        $form = $crawler->selectButton('Sign in')->form();
        $form['email'] = 'test';
        $form['password'] = 'InvalidPassword';
        $this->client->submit($form);
        // Form redirect
        static::assertResponseRedirects('/en/login');
        $this->client->followRedirect();
        // Assertions
        static::assertSame(200, $this->client->getResponse()->getStatusCode());
        static::assertSelectorExists('.alert.alert-danger');
        static::assertSelectorTextSame('div.alert', "Email or password could not be found");

    }

    public function testLoginIsSuccessuful(): void
    {
        $crawler = $this->client->request('GET', '/en/login');
        // Form
        $form = $crawler->selectButton('Sign in')->form();
        $form['email'] = 'user@gmail.com';
        $form['password'] = 'Synolia-2020';
        $this->client->submit($form);
        // Form redirect
        static::assertSame(302, $this->client->getResponse()->getStatusCode());
        static::assertResponseRedirects('/en/ip');
        $this->client->followRedirect();
        static::assertSame(200, $this->client->getResponse()->getStatusCode());
        // No Message error
        #static::assertSelectorNotExists('.alert.alert-danger');
    }

    public function testUserAuthenticatedFully(): void
    {
        $this->logIn($this->client, $this->getUser('user@gmail.com'));
        $this->client->request('GET', '/en/login');
        static::assertResponseRedirects('/en/ip');
        $this->client->followRedirect();
        static::assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testLogout(): void
    {
        $this->client->request('GET', '/en/logout');
        static::assertSame(302, $this->client->getResponse()->getStatusCode());
    }
}