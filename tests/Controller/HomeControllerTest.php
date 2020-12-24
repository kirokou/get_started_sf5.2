<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class HomeControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }


    public function testHomeRedirectSuccess(): void
    {
        $this->client->request('GET', '/');
        static::assertResponseStatusCodeSame(Response::HTTP_FOUND);
        static::assertResponseRedirects('/en/');
        $this->client->followRedirect();
        static::assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testHomeRouteSuccess(): void
    {
        $this->client->request('GET', '/en/');
        static::assertResponseIsSuccessful();
        static::assertResponseStatusCodeSame(Response::HTTP_OK);
        static::assertSelectorTextContains('h1', 'Hello Synolia !');
    }

}
