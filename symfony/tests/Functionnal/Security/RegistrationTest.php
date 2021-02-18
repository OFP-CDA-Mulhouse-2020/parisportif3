<?php

namespace App\Tests\Security;

use DateTime;
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

    /**
     * @TODO debug
     */
    public function testRegistrationFormTypeValidSubmission(): void
    {
        $person = [
            'username' => 'toto' . (new DateTime())->format('Ymdhhmmss'),
            'firstname' => 'Jean-David',
            'lastname' => 'Martin',
            'birthdate' => '2000-07-01',
            'password' => 'louf265A',
            'email' => 'martin.jean-louis@mail.com'
        ];

        $client = self::createClient();

        $crawler = $client->request('GET', '/register');

        $form = $crawler->selectButton('Register')->form();

        $form['registration_form[username]']->setValue($person['username']);
        $this->assertEquals($person['username'], $form['registration_form[username]']->getValue());

        $form['registration_form[plainPassword][first]']->setValue($person['password']);
        $this->assertEquals($person['password'], $form['registration_form[plainPassword][first]']->getValue());

        $form['registration_form[plainPassword][second]']->setValue($person['password']);
        $this->assertEquals($person['password'], $form['registration_form[plainPassword][second]']->getValue());

        $form['registration_form[firstName]']->setValue($person['firstname']);
        $this->assertEquals($person['firstname'], $form['registration_form[firstName]']->getValue());

        $form['registration_form[lastName]']->setValue($person['lastname']);
        $this->assertEquals($person['lastname'], $form['registration_form[lastName]']->getValue());

        $form['registration_form[email]']->setValue($person['email']);
        $this->assertEquals($person['email'], $form['registration_form[email]']->getValue());

        $form['registration_form[birthDate]']->setValue($person['birthdate']);
        $this->assertEquals($person['birthdate'], $form['registration_form[birthDate]']->getValue());

        $form['registration_form[agreeTerms]']->tick();
        $this->assertEquals(true, $form['registration_form[agreeTerms]']->getValue());

        $client->submit($form);
        $this->assertResponseRedirects("/login");
        $client->followRedirect();

//        $this->assertSelectorExists('.alert-danger');
//        $this->assertSelectorTextContains('.alert-danger', 'Username could not be found.');
    }
}
