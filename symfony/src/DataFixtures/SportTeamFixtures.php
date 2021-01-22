<?php

namespace App\DataFixtures;

use App\Entity\Athlete;
use App\Entity\SportTeam;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class SportTeamFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $athletesList = [];
        for ($i = 0; $i < 20; $i++) {
            $newAthlete = new Athlete();

            $newAthlete->setFirstName(
                "AthleteFirstNameTeam" . GeneralFixtureMethod::randomString(5)
            );
            $newAthlete->setLastName(
                "AthleteLastNameTeam" . GeneralFixtureMethod::randomString(5)
            );

            $athletesList[] = $newAthlete;

            $manager->persist($newAthlete);
        }

        for ($i = 0; $i < 5; $i++) {
            $newTeam = new SportTeam();

            $newTeam->setTeamName(
                "TeamName" . GeneralFixtureMethod::randomString(5)
            );

            for ($y = 0; $y < 4; $y++) {
                $athlete = array_pop($athletesList);
                if (!is_null($athlete)) {
                    $newTeam->addAthlete($athlete);
                }
            }

            $manager->persist($newTeam);
        }
        $manager->flush();
    }
}
