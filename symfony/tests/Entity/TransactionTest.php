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


}
