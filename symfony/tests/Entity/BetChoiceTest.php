<?php

namespace App\Tests\Entity;

use App\Entity\BetChoice;
use App\Tests\GeneralTestMethod;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\Validator\TraceableValidator;

final class BetChoiceTest extends WebTestCase
{
    /**
     * @var BetChoice
     */
    private BetChoice $betChoice;
    /**
     * @var mixed
     */
    private TraceableValidator $validator;

    public function setUp(): void
    {
        $this->betChoice = new BetChoice();
        $this->validator = GeneralTestMethod::getKernelAndValidator()["validator"];
    }

    public function testCreateBetChoice(): void
    {
        $choice = [1, 2, 3];
        $this->betChoice->setChoice($choice);
        $this->assertIsArray($this->betChoice->getChoice());

        $this->assertCount(0, $this->validator->validate($this->betChoice));
    }

    /** @dataProvider invalidBetChoiceProvider */
    public function testInvalidBetChoice(array $invalidBetChoiceProvider): void
    {
        $this->betChoice->setChoice($invalidBetChoiceProvider);
        $violations = $this->validator->validate($this->betChoice);

        $this->assertGreaterThanOrEqual(1, count($violations));
    }

    public function invalidBetChoiceProvider(): array
    {
        return [
            [['']],
            [['juin']]
        ];
    }
}
