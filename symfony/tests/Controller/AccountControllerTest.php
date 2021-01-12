<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Tests\GeneralTestMethod;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AccountControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private User $validUser;

    public function setUp(): void
    {
        $this->client = GeneralTestMethod::getClient();
        $userRepo = static::$container->get(UserRepository::class);
        $this->validUser = $userRepo->findOneBy(['email' => 'test@test.com']);
    }

    public function testShowMyAccount(): void
    {
        $this->client->loginUser($this->validUser);
        $this->client->request('GET', '/myAccount');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testDoesNotShowIfNotLogged(): void
    {
        $this->client->request('GET', '/myAccount');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }
}
