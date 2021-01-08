<?php

namespace App\Tests\Entity;

use App\Entity\SportType;
use App\Tests\GeneralTestMethod;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\Validator\TraceableValidator;

final class SportTypeTest extends WebTestCase
{
    private TraceableValidator $validator;

    public function setUp(): void
    {
        $this->validator = GeneralTestMethod::getValidator();
    }

    // Doit pouvoir créer une instance de la classe SportType
    public function testCreateSportType(): void
    {
        $this->assertInstanceOf(SportType::class, new SportType());
    }

    // Doit pouvoir ajouter un nom à notre type de sport.
    /** @dataProvider validSportNameProvider */
    public function testSetValidSportName(string $validNameProvider): void
    {
        $sportType = new SportType();
        $sportType->setName($validNameProvider);

        $this->assertCount(0, $this->validator->validate($sportType));
    }

    // Ne doit pas pouvoir ajouter un nom de sport invalide

    /**
     * @dataProvider invalidSportNameProvider
     */
    public function testSetInvalidSportName(string $invalidSportNameProvider): void
    {
        $sportType = new SportType();
        $sportType->setName($invalidSportNameProvider);

        $this->assertGreaterThanOrEqual(1, count($this->validator->validate($sportType)));
    }

    public function testSetValidNumberOfActiveAthlete(): void
    {
        $sportType = new SportType();
        $sportType->setNbrOfActiveAthlete(12);

        $this->assertCount(1, $this->validator->validate($sportType));
    }

    public function testSetInvalidNumberOfActiveAthlete(): void
    {
        $sportType = new SportType();
        $sportType->setNbrOfActiveAthlete(20);

        $this->assertGreaterThanOrEqual(1, count($this->validator->validate($sportType)));
    }

    /** @return array<array<string>> */
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

    /** @return array<array<string>> */
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
