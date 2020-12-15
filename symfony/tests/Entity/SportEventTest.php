<?php

namespace App\Tests\Entity;

use App\Entity\SportEvent;
use DateInterval;
use DateTime;
use DateTimeZone;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

final class SportEventTest extends WebTestCase
{
    /*
     * Il doit avoir un nom de lieu, un nom pour la compétition
     * Il doit avoir une date et une dateTimeZone
     * Il ne doit pas accepté les caractères spéciaux et les nombres dans les noms
     */

    private function getKernel(): KernelInterface
    {
        $kernel = $this->bootKernel();
        $kernel->boot();
        return $kernel;
    }

    //Est-ce que je peux créer un SportEvent
    public function testCreateSportEvent(): void
    {
        $sportEvent = new SportEvent();

        $this->assertInstanceOf(SportEvent::class, $sportEvent);
    }

    //Est-ce que SportEvent contient un lieu valide
    public function testLocationInputIsReturned(): void
    {
        $sportEvent = new SportEvent();
        $location = '23 rue des peupliers';

        $sportEvent->setLocation($location);

        $this->assertSame($location, $sportEvent->getLocation());
    }

    //TODO adresse valide avec API

    //Est-ce que SportEvent contient une competition
    public function testCompetitionInputIsReturned(): void
    {
        $sportEvent = new SportEvent();
        $competition = 'Super sport 2022';

        $sportEvent->setCompetition($competition);

        $this->assertSame($competition, $sportEvent->getCompetition());
    }

    /*
    Est-ce que la date est supérieure de 2 jours à la date actuelle
    et que l'heure est supérieur de 48H à l'heure actuelle
    */
    public function testValidDate(): void
    {
        $sportEvent = new SportEvent();
        $date = new DateTime('now', new DateTimeZone('Europe/Paris'));
        $date->add(new DateInterval('P4D'));

        $kernel = $this->getKernel();
        $validator = $kernel->getContainer()->get('validator');
        $violations = $validator->validate($sportEvent);

        $sportEvent->setDate($date);
        $this->assertSame($date, $sportEvent->getDate());
        $this->assertCount(0, $violations);
    }

    //Est-ce que la DateTimeZone est la bonne !
    //TODO finir le test sur Timezone
}
