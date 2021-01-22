<?php

namespace App\DataFixtures;

use App\Entity\Athlete;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class AthleteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            $newAthlete = new Athlete();

            $newAthlete->setFirstName(
                "AthleteFirstNameNoTeam" . GeneralFixtureMethod::randomString(5)
            );
            $newAthlete->setLastName(
                "AthleteLastNameNoTeam" . GeneralFixtureMethod::randomString(5)
            );

            $manager->persist($newAthlete);
        }

        $manager->flush();
    }
}
