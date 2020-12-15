<?php

namespace App\Tests\Entity;

use App\Entity\BetTemplate;
use App\Tests\GeneralTestMethod;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\Validator\TraceableValidator;

final class BetTemplateTest extends WebTestCase
{
    private TraceableValidator $validator;
    private BetTemplate $template;

    public function setUp(): void
    {
        $this->template = new BetTemplate();
        $this->validator = GeneralTestMethod::getKernelAndValidator()['validator'];
    }

    public function testBetTemplateClassExist(): void
    {
        $this->assertInstanceOf(BetTemplate::class, $this->template);
    }
}
