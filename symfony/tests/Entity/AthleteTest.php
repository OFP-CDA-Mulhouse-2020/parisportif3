<?php

namespace App\Tests\Entity;

use App\Entity\Athlete;
use App\Tests\GeneralTestMethod;
use Generator;
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

        $this->athlete->setFirstName("François");
        $this->athlete->setLastName("Dupont");
    }

    /** @dataProvider validLastNameProvider */
    public function testValidLastName(string $validLastName): void
    {
        $this->athlete->setLastName($validLastName);

        $violations = $this->validator->validate($this->athlete);
        $violationOnLastName = GeneralTestMethod::isViolationOn("lastName", $violations);
        $obtainedLastName = $this->athlete->getLastName();

        $this->assertSame($validLastName, $obtainedLastName, "$obtainedLastName is not the same than $validLastName");
        $this->assertFalse($violationOnLastName, "$validLastName is a valid lastname, it should pass");
    }

    /** @return Generator<array<string>> */
    public function validLastNameProvider(): Generator
    {
        yield ["Courtier"];
        yield ["Diminure"];
        yield ["Rouky"];
        yield ["Jean-Louis"];
        yield ["Meheñ"];
        yield ["Quéré"];
        yield ["Brivaël"];
        yield ["Derc'hen"];
        yield ["Quéré"];
        yield ["Giscard d'Estaing"];
    }

    /** @dataProvider invalidLastNameProvider */
    public function testInvalidLastName(string $invalidLastName): void
    {
        $this->athlete->setLastName($invalidLastName);

        $violations = $this->validator->validate($this->athlete);
        $violationOnLastName = GeneralTestMethod::isViolationOn("lastName", $violations);

        $this->assertGreaterThanOrEqual(1, count($violations));
        $this->assertTrue($violationOnLastName, "$invalidLastName is a not valid lastname, it shouldn't pass");
    }

    /** @return Generator<array<string>> */
    public function invalidLastNameProvider(): Generator
    {
        yield [""];
        yield ["45Servat"];
        yield ["s"];
        yield ["Slt-"];
        yield ["arthur&zoe"];
    }

    /** @dataProvider validFirstNameProvider */
    public function testValidFirstName(string $validFirstName): void
    {
        $this->athlete->setFirstName($validFirstName);

        $violations = $this->validator->validate($this->athlete);
        $violationOnFirstName = GeneralTestMethod::isViolationOn("firstName", $violations);
        $obtainedFirstName = $this->athlete->getFirstName();

        $this->assertSame(
            $validFirstName,
            $obtainedFirstName,
            "$obtainedFirstName is not the same than $validFirstName"
        );
        $this->assertFalse($violationOnFirstName, "$validFirstName is a valid firstname, it should pass");
    }

    /** @return Generator<array<string>> */
    public function validFirstNameProvider(): Generator
    {
        yield ['Christine'];
        yield ['Valérie'];
        yield ['Romane'];
        yield ['Jean-Louis'];
        yield ['Meheñ'];
        yield ['Quéré'];
        yield ['Brivaël'];
        yield ["Derc'hen"];
    }

    /** @dataProvider invalidFirstNameProvider */
    public function testInvalidFirstName(string $invalidFirstName): void
    {
        $this->athlete->setFirstName($invalidFirstName);

        $violations = $this->validator->validate($this->athlete);
        $violationOnAttribute = GeneralTestMethod::isViolationOn("firstName", $violations);


        $this->assertGreaterThanOrEqual(1, count($violations));
        $this->assertTrue($violationOnAttribute, "$invalidFirstName is a not valid, it shouldn't pass");
    }

    /** @return Generator<array<string>> */
    public function invalidFirstNameProvider(): Generator
    {
        yield [''];
        yield ['45Servat'];
        yield ['s'];
        yield ['Slt-'];
        yield ['arthur&zoe'];
        yield ["Giscard d'Estaing"];
    }
}
