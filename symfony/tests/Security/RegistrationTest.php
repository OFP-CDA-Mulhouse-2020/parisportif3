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
    /**
     * @TODO debug
     */
//    public function testRegistrationFormTypeSubmission(): void
//    {
//        $person = [
//            'username' => 'toto',
//            'firstname' => 'Jean-Louis',
//            'lastname' => 'Martin',
//            'birthdate' => '2000-07-01',
//            'password' => 'louf265A',
//            'email' => 'martin.jean-louis@mail.com'
//        ];
//
//        $client = self::createClient();
//
//        $crawler= $client->request('GET', '/register');
//
//        $form = $crawler->selectButton('Register')->form();
//
//        $form['registration_form[username]']->setValue($person['username']);
//        $form['registration_form[plainPassword][first]']->setValue($person['password']);
//        $form['registration_form[plainPassword][second]']->setValue($person['password']);
//        $form['registration_form[firstName]']->setValue($person['firstname']);
//        $form['registration_form[lastName]']->setValue($person['lastname']);
//        $form['registration_form[email]']->setValue($person['email']);
//        $form['registration_form[birthDate]']->setValue($person['birthdate']);
//        $form['registration_form[agreeTerms]']->tick();
//        //var_dump($form);
//        $client->submit($form);
//
//        $client->followRedirect();
//
//        $this->assertResponseRedirects("/login");
//
//        $this->assertSelectorExists('.alert-danger');
//        $this->assertSelectorTextContains('.alert-danger', 'Username could not be found.');
//    }
}
