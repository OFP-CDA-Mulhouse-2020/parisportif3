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

    /*
     * Est-ce que SportEvent contient un lieu valide
     */
    public function testLocationInputIsReturned(): void
    {
        $sportEvent = new SportEvent();
        $location = '23 rue des peupliers';

        $sportEvent->setLocation($location);

        $this->assertSame($location, $sportEvent->getLocation());
    }

    //TODO adresse valide avec API

    /*
     * Est-ce que SportEvent contient une competition
     */
    public function testCompetitionInputIsReturned(): void
    {
        $sportEvent = new SportEvent();
        $competition = 'Super sport 2022';

        $sportEvent->setCompetition($competition);

        $this->assertSame($competition, $sportEvent->getCompetition());
    }
}
