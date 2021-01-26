<?php

namespace App\Tests\Entity;

use App\Entity\BetChoice;
use App\Tests\GeneralTestMethod;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\Validator\TraceableValidator;

final class BetChoiceTest extends WebTestCase
{
    private BetChoice $betChoice;
    private TraceableValidator $validator;

    public function setUp(): void
    {
        $this->betChoice = new BetChoice();
        $this->validator = GeneralTestMethod::getValidator();
    }

    public function testCreateBetChoice(): void
    {
        $choice = ["choice" => 1];
        $this->betChoice->setChoice($choice);
        $this->assertIsArray($this->betChoice->getChoice());

        $this->assertCount(1, $this->validator->validate($this->betChoice));
    }

    /**
     * @dataProvider invalidBetChoiceProvider
     * @param array<int> $invalidBetChoice
     */
    public function testInvalidBetChoice(array $invalidBetChoice): void
    {
        $this->betChoice->setChoice($invalidBetChoice);
        $violations = $this->validator->validate($this->betChoice);

        $this->assertGreaterThanOrEqual(1, count($violations));
    }

    /** @return array<array<array<float|int|string>>> */
    public function invalidBetChoiceProvider(): array
    {
        return [
            [['']],
            [['juin']],
            [[]],
            [[-15]],
            [[2.7]]
        ];
    }
}
