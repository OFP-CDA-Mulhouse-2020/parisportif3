<?php

namespace App\DataFixtures;

use App\Entity\SportTeam;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SportTeamFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i <= 10; $i++) {
            $team = new SportTeam();
            $team->setTeamName("TeamBidon_" . $i);
            $this->addReference("Team_" . $i, $team);
            $manager->persist($team);
        }

        $manager->flush();
    }
}
