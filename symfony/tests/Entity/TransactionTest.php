<?php

namespace App\Tests\Entity;

use App\Entity\Transaction;
use App\Tests\GeneralTestMethod;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\Validator\TraceableValidator;

final class TransactionTest extends WebTestCase
{
    private TraceableValidator $validator;
    private Transaction $transaction;

    public function setUp(): void
    {
        $this->validator = GeneralTestMethod::getKernelAndValidator()['validator'];
        $this->transaction = new Transaction();
    }

    //Doit pouvoir créer une instance de la classe Transaction
    public function testCreateTransactionObject(): void
    {
        $this->assertInstanceOf(Transaction::class, $this->transaction);
    }

    public function testShouldHaveAValidDateAtTheCreationOfObject(): void
    {
        $this->assertLessThan(new DateTime(), $this->transaction->getTransactionDate());
        $violations = $this->validator->validate($this->transaction);
        $this->assertCount(0, $violations);
    }


    //Doit permettre d'ajouter un objet de classe Wallet
//    public function testCanInsertAWalletObject(): void
//    {
//        $userWallet = new Wallet();
//        $this->transaction->setWallet($userWallet);
//
//        $this->assertInstanceOf(Wallet::class, $this->transaction->getWallet());
//    }

    public function testCanBetAValidAmount(): void
    {
        $this->transaction->setAmount(1384);

        $this->assertEquals(1384, $this->transaction->getAmount());
    }

    /** @dataProvider amountProvider */
    public function testCantBetAInvalidAmount(int $amountProvider): void
    {
        $this->transaction->setAmount($amountProvider);
        $violations = $this->validator->validate($this->transaction);

        $this->assertGreaterThan(0, count($violations));
    }

    /** @return array<array<int>> */
    public function amountProvider(): array
    {
        return [
            [0],
            [-20],
            [50],
            [99],
        ];
    }

//    public function testCanInsertABetChoiceObject(): void
//    {
//        $userBetChoice = new BetTemplateChoice();
//        $this->transaction->setBetTemplateChoice($userBetChoice);
//
//        $this->assertInstanceOf(BetTemplateChoice::class, $this->transaction->getBetTemplateChoice());
//    }
}
