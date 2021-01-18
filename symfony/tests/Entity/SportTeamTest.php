<?php

namespace App\Tests\Entity;

use App\Entity\Athlete;
use App\Entity\SportTeam;
use App\Tests\GeneralTestMethod;
use Generator;
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
        $violationOnAttribute = GeneralTestMethod::isViolationOn("teamName", $violations);

        $this->assertSame($teamName, $this->team->getTeamName());
        $this->assertFalse($violationOnAttribute);
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
        $violationOnAttribute = GeneralTestMethod::isViolationOn("teamName", $violations);

        $this->assertGreaterThanOrEqual(1, count($violations));
        $this->assertTrue($violationOnAttribute);
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

    /** @dataProvider validAthleteProvider */
    public function testAddValidAthleteToTeam(Athlete $newValidAthlete): void
    {
        $this->team->addAthlete($newValidAthlete);

        $violations = $this->validator->validate($this->team);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("athletesList", $violations);

        $this->assertContains($newValidAthlete, $this->team->listAthletes());
        $this->assertFalse($violationOnAttribute);
    }

    /** @dataProvider validAthleteProvider */
    public function testRemoveValidAthleteToTeam(Athlete $oldValidAthlete): void
    {
        $this->team->addAthlete($oldValidAthlete);
        $this->assertContains($oldValidAthlete, $this->team->listAthletes());
        $this->team->removeAthlete($oldValidAthlete);

        $violations = $this->validator->validate($this->team);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("athletesList", $violations);

        $this->assertNotContains($oldValidAthlete, $this->team->listAthletes());
        $this->assertFalse($violationOnAttribute);
    }

    /** @return Generator<array<int, Athlete>> */
    public function validAthleteProvider(): Generator
    {
        yield [(new Athlete())->setFirstName("John")->setLastName("Michel")];
        yield [(new Athlete())->setFirstName("Lucas")->setLastName("Testiana")];
        yield [(new Athlete())->setFirstName("Bernard")->setLastName("Huger")];
    }

    /** @dataProvider invalidAthleteProvider */
    public function testAddInvalidAthleteToTeam(Athlete $newInvalidAthlete): void
    {
        $this->team->addAthlete($newInvalidAthlete);

        $violations = $this->validator->validate($this->team);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("athletesList", $violations);

        $this->assertTrue($violationOnAttribute);
    }

    /** @return Generator<array<int, Athlete>> */
    public function invalidAthleteProvider(): Generator
    {
        yield [new Athlete()];
        yield [(new Athlete())->setFirstName("John")];
        yield [(new Athlete())->setLastName("Varosa")];
        yield [(new Athlete())->setFirstName("")->setLastName("Varosa")];
        yield [(new Athlete())->setLastName("")->setFirstName("John")];
        yield [(new Athlete())->setLastName("")->setFirstName("")];
        yield [(new Athlete())->setLastName("6545364")->setFirstName("4565456")];
    }
}
