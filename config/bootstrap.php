<?php

declare(strict_types = 1);

namespace Frz;

use Symfony\Component\Dotenv\Dotenv;

$root = dirname(__DIR__);
require $root . '/vendor/autoload.php';

// Load cached env vars if the .env.local.php file exists
// Run "composer dump-env prod" to create it (requires symfony/flex >=1.2)
if (is_array($env = @include $root . '/.env.local.php')) {
    $_SERVER += $env;
    $_ENV    += $env;
} else {
    $loader = new Dotenv();
    $loader->loadEnv($root . '/.env');
}

$env   = $_SERVER['APP_ENV'] ?? $_ENV['APP_ENV'] ?? 'dev';
$debug = $_SERVER['APP_DEBUG'] ?? $_ENV['APP_DEBUG'] ?? $env !== 'prod';
$debug = (int) $debug || filter_var($debug, FILTER_VALIDATE_BOOLEAN) ? '1' : '0';

$_SERVER['APP_ENV']   = $env;
$_SERVER['APP_DEBUG'] = $debug;

$_ENV['APP_ENV']   = $env;
$_ENV['APP_DEBUG'] = $debug;
