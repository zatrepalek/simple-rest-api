<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

\UserApi\Configurator::configure($app);

$app->run();
