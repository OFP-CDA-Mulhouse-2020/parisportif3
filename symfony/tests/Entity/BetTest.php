<?php

namespace App\Tests\Entity;

use App\Entity\Bet;
use App\Tests\GeneralTestMethod;
use DateInterval;
use DateTime;
use Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\Validator\TraceableValidator;

final class BetTest extends WebTestCase
{
    private TraceableValidator $validator;
    private Bet $bet;
    private const STATUS_UNPAID = 0;
    private const STATUS_PENDING = 1;
    private const STATUS_PAID = 2;

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
        $this->bet->setStatus($this::STATUS_PAID);
        $this->bet->setDate(
            (new DateTime())
                ->add(new DateInterval('P2D'))
        );
        $this->bet->setCote(125);

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
        $this->bet->setStatus($this::STATUS_PAID);
        $this->bet->setDate(
            (new DateTime())
                ->add(new DateInterval('P2D'))
        );
        $this->bet->setCote(125);

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

    /** @dataProvider validStatusProvider */
    public function testStatusIsValid(int $status): void
    {
        $this->bet->setStatus($status);

        $this->bet->setAmount(50);
        $this->bet->setDate(
            (new DateTime())
                ->add(new DateInterval('P2D'))
        );
        $this->bet->setCote(125);

        $violations = $this->validator->validate($this->bet);
        $this->assertCount(0, $violations);
    }

    /** @return Generator<array<int>> */
    public function validStatusProvider(): Generator
    {
        yield [$this::STATUS_UNPAID];
        yield [$this::STATUS_PENDING];
        yield [$this::STATUS_PAID];
    }

    /** @dataProvider invalidStatusProvider */
    public function testStatusIsInvalid(int $status): void
    {
        $this->bet->setStatus($status);

        $this->bet->setAmount(50);
        $this->bet->setDate(
            (new DateTime())
                ->add(new DateInterval('P2D'))
        );
        $this->bet->setCote(125);

        $violations = $this->validator->validate($this->bet);
        $this->assertGreaterThanOrEqual(1, count($violations));
    }

    /** @return Generator<array<int>> */
    public function invalidStatusProvider(): Generator
    {
        yield [42];
        yield [-1];
        yield [5];
        yield [8];
        yield [6];
        yield [3];
    }

    /** @dataProvider validDateProvider */
    public function testDateIsOlderThanNow(DateTime $dateBet): void
    {
        $this->bet->setDate($dateBet);

        $this->bet->setAmount(50);
        $this->bet->setStatus($this::STATUS_PAID);
        $this->bet->setCote(125);

        $violations = $this->validator->validate($this->bet);
        $this->assertCount(0, $violations);
    }

    /** @return Generator<array<DateTime>> */
    public function validDateProvider(): Generator
    {
        yield [(new DateTime())->add(new DateInterval('PT2H'))];
        yield [(new DateTime())->add(new DateInterval('PT5M'))];
        yield [(new DateTime())->add(new DateInterval('P2D'))];
    }

    public function testDateIsInvalid(): void
    {
        $this->bet->setAmount(50);
        $this->bet->setStatus($this::STATUS_PAID);
        $this->bet->setCote(125);

        $violations = $this->validator->validate($this->bet);
        $this->assertGreaterThanOrEqual(1, count($violations));
    }

    /** @dataProvider validCote */
    public function testCoteIsValid(int $cote): void
    {
        $this->bet->setCote($cote);

        $this->bet->setAmount(50);
        $this->bet->setStatus($this::STATUS_PAID);
        $this->bet->setDate(
            (new DateTime())
                ->add(new DateInterval('P2D'))
        );

        $violations = $this->validator->validate($this->bet);
        $this->assertCount(0, $violations);
    }

    /** @return Generator<array<int>> */
    public function validCote(): Generator
    {
        yield [115];
        yield [110];
        yield [250];
        yield [1000];
    }

    /** @dataProvider invalidCote */
    public function testCoteIsInvalid(int $cote): void
    {
        $this->bet->setCote($cote);

        $this->bet->setAmount(50);
        $this->bet->setStatus($this::STATUS_PAID);
        $this->bet->setDate(
            (new DateTime())
                ->add(new DateInterval('P2D'))
        );

        $violations = $this->validator->validate($this->bet);
        $this->assertGreaterThanOrEqual(1, count($violations));
    }

    /** @return Generator<array<int>> */
    public function invalidCote(): Generator
    {
        yield [100];
        yield [99];
        yield [50];
        yield [0];
        yield [-100];
        yield [-150];
    }
}
