<?php

namespace App\Tests\Entity;

use App\Entity\Athlete;
use App\Tests\GeneralTestMethod;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\Validator\TraceableValidator;

final class AthleteTest extends WebTestCase
{
    private Athlete $athlete;
    private TraceableValidator $validator;

    public function setUp(): void
    {
        $this->athlete = new Athlete();
        $this->validator = GeneralTestMethod::getValidator();
    }

    /** @dataProvider validLastNameProvider */
    public function testValidLastName(string $lastName): void
    {
        $this->athlete->setFirstName('François');
        $this->athlete->setLastName($lastName);
        $this->assertSame($lastName, $this->athlete->getLastName());
        $this->assertCount(0, $this->validator->validate($this->athlete));
    }

    /** @return array<array<string>> */
    public function validLastNameProvider(): array
    {
        return [
            ['Courtier'],
            ['Diminure'],
            ['Rouky'],
            ['Jean-Louis'],
            ['Meheñ'],
            ['Quéré'],
            ['Brivaël'],
            ["Derc'hen"],
            ["Giscard d'Estaing"]
        ];
    }

    /** @dataProvider invalidLastNameProvider */
    public function testInvalidLastName(string $lastName): void
    {
        $this->athlete->setFirstName('François');
        $this->athlete->setLastName($lastName);
        $violations = $this->validator->validate($this->athlete);
        $this->assertGreaterThanOrEqual(1, count($violations));
    }

    /** @return array<array<string>> */
    public function invalidLastNameProvider(): array
    {
        return [
            [''],
            ['45Servat'],
            ['s'],
            ['Slt-'],
            ['arthur&zoe']
        ];
    }

    /** @dataProvider validFirstNameProvider */
    public function testValidFirstName(string $firstName): void
    {
        $this->athlete->setLastName('Dupont');
        $this->athlete->setFirstName($firstName);
        $this->assertSame($firstName, $this->athlete->getFirstName());
        $this->assertCount(0, $this->validator->validate($this->athlete));
    }

    /** @return array<array<string>> */
    public function validFirstNameProvider(): array
    {
        return [
            ['Christine'],
            ['Valérie'],
            ['Romane'],
            ['Jean-Louis'],
            ['Meheñ'],
            ['Quéré'],
            ['Brivaël'],
            ["Derc'hen"],
        ];
    }

    /** @dataProvider invalidFirstNameProvider */
    public function testInvalidFirstName(string $firstName): void
    {
        $this->athlete->setLastName('Dupont');
        $this->athlete->setFirstName($firstName);
        $violations = $this->validator->validate($this->athlete);
        $this->assertGreaterThanOrEqual(1, count($violations));
    }

    /** @return array<array<string>> */
    public function invalidFirstNameProvider(): array
    {
        return [
            [''],
            ['45Servat'],
            ['s'],
            ['Slt-'],
            ['arthur&zoe'],
            ["Giscard d'Estaing"]
        ];
    }
}
