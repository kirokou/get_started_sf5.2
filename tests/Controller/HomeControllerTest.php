<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Tests\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class HomeControllerTest extends WebTestCase
{
    public function testHomeRouteSuccess(): void
    {
        $this->client->request('GET', '/');
        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertPageTitleContains('Hello HomeController!');
    }
}
