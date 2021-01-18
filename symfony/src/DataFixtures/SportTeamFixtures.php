<?php

namespace App\DataFixtures;

use App\Entity\SportTeam;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class SportTeamFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $athletesList = (array)$this->getReference(AthleteFixtures::ATHLETE_LIST_REFERENCE);

        for ($i = 0; $i < 5; $i++) {
            $newTeam = new SportTeam();

            $newTeam->setTeamName(
                "TeamName" . GeneralFixtureMethod::randomString(5)
            );

            for ($y = 0; $y < 4; $y++) {
                $newTeam->addAthlete(array_pop($athletesList));
            }

            $manager->persist($newTeam);
        }
        $manager->flush();
    }
}
