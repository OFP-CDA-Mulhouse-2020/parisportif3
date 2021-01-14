<?php

namespace App\Tests\Entity;

use App\Entity\SportEvent;
use App\Tests\GeneralTestMethod;
use DateInterval;
use DateTime;
use DateTimeZone;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\Validator\TraceableValidator;

final class SportEventTest extends WebTestCase
{
    /*
     * Il doit avoir un nom de lieu, un nom pour la compétition
     * Il doit avoir une date et une dateTimeZone
     * Il ne doit pas accepté les caractères spéciaux et les nombres dans les noms
     */
    private SportEvent $sportEvent;
    private TraceableValidator $validator;

    public function setUp(): void
    {
        $this->sportEvent = new SportEvent();
        $this->validator = GeneralTestMethod::getValidator();
    }

    //Est-ce que je peux créer un SportEvent
    public function testCreateSportEvent(): void
    {
        $this->assertInstanceOf(SportEvent::class, $this->sportEvent);
    }

    //Est-ce que SportEvent contient un lieu valide
    public function testLocationInputIsReturned(): void
    {
        $location = '23 rue des peupliers';

        $this->sportEvent->setLocation($location);

        $this->assertSame($location, $this->sportEvent->getLocation());
    }

    //TODO adresse valide avec API

    //Est-ce que SportEvent contient une competition
    public function testCompetitionInputIsReturned(): void
    {
        $competition = 'Super sport 2022';

        $this->sportEvent->setCompetition($competition);

        $this->assertSame($competition, $this->sportEvent->getCompetition());
    }

    /**
     * @note Est-ce que la date est supérieure de 2 jours à la date actuelle
     * @throws Exception
     */
    public function testValidDate(): void
    {
        $date = new DateTime('now', new DateTimeZone('Europe/Paris'));
        $date->add(new DateInterval('P4D'));
        $this->sportEvent->setTimeZone('Europe/Paris');
        $this->sportEvent->setDate($date);

        $violations = $this->validator->validate($this->sportEvent);

        $this->assertSame($date, $this->sportEvent->getDate());
        $this->assertCount(0, $violations);
    }

    /**
     * @note Si la Date n'est pas supérieure à la date actuelle de 2 jours
     * @throws Exception
     */
    public function testInvalidDate(): void
    {
        $date = new DateTime('now', new DateTimeZone('Europe/Paris'));
        $date->add(new DateInterval('P4D'));
        $this->sportEvent->setTimeZone('Jupiter/Mars');
        $this->sportEvent->setDate($date);

        $violations = $this->validator->validate($this->sportEvent);

        $this->assertSame($date, $this->sportEvent->getDate());
        $this->assertGreaterThanOrEqual(1, count($violations));
    }

    //Est-ce que la DateTimeZone est la bonne !

    public function testValidTimeZone(): void
    {
        $timeZone = 'Europe/Paris';
        $this->sportEvent->setTimeZone($timeZone);
        $violations = $this->validator->validate($this->sportEvent);

        $this->assertSame($timeZone, $this->sportEvent->getTimeZone());
        $this->assertCount(0, $violations);
    }

    //Si la Timezone n'est pas celle du SportEvent
    public function testInvalidTimeZone(): void
    {
        $timeZone = 'Pluton/Venus';
        $this->sportEvent->setTimeZone($timeZone);
        $violations = $this->validator->validate($this->sportEvent);

        $this->assertSame($timeZone, $this->sportEvent->getTimeZone());
        $this->assertGreaterThanOrEqual(1, count($violations));
    }
}
