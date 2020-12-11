<?php

namespace App\Tests\Entity;

use App\Entity\SportType;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

class SportTypeTest extends WebTestCase
{
    private function getKernel(): KernelInterface
    {
        $kernel = $this->bootKernel();
        $kernel->boot();
        return $kernel;
    }

    // Doit pouvoir créer une instance de la classe SportType
    public function testCreateSportType(): void
    {
        $sportType = new SportType();

        $this->assertInstanceOf(SportType::class, new SportType());
    }

    // Doit pouvoir ajouter un nom à notre type de sport.

    /** @dataProvider validSportNameProvider */
    public function testSetValidSportName(string $validNameProvider): void
    {
        $sportType = new SportType();
        $sportType->setName($validNameProvider);

        $kernel = $this->getKernel();
        $validator = $kernel->getContainer()->get('validator');
        $violations = $validator->validate($sportType);

        $this->assertCount(0, $violations);
    }

    // Ne doit pas pouvoir ajouter un nom de sport invalide

    /**
     * @dataProvider invalidSportNameProvider
     */
    public function testSetInvalidSportName(string $invalidSportNameProvider): void
    {
        $sportType = new SportType();
        $sportType->setName($invalidSportNameProvider);

        $kernel = $this->getKernel();
        $validator = $kernel->getContainer()->get('validator');
        $violations = $validator->validate($sportType);

        $this->assertGreaterThanOrEqual(1, count($violations));
    }

    public function testSetValidNumberOfActiveAthlete(): void
    {
        $sportType = new SportType();
        $sportType->setNbrOfActiveAthlete(12);

        $kernel = $this->getKernel();
        $validator = $kernel->getContainer()->get('validator');
        $violations = $validator->validate($sportType);

        $this->assertCount(1, $violations);
    }

    public function testSetInvalidNumberOfActiveAthlete(): void
    {
        $sportType = new SportType();

        $sportType->setNbrOfActiveAthlete(20);

        $kernel = $this->getKernel();
        $validator = $kernel->getContainer()->get('validator');
        $violations = $validator->validate($sportType);

        $this->assertGreaterThanOrEqual(1, count($violations));
    }


    public function invalidSportNameProvider(): array
    {
        return [
            ['12Bilboquet'],
            [''],
            ['&Belotte Bretonne'],
            [' '],
            ['a'],
        ];
    }

    public function validSportNameProvider(): array
    {
        return [
            ['Karaté'],
            ["Tir à l'arc"],
            ["Jambon de Bayonne"],
            ["E-Sport"],
            ['Ju-Jitsû'],
        ];
    }
}
