<?php

namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Validator\Validator\TraceableValidator;

final class GeneralTestMethod extends WebTestCase
{
    public static function getKernel(): KernelInterface
    {
        $kernel = self::bootKernel();
        $kernel->boot();
        return $kernel;
    }

    /** @return TraceableValidator */
    public static function getValidator(): object
    {
        return self::getKernel()->getContainer()->get('validator');
    }

    public static function getClient(): KernelBrowser
    {
        return self::createClient();
    }
}
