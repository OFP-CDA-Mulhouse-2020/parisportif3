<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    final public function testShowLogin(): void
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    final public function testShowForm(): void
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        self::assertSelectorExists('form');
        self::assertSelectorExists('form > input');
        self::assertSelectorExists('form > button');
    }

    final public function testShowInput(): void
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        self::assertSelectorExists('input#inputUsername');
        self::assertSelectorExists('input#inputPassword');
        self::assertSelectorExists("button[type='submit']");
    }
}
