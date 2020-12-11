<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class GeneralTestMethod extends KernelTestCase
{
    /**
     * @return array{
     *      kernel:\Symfony\Component\HttpKernel\KernelInterface,
     *      validator:\Symfony\Component\Validator\Validator\TraceableValidator
     * }
     */
    public static function getKernelAndValidator(): array
    {
        $kernel = self::bootKernel();
        $kernel->boot();

        $validator = $kernel->getContainer()->get('validator');
        return [
            "kernel" => $kernel,
            "validator" => $validator
        ];
    }
}
