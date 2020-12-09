<?php

namespace App\tests\Security;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class RegistrationTest extends WebTestCase
{
    public function testShowRegistrationFormType(): void
    {
        $client = self::createClient();
        $client->request('GET', '/register');

        $this->assertSelectorExists('form');
        $this->assertSelectorExists('form > input');
        $this->assertSelectorExists('form > button');
    }

    public function testShowRegistrationFormTypeInput(): void
    {
        $client = self::createClient();
        $client->request('GET', '/register');

        $this->assertSelectorExists('input#registration_form_username');
        $this->assertSelectorExists('input#registration_form_plainPassword_first');
        $this->assertSelectorExists('input#registration_form_birthDate');
        $this->assertSelectorExists("button[type='submit']");
    }
}
