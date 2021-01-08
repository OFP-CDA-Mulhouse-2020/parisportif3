<?php

namespace App\Tests\Entity;

use App\Entity\SportTeam;
use App\Tests\GeneralTestMethod;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\Validator\TraceableValidator;

final class SportTeamTest extends WebTestCase
{
    private TraceableValidator $validator;
    private SportTeam $team;

    public function setUp(): void
    {
        $this->validator = GeneralTestMethod::getValidator();
        $this->team = new SportTeam();
    }

    public function testSportTeamClassExist(): void
    {
        $this->assertInstanceOf(SportTeam::class, $this->team);
    }

    /** @dataProvider validTeamNameProvider */
    public function testSportTeamNameValid(string $teamName): void
    {
        $this->team->setTeamName($teamName);

        $violations = $this->validator->validate($this->team);
        $this->assertSame($teamName, $this->team->getTeamName());
        $this->assertCount(0, $violations);
    }

    /** @return array<array<string>> */
    public function validTeamNameProvider(): array
    {
        return [
            ["Pani'nini"],
            ['Buccaneers'],
            ['Steel-ers'],
            ['Vikings'],
            ['49ers'],
            ['K Sport']
        ];
    }

    /** @dataProvider invalidTeamNameProvider */
    public function testSportTeamNameInvalid(string $teamName): void
    {
        $this->team->setTeamName($teamName);

        $violations = $this->validator->validate($this->team);
        $this->assertSame($teamName, $this->team->getTeamName());
        $this->assertGreaterThanOrEqual(1, count($violations));
    }

    /** @return array<array<string>> */
    public function invalidTeamNameProvider(): array
    {
        return [
            [' '],
            [''],
//            ['4612'],
            ['!@#$%^'],
            ['P']
        ];
    }

    //TODO Ajouter la relation avec Athlete

    //TODO Ajouter la relation avec SportEvent
}
