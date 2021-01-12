<?php

namespace App\Tests\Entity;

use App\Entity\Wallet;
use App\Tests\GeneralTestMethod;
use Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\Validator\TraceableValidator;

final class WalletTest extends WebTestCase
{
    private Wallet $wallet;
    private TraceableValidator $validator;

    public function setUp(): void
    {
        $this->validator = GeneralTestMethod::getValidator();
        $this->wallet = new Wallet();
    }

    public function testCreateWalletObject(): void
    {
        $this->assertInstanceOf(Wallet::class, $this->wallet);
    }

    /** @dataProvider validAmountProvider */
    public function testCanAddToWallet(int $amountToAdd): void
    {
        $this->wallet->addToBalance($amountToAdd);

        $violations = $this->validator->validate($this->wallet);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("balance", $violations);

        $this->assertEquals($amountToAdd, $this->wallet->getBalance());
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider validAmountProvider */
    public function testCanRemoveFromWallet(int $amountToRemove): void
    {
        $finalAmount = 50;

        $this->wallet->addToBalance(($amountToRemove + $finalAmount));

        $this->wallet->removeFromBalance($amountToRemove);

        $violations = $this->validator->validate($this->wallet);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("balance", $violations);

        $this->assertSame($finalAmount, $this->wallet->getBalance());
        $this->assertFalse($violationOnAttribute);
    }

    /** @return Generator<array<int>> */
    public function validAmountProvider(): Generator
    {
        yield [20];
        yield [50];
        yield [25];
        yield [66];
        yield [10];
        yield [5];
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
}
