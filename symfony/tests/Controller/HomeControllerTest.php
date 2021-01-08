<?php

namespace App\Tests\Controller;

use App\Tests\FunctionalTestMethod;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class HomeControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = FunctionalTestMethod::getClient();
    }


    public function testShowIndexPage(): void
    {
        $this->client->request('GET', '/');
        $this->assertEquals(
            200,
            $this->client->getResponse()->getStatusCode()
        );
    }


    public function testShowMenu(): void
    {
        $this->client->request('GET', '/');

        $this->assertSelectorExists('#menu');
    }

    public function testShowButton(): void
    {
        $this->client->request('GET', '/');

        $this->assertSelectorExists('#button_login');
        $this->assertSelectorExists('#button_register');
    }

    public function testShowFooter(): void
    {
        $this->client->request('GET', '/');
        $this->assertSelectorExists('#footer');
    }
}
