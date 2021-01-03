<?php

/**
 * @author  Etienne Schmitt <etienne@schmitt-etienne.fr>
 * @license GPL 2.0 or any later
 */

namespace App\Tests\Entity;

use App\Tests\GeneralTestMethod;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\Validator\TraceableValidator;

final class ReceiptTest extends WebTestCase
{
    private Receipt $receipt;
    private TraceableValidator $validator;

    public function setUp(): void
    {
        $this->receipt = new Receipt();
        $this->validator = GeneralTestMethod::getKernelAndValidator()['validator'];
    }
}
