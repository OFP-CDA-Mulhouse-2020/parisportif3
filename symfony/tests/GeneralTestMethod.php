<?php

namespace App\Tests;

use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
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

    /** @param ConstraintViolationListInterface<ConstraintViolationInterface> $violationsList */
    public static function isViolationOn(
        string $testedAttribute,
        ConstraintViolationListInterface $violationsList
    ): bool {
        $violationsCount = count($violationsList);

        for ($i = 0; $i < $violationsCount; $i++) {
            if ($violationsList->get($i)->getPropertyPath() === $testedAttribute) {
                return true;
            }
        }

        return false;
    }

    public static function getEntityManager(): ObjectManager
    {
        return self::getKernel()
            ->getContainer()
            ->get('doctrine')
            ->getManager();
    }
}
