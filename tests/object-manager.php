<?php

/** @noinspection GlobalVariableUsageInspection */

/** @noinspection PhpIncludeInspection */
/** @noinspection PhpParamsInspection */

/**
 * See why this file at:
 *
 * @link https://github.com/phpstan/phpstan-doctrine
 */

use App\Kernel;

require __DIR__ . '/../tests/bootstrap.php';
$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$kernel->boot();

return $kernel->getContainer()->get('doctrine')->getManager();
