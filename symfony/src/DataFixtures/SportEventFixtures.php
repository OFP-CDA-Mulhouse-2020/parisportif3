<?php

namespace App\DataFixtures;

use App\Entity\SportEvent;
use App\Entity\SportTeam;
use App\Entity\SportType;
use DateInterval;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;

class SportEventFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * @param ObjectManager $manager
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        /** @var SportType $footRef */
        $footRef = $this->getReference("Football");
        /** @var SportTeam $teamOne */
        $teamOne = $this->getReference("Team_01");
        /** @var SportTeam $teamTwo */
        $teamTwo = $this->getReference("Team_02");

        $sportEvent = new SportEvent();
        $sportEvent->setDate((new DateTime("now"))->add(new DateInterval("P10D")));
        $sportEvent->setSportType($footRef);
        $sportEvent->setLocation("Mulhouse, France");
        $sportEvent->setTimeZone("Europe/Paris");
        $sportEvent->setCompetition("Ligue 1");
        $sportEvent->addSportTeam($teamOne);
        $sportEvent->addSportTeam($teamTwo);


        $manager->persist($sportEvent);
        $manager->flush();
    }


    public function getDependencies(): array
    {
        return array(
            SportTypeFixtures::class,
            SportTeamFixtures::class
        );
    }
}
