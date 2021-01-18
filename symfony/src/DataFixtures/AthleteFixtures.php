<?php

namespace App\DataFixtures;

use App\Entity\Athlete;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class AthleteFixtures extends Fixture
{
    public const ATHLETE_LIST_REFERENCE = 'athlete-list';

    public function load(ObjectManager $manager): void
    {
        $allAthlete = [];
        for ($i = 0; $i < 20; $i++) {
            $newAthlete = new Athlete();

            $newAthlete->setFirstName(
                "AthleteFirstName" . GeneralFixtureMethod::randomString(5)
            );
            $newAthlete->setLastName(
                "AthleteLastName" . GeneralFixtureMethod::randomString(5)
            );

            $allAthlete[] = $newAthlete;

            $manager->persist($newAthlete);
        }

        $manager->flush();
        $this->addReference(self::ATHLETE_LIST_REFERENCE, (object)$allAthlete);
    }
}
