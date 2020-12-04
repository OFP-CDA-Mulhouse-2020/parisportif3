<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class LoginControllerTest extends WebTestCase
{
    public function testShowLogin(): void
    {
        $client = self::createClient();
        $client->request('GET', '/login');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testShowForm(): void
    {
        $client = self::createClient();
        $client->request('GET', '/login');
        $this->assertSelectorExists('form');
        $this->assertSelectorExists('form > input');
        $this->assertSelectorExists('form > button');
    }

    public function testShowInput(): void
    {
        $client = self::createClient();
        $client->request('GET', '/login');
        $this->assertSelectorExists('input#inputUsername');
        $this->assertSelectorExists('input#inputPassword');
        $this->assertSelectorExists("button[type='submit']");
    }
}
