<?php

namespace App\Tests\Entity;

use App\Entity\Bet;
use App\Tests\GeneralTestMethod;
use Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\Validator\TraceableValidator;

final class BetTest extends WebTestCase
{
    private TraceableValidator $validator;
    private Bet $bet;

    public function setUp(): void
    {
        $this->bet = new Bet();
        $this->validator = GeneralTestMethod::getKernelAndValidator()['validator'];
    }

    public function testCartItemClassExist(): void
    {
        $this->assertInstanceOf(Bet::class, $this->bet);
    }

    /** @dataProvider validAmountProvider */
    public function testAmountIsEnough(int $value): void
    {
        $this->bet->setAmount($value);

        $violations = $this->validator->validate($this->bet);

        $this->assertCount(0, $violations);
    }

    /** @return Generator<array<int>> */
    public function validAmountProvider(): Generator
    {
        yield [420];
        yield [120];
        yield [40];
        yield [50];
        yield [1];
    }

    /** @dataProvider invalidAmountProvider */
    public function testAmountIsInvalid(int $value): void
    {
        $this->bet->setAmount($value);

        $violations = $this->validator->validate($this->bet);
        $this->assertGreaterThanOrEqual(1, count($violations));
    }

    /** @return Generator<array<int>> */
    public function invalidAmountProvider(): Generator
    {
        yield [0];
        yield [-50];
        yield [-1400];
        yield [-1];
        yield [-420];
    }
}
