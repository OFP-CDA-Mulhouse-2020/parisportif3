<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Tests\GeneralTestMethod;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Field\FormField;

final class LoginControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = GeneralTestMethod::getClient();
    }


    public function testShowLogin(): void
    {
        $this->client->request('GET', '/login');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testShowForm(): void
    {
        $this->client->request('GET', '/login');
        $this->assertSelectorExists('form');
        $this->assertSelectorExists('form > input');
        $this->assertSelectorExists('form > button');
    }

    public function testShowInput(): void
    {
        $this->client->request('GET', '/login');
        $this->assertSelectorExists('input#inputUsername');
        $this->assertSelectorExists('input#inputPassword');
        $this->assertSelectorExists("button[type='submit']");
    }

    public function testLoginWithInvalidUser(): void
    {
        $user = new User();
        $user->setUsername('invalidTest');
        $user->setPassword('12345678A');

        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Sign in')->form();

        assert($form['username'] instanceof FormField);
        assert($form['password'] instanceof FormField);
        $form['username']->setValue($user->getUsername(""));
        $form['password']->setValue($user->getPassword(""));

        $this->client->submit($form);

        $this->assertResponseRedirects("/login");

        $this->client->followRedirect();

        $this->assertSelectorExists('.alert-danger');
        $this->assertSelectorTextContains('.alert-danger', 'Username could not be found.');
    }

    //TODO:: Ajouter le test pour un utilisateur valide.
}
