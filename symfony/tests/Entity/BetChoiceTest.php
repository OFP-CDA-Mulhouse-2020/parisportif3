<?php

namespace App\Tests\Entity;

use App\Entity\BetChoice;
use PHPUnit\Framework\TestCase;

final class BetChoiceTest extends TestCase
{
    public function testCreateBetChoice(): void
    {
        $betChoice = new BetChoice();

        $this->assertInstanceOf(BetChoice::class, $betChoice);
    }
}
