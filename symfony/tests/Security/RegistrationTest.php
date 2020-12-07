<?php

namespace App\tests\Security;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class RegistrationTest extends WebTestCase
{
    public function testShowRegistrationFormType(): void
    {
        $client = self::createClient();
        $client->request('GET', '/login');

        $this->assertSelectorExists('form');
        $this->assertSelectorExists('form > input');
        $this->assertSelectorExists('form > button');
    }

    public function testShowRegistrationFormTypeInput(): void
    {
        $client = self::createClient();
        $client->request('GET', '/login');

        $this->assertSelectorExists('input#inputUsername');
        $this->assertSelectorExists('input#inputPassword');
        $this->assertSelectorExists("button[type='submit']");
    }
}
