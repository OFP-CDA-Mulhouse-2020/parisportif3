<?php

namespace App\DataFixtures;

use App\Entity\BetTemplate;
use App\Entity\SportType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BetTemplateFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var SportType $sportType */
        $sportType = $this->getReference("Football");

        $betTemplate = new BetTemplate();
        $betTemplate->setSportType($sportType);
        $betTemplate->setAbstractBets(
            [
                "RESULTAT_DU_MATCH" => ['%TEAM_ONE%', "Match nul", '%TEAM_TWO%'],
                "NOMBRE_TOTAL_DE_BUT" => ["+0,5", "+1.5", "+2.5", "-0,5", "-1.5", "-2.5"]
            ]
        );

        $manager->persist($betTemplate);

        $manager->flush();
    }


    public function getDependencies(): array
    {
        return array(
            SportTypeFixtures::class,
        );
    }
}