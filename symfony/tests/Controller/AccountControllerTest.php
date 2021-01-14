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
    private User $noModifUser;
    private User $ModifUser;

    public function setUp(): void
    {
        $this->client = GeneralTestMethod::getClient();
        $userRepo = static::$container->get(UserRepository::class);
        $this->noModifUser = $userRepo->findOneBy(['username' => 'test0']);
        $this->ModifUser = $userRepo->findOneBy(['username' => 'test1']);
    }

    public function testShowMyAccount(): void
    {
        $this->client->loginUser($this->noModifUser);
        $this->client->request('GET', '/myAccount');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testDoesNotShowIfNotLogged(): void
    {
        $this->client->request('GET', '/myAccount');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testShowPersonalInfoForm(): void
    {
        $this->client->loginUser($this->noModifUser);
        $this->client->request('GET', 'myAccount/personalInfo');

        $this->assertSelectorExists('form');
        $this->assertSelectorExists('form > input');
        $this->assertSelectorExists('form > button');
    }

    public function testShowPersonalInfoFromUser(): void
    {
        $this->client->loginUser($this->noModifUser);
        $crawler = $this->client->request('GET', 'myAccount/personalInfo');
        $form = $crawler->selectButton('Soumettre')->form();

        $this->assertSame($this->noModifUser->getEmail(), $form['personal_info_form[email]']->getValue());
        $this->assertSame($this->noModifUser->getLastName(), $form['personal_info_form[lastName]']->getValue());
        $this->assertSame($this->noModifUser->getFirstName(), $form['personal_info_form[firstName]']->getValue());
        $this->assertSame($this->noModifUser->getTimeZone(), $form['personal_info_form[timeZone]']->getValue());
    }

    public function testModifyUserWithInvalidInfo(): void
    {
        $this->client->loginUser($this->ModifUser);
        $crawler = $this->client->request('GET', 'myAccount/personalInfo');
        $form = $crawler->selectButton('Soumettre')->form();

        $form['personal_info_form[email]']->setValue('1234568');

        $this->client->submit($form);
        $this->assertSelectorExists('.flash-warning');
    }

    public function testModifyUserWithValidInfo(): void
    {
        $this->client->loginUser($this->ModifUser);
        $crawler = $this->client->request('GET', 'myAccount/personalInfo');
        $form = $crawler->selectButton('Soumettre')->form();

        $form['personal_info_form[email]']->setValue('jean@test.com');

        $this->client->submit($form);
        $this->assertSelectorExists('.flash-success');
    }
}
