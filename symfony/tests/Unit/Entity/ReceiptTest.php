<?php

/**
 * @author  Etienne Schmitt <etienne@schmitt-etienne.fr>
 * @license GPL 2.0 or any later
 */

namespace App\Tests\Entity;

use App\Entity\Receipt;
use App\Tests\GeneralTestMethod;
use Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\Validator\TraceableValidator;

final class ReceiptTest extends WebTestCase
{
    private Receipt $receipt;
    private TraceableValidator $validator;

    public function setUp(): void
    {
        $this->receipt = new Receipt();
        $this->validator = GeneralTestMethod::getValidator();
    }

    /** @dataProvider validAmountProvider */
    public function testReceiptAmountIsValid(int $amount): void
    {
        $this->receipt->setAmount($amount);

        $violations = $this->validator->validate($this->receipt);
        $this->assertCount(0, $violations);
    }

    /** @return Generator <array<int>> */
    public function validAmountProvider(): Generator
    {
        yield [500];
        yield [100];
        yield [10];
    }

    /** @dataProvider invalidAmountProvider */
    public function testReceiptAmountIsInvalid(int $amount): void
    {
        $this->receipt->setAmount($amount);

        $violations = $this->validator->validate($this->receipt);
        $this->assertGreaterThanOrEqual(1, count($violations));
    }

    /** @return Generator <array<int>> */
    public function invalidAmountProvider(): Generator
    {
        yield [-100];
        yield [0];
        yield [-400];
    }
}
