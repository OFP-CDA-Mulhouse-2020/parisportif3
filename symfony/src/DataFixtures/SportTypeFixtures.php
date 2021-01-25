<?php

namespace App\DataFixtures;

use App\Entity\SportType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SportTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $foot = new SportType();
        $foot->setName("Football");
        $foot->setNbrOfActiveAthlete(28);
        $this->addReference($foot->getName(), $foot);
        $manager->persist($foot);

        $handball = new SportType();
        $handball->setName("Handball");
        $handball->setNbrOfActiveAthlete(24);
        $manager->persist($handball);

        $tennis = new SportType();
        $tennis->setName("Tennis");
        $tennis->setNbrOfActiveAthlete(2);
        $manager->persist($tennis);

        $basket = new SportType();
        $basket->setName("Basket");
        $basket->setNbrOfActiveAthlete(20);
        $manager->persist($basket);

        $manager->flush();
    }
}
