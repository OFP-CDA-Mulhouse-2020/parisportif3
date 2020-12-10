<?php

namespace App\Tests\Entity;

use App\Entity\SportEvent;
use PHPUnit\Framework\TestCase;

final class SportEventTest extends TestCase
{
    /*
     * Il doit avoir un nom de lieu, un nom pour la compétition
     * Il doit avoir une date et une dateTimeZone
     * Il ne doit pas accepté les caractères spéciaux et les nombres dans les noms
     */

    /*
     * Est-ce que je peux créer un SportEvent
     */
    public function testCreateSportEvent(): void
    {
        $sportEvent = new SportEvent();

        $this->assertInstanceOf(SportEvent::class, $sportEvent);
    }
}
