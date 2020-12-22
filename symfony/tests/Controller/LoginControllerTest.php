<?php

namespace App\Tests\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Field\FormField;

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

    public function testLoginWithInvalidUser(): void
    {
        $client = self::createClient();

        $user = new User();
        $user->setUsername('invalidTest');
        $user->setPassword('12345678A');

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Sign in')->form();

        assert($form['username'] instanceof FormField);
        assert($form['password'] instanceof FormField);
        $form['username']->setValue($user->getUsername());
        $form['password']->setValue($user->getPassword());

        $client->submit($form);

        $this->assertResponseRedirects("/login");

        $client->followRedirect();

        $this->assertSelectorExists('.alert-danger');
        $this->assertSelectorTextContains('.alert-danger', 'Username could not be found.');
    }

    //TODO:: Ajouter le test pour un utilisateur valide.
}
