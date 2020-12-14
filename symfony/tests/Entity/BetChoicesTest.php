<?php

namespace App\Tests\Entity;

use App\Entity\BetChoices;
use PHPUnit\Framework\TestCase;

final class BetChoicesTest extends TestCase
{
    public function testCreateBetChoices(): void
    {
        $betChoices = new BetChoices();

        $this->assertInstanceOf(BetChoices::class, $betChoices);
    }
}
