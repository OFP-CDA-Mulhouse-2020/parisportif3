<?php

namespace App\Tests\Entity;

use App\Entity\Wallet;
use App\Tests\GeneralTestMethod;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\Validator\TraceableValidator;

final class WalletTest extends WebTestCase
{
    private Wallet $wallet;
    private TraceableValidator $validator;

    public function setUp(): void
    {
        $this->validator = GeneralTestMethod::getKernelAndValidator()['validator'];
        $this->wallet = new Wallet();
    }

    public function testCreateWalletObject(): void
    {
        $this->assertInstanceOf(Wallet::class, $this->wallet);
    }


    /** @dataProvider  validAmountProvider */
    public function testCanModifyBalance(int $validAmountProvider): void
    {
        $this->wallet->setBalance($validAmountProvider);
        $this->assertEquals($validAmountProvider, $this->wallet->getBalance());
    }

    public function testCantHaveBalanceBelowZero(): void
    {
        $this->wallet->setBalance(-20);
        $violations = $this->validator->validate($this->wallet);

        $this->assertGreaterThan(0, count($violations));
    }

    public function testCanAddAmountToBalance(): void
    {
        $this->wallet->addToBalance(20);
        $this->wallet->addToBalance(30);

        $this->assertEquals(50, $this->wallet->getBalance());
    }

    public function testCanSubtractAmountToBalance(): void
    {
        $this->wallet->addToBalance(30);
        $this->wallet->removeFromBalance(20);

        $this->assertEquals(10, $this->wallet->getBalance());
    }

    public function testCantSubtractMoreThanPossible(): void
    {
        $this->wallet->removeFromBalance(30);

        $violations = $this->validator->validate($this->wallet);
        $this->assertGreaterThan(0, count($violations));
    }

    /** @return array<array<int>> */
    public function validAmountProvider(): array
    {
        return [
            [20],
            [50]
        ];
    }
}
