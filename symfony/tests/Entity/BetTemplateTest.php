<?php

namespace App\Tests\Entity;

use App\Entity\BetTemplate;
use App\Tests\GeneralTestMethod;
use Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\Validator\TraceableValidator;

final class BetTemplateTest extends WebTestCase
{
    private TraceableValidator $validator;
    private BetTemplate $template;

    public function setUp(): void
    {
        $this->template = new BetTemplate();
        $this->validator = GeneralTestMethod::getValidator();
    }

    public function testBetTemplateClassExist(): void
    {
        $this->assertInstanceOf(BetTemplate::class, $this->template);
    }

    /**
     * @dataProvider validBetTemplate
     * @param array<string, array<string, array<string>>> $template
     */
    public function testValidBetTemplateDescription(array $template): void
    {
        $this->template->setDescription($template);
        $violations = $this->validator->validate($template);

        $this->assertCount(0, $violations);
    }

    /** @return array<array<array<string, array<string, array<string>>>>> */
    public function validBetTemplate(): array
    {
        return [
            [
                [
                    "BET_LIST" => [
                        "RÉSULTAT DU MATCH" => ['%TEAM_ONE%', "Match nul", '%TEAM_TWO%'],
                        "NOMBRE TOTAL DE BUTS" => [
                            "+ de 0,5",
                            "- de 0,5",
                            "+ de 1,5",
                            "- de 1,5",
                            "+ de 2,5",
                            "- de 2,5",
                            "+ de 3,5",
                            "- de 3,5",
                            "+ de 4,5",
                            "- de 4,5"
                        ],
                        "BUT POUR LES 2 ÉQUIPES" => ["Oui", "Non"]
                    ]
                ]
            ],
            [
                [
                    "BET_LISTE" => [
                        "RÉSULTAT DU MATCH" => ['%TEAM_ONE%', "Match nul", '%TEAM_TWO%'],
                        "NOMBRE TOTAL DE POINTS" => [
                            "+ de 165,5",
                            "- de 165,5",
                            "+ de 164,5",
                            "- de 164,5",
                            "+ de 163,5",
                            "- de 163,5",
                            "+ de 162,5",
                            "- de 162,5",
                            "+ de 161,5",
                            "- de 161,5",
                            "+ de 160,5",
                            "- de 160,5",
                            "+ de 159,5",
                            "- de 159,5",
                            "+ de 158,5",
                            "- de 158,5",
                            "+ de 157,5",
                            "- de 157,5",
                            "+ de 156,5",
                            "- de 156,5",
                            "+ de 155,5",
                            "- de 155,5"
                        ],
                        "PROLONGATIONS" => ["Oui", "Non"]
                    ]
                ]
            ]
        ];
    }

    /**
     * @dataProvider invalidBetTemplate
     * @param array<string, array<string, array<string>>> $template
     */
    public function testInvalidBetTemplateDescription(array $template): void
    {
        $this->template->setDescription($template);
        $violations = $this->validator->validate($this->template);

        $this->assertGreaterThanOrEqual(1, count($violations));
    }

    /**
     * @return Generator<array<array<string|bool|null|int|array<string|array<string>>>>>
     */
    public function invalidBetTemplate(): Generator
    {
        yield [[]];
        yield [[null]];
        yield [[false]];
        yield [[13]];
        yield [["bonjour"]];
        yield [
            [
                "RÉSULTAT DU MATCH" => ['%TEAM_ONE%', "Match nul", '%TEAM_TWO%'],
                "NOMBRE TOTAL DE BUTS" => [
                    "+ de 0,5",
                    "- de 0,5",
                    "+ de 1,5",
                    "- de 1,5",
                    "+ de 2,5",
                    "- de 2,5",
                    "+ de 3,5",
                    "- de 3,5",
                    "+ de 4,5",
                    "- de 4,5"
                ],
                "BUT POUR LES 2 ÉQUIPES" => ["Oui", "Non"]
            ]
        ];
        yield [["BET_LISTE" => []]];
        yield [
            [
                "abcdef" => [
                    "RÉSULTAT DU MATCH" => ['%TEAM_ONE%', "Match nul", '%TEAM_TWO%'],
                    "NOMBRE TOTAL DE BUTS" => [
                        "+ de 0,5",
                        "- de 0,5",
                        "+ de 1,5",
                        "- de 1,5",
                        "+ de 2,5",
                        "- de 2,5",
                        "+ de 3,5",
                        "- de 3,5",
                        "+ de 4,5",
                        "- de 4,5"
                    ],
                    "BUT POUR LES 2 ÉQUIPES" => ["Oui", "Non"]
                ]
            ]
        ];
    }
}
