<?php

declare(strict_types = 1);

namespace Free2er;

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

if (file_exists($envFile = dirname(__DIR__) . '/.env')) {
    $envLoader = new Dotenv(false);
    $envLoader->loadEnv($envFile);
}

$_SERVER += $_ENV;

$env = $_SERVER['APP_ENV'] ?? $_ENV['APP_ENV'] ?? null;
$env = $env ?: 'dev';

$debug = $_SERVER['APP_DEBUG'] ?? $_ENV['APP_DEBUG'] ?? $env !== 'prod';
$debug = (int) $debug || filter_var($debug, FILTER_VALIDATE_BOOLEAN) ? '1' : '0';

$_SERVER['APP_ENV'] = $env;
$_ENV['APP_ENV']    = $env;

$_SERVER['APP_DEBUG'] = $debug;
$_ENV['APP_DEBUG']    = $debug;
