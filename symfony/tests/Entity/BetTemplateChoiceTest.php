<?php

namespace App\Tests\Entity;

use App\Entity\BetTemplateChoice;
use App\Tests\GeneralTestMethod;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\Validator\TraceableValidator;

final class BetTemplateChoiceTest extends WebTestCase
{
    private BetTemplateChoice $betTemplateChoice;
    private TraceableValidator $validator;

    public function setUp(): void
    {
        $this->validator = GeneralTestMethod::getValidator();
        $this->betTemplateChoice = new BetTemplateChoice();
    }

    //Doit pouvoir créer une instance de la classe BetTemplateChoice
    public function testCreateBetTemplateChoiceObject(): void
    {
        $this->assertInstanceOf(
            BetTemplateChoice::class,
            new BetTemplateChoice()
        );
    }

    //Doit mettre à jour une description
    public function testCanUpdateBetTemplateChoice(): void
    {
        $UpdatedBetTemplateChoice = [
            "Équipe 1" => "Marseille",
            "Équipe 2" => "PSG",
            "Résultat" => "1 Gagne"
        ];

        $violations = $this->validator->validate($this->betTemplateChoice);
        $this->betTemplateChoice->updateDescription($UpdatedBetTemplateChoice);

        $this->assertCount(0, $violations);
    }
}
