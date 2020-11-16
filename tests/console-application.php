<?php

/** @noinspection GlobalVariableUsageInspection */

/** @noinspection PhpIncludeInspection */
/** @noinspection PhpParamsInspection */

/**
 * See why this file at:
 *
 * @link https://github.com/phpstan/phpstan-symfony
 */

use App\Kernel;
use Symfony\Bundle\FrameworkBundle\Console\Application;

require __DIR__ . '/../tests/bootstrap.php';
$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);

return new Application($kernel);
