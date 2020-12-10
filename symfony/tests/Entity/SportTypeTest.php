<?php

namespace App\Tests\Entity;

use App\Entity\SportType;
use PHPUnit\Framework\TestCase;

class SportTypeTest extends TestCase
{
    // Doit pouvoir créer une instance de la classe SportType
    public function testCreateSportType(): void
    {
        $this->assertInstanceOf(SportType::class, new SportType());
    }
}
