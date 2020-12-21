<?php

namespace App\Tests\Entity;

use App\Tests\GeneralTestMethod;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validator\TraceableValidator;

final class BetTest extends TestCase
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
}
