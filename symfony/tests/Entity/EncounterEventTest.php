<?php

namespace App\Tests\Entity;

use App\Entity\EncounterEvent;
use App\Entity\SportType;
use PHPUnit\Framework\TestCase;

class EncounterEventTest extends TestCase
{
    //Doit pouvoir créer une instance de la classe EncounterEvent
    public function testCreateEncounterEventObject(): void
    {
        $this->assertInstanceOf(EncounterEvent::class, new EncounterEvent());
    }

    //Doit pouvoir insérer un objet de la classe SportType
    public function testInsertSportTypeObject(): void
    {
        $encounterEvent = new EncounterEvent();
        $sportType = new SportType();

        $encounterEvent->setSportType($sportType);

        $this->assertInstanceOf(SportType::class, $encounterEvent->getSportType());
    }

    //Doit pouvoir insérer un objet de la classe SportEvent
    public function testInsertSportEventObject(): void
    {
        $encounterEvent = new EncounterEvent();
        $sportEvent = new SportEvent();

        $this->assertTrue($encounterEvent->setSportEvent($sportEvent));
    }
}
