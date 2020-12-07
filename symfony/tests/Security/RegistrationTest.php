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
}
