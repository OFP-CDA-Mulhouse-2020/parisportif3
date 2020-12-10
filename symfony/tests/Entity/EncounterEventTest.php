<?php

namespace App\Tests\Entity;

use App\Entity\EncounterEvent;
use PHPUnit\Framework\TestCase;

class EncounterEventTest extends TestCase
{
    //Doit pouvoir créer une instance de la classe EncounterEvent
    public function testCreateEncounterEventObject(): void
    {
        $this->assertInstanceOf(EncounterEvent::class, new EncounterEvent());
    }
}
