<?php

namespace App\Tests\Entity;

use App\Entity\BetTemplateChoice;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BetTemplateChoiceTest extends WebTestCase
{
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
        $BetTemplateChoice = new BetTemplateChoice();
        $UpdatedBetTemplateChoice = [
            "Équipe 1" => "Marseille",
            "Équipe 2" => "PSG",
            "Résultat" => "1 Gagne"
        ];

        $BetTemplateChoice->updateDescription($UpdatedBetTemplateChoice);
    }
}